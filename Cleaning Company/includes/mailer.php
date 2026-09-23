<?php
/**
 * =====================================================================
 *  MAILER  —  sends the contact form inquiry to the company inbox
 * =====================================================================
 *  Two transports, switchable from config/config.php:
 *    MAIL_METHOD = 'mail'  -> PHP mail()
 *    MAIL_METHOD = 'smtp'  -> minimal SMTP client (STARTTLS / SMTPS + AUTH)
 *  Nothing is ever written to a database, a file log or the session.
 * =====================================================================
 */

/**
 * Send one inquiry notification.
 *
 * @param array $fields Already sanitized values.
 * @return array{0:bool,1:string} [success, error key]
 */
function send_inquiry(array $fields): array
{
    if (MAIL_METHOD === 'smtp' && SMTP_HOST !== '') {
        return send_inquiry_smtp($fields);
    }

    return send_inquiry_mail($fields);
}

/** Assemble the notification subject. */
function inquiry_subject(array $fields): string
{
    $service = $fields['service'] !== '' ? $fields['service'] : 'General inquiry';
    $area    = $fields['area'] !== '' ? $fields['area'] : 'Kuwait';

    return 'New cleaning inquiry: ' . $service . ' – ' . $area;
}

/** Plain text body (readable in every mail client). */
function inquiry_body(array $fields): string
{
    $lines = [
        'New inquiry received from the website contact form.',
        '',
        'Name ............ ' . $fields['name'],
                'Phone ........... ' . $fields['phone'],
        'Service ......... ' . ($fields['service'] !== '' ? $fields['service'] : '-'),
        'Area in Kuwait .. ' . ($fields['area'] !== '' ? $fields['area'] : '-'),
        'Preferred contact ' . ($fields['contact_method'] !== '' ? $fields['contact_method'] : '-'),
        'Language ........ ' . $fields['lang'],
        'Sent from ....... ' . $fields['page'],
        'Received ........ ' . date('Y-m-d H:i:s'),
        '',
        'Message:',
        $fields['message'] !== '' ? $fields['message'] : '(no message)',
        '',
        '--------------------------------------------------',
        'Reply directly to this e-mail to answer the customer,',
        'or contact them on WhatsApp / by phone.',
    ];

    return implode("\n", $lines);
}

/** Clean, injection safe header value. */
function mail_header_value(string $value): string
{
    return trim(str_replace(["\r", "\n", "%0a", "%0d"], '', $value));
}

/** RFC 2047 encode a header when it contains non ASCII characters. */
function mail_encode_header(string $value): string
{
    return preg_match('/[\x80-\xFF]/', $value) ? mb_encode_mimeheader($value, 'UTF-8', 'B', "\r\n") : $value;
}

/** Transport 1: PHP mail(). */
function send_inquiry_mail(array $fields): array
{
    $to       = mail_header_value(CONTACT_RECIPIENT);
    $from     = mail_header_value(MAIL_FROM);
    $fromName = mail_header_value(MAIL_FROM_NAME);

    if (!is_valid_email($to) || !is_valid_email($from)) {
        return [false, 'mail_not_configured'];
    }

    $subject = mail_encode_header(inquiry_subject($fields));
    $body    = inquiry_body($fields);

    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: 8bit',
        'From: ' . mail_encode_header($fromName) . ' <' . $from . '>',
        'Return-Path: ' . $from,
    ];
    if (is_valid_email($fields['email'])) {
        $headers[] = 'Reply-To: ' . mail_encode_header(mail_header_value($fields['name']))
            . ' <' . mail_header_value($fields['email']) . '>';
    }

    $sent = @mail($to, $subject, $body, implode("\r\n", $headers));

    return $sent ? [true, ''] : [false, 'mail_failed'];
}

/** Transport 2: minimal, dependency free SMTP client. */
function send_inquiry_smtp(array $fields): array
{
    $host   = SMTP_HOST;
    $port   = SMTP_PORT > 0 ? SMTP_PORT : 587;
    $secure = strtolower(SMTP_SECURE) === 'ssl' ? 'ssl' : 'tls';
    $error  = '';
    $socket = false;

    try {
        $context = stream_context_create(['ssl' => ['verify_peer' => true, 'verify_peer_name' => true]]);
        $target  = ($secure === 'ssl' ? 'ssl://' : 'tcp://') . $host . ':' . $port;
        $socket  = @stream_socket_client($target, $errno, $errstr, SMTP_TIMEOUT, STREAM_CLIENT_CONNECT, $context);
        if (!$socket) {
            return [false, 'smtp_connect_failed'];
        }
        stream_set_timeout($socket, SMTP_TIMEOUT);

        if (smtp_expect($socket, '220', $error) === false) {
            throw new RuntimeException($error);
        }
        smtp_command($socket, 'EHLO ' . smtp_client_host(), $error);

        if ($secure === 'tls') {
            if (smtp_command($socket, 'STARTTLS', $error) === false) {
                throw new RuntimeException($error);
            }
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                throw new RuntimeException('smtp_tls_failed');
            }
            smtp_command($socket, 'EHLO ' . smtp_client_host(), $error);
        }

        if (SMTP_USER !== '' && SMTP_PASS !== '') {
            if (smtp_command($socket, 'AUTH LOGIN', $error) === false) {
                throw new RuntimeException($error);
            }
            smtp_command($socket, base64_encode(SMTP_USER), $error);
            if (smtp_command($socket, base64_encode(SMTP_PASS), $error) === false) {
                throw new RuntimeException($error);
            }
        }

        $from = mail_header_value(MAIL_FROM);
        if (smtp_command($socket, 'MAIL FROM:<' . $from . '>', $error) === false) {
            throw new RuntimeException($error);
        }
        if (smtp_command($socket, 'RCPT TO:<' . mail_header_value(CONTACT_RECIPIENT) . '>', $error) === false) {
            throw new RuntimeException($error);
        }
        if (smtp_command($socket, 'DATA', $error) === false) {
            throw new RuntimeException($error);
        }

        $headers = [
            'Date: ' . date('r'),
            'From: ' . mail_encode_header(mail_header_value(MAIL_FROM_NAME)) . ' <' . $from . '>',
            'To: <' . mail_header_value(CONTACT_RECIPIENT) . '>',
            'Subject: ' . mail_encode_header(inquiry_subject($fields)),
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=UTF-8',
            'Content-Transfer-Encoding: 8bit',
                ];

        // Dot-stuffing keeps the message body intact inside the DATA block.
        $body = preg_replace('/^\./m', '..', inquiry_body($fields)) ?? inquiry_body($fields);
        $data = implode("\r\n", $headers) . "\r\n\r\n" . str_replace("\n", "\r\n", $body) . "\r\n.";

        fwrite($socket, $data . "\r\n");
        if (smtp_expect($socket, '250', $error) === false) {
            throw new RuntimeException($error);
        }
        smtp_command($socket, 'QUIT', $error);
    } catch (Throwable $e) {
        if ($socket) {
            @fclose($socket);
        }

        return [false, 'smtp_failed'];
    }

    if ($socket) {
        @fclose($socket);
    }

    return [true, ''];
}

/** Send one SMTP command and require a positive reply. */
function smtp_command($socket, string $command, string &$error): bool
{
    fwrite($socket, $command . "\r\n");

    return smtp_expect($socket, '', $error);
}

/** Read one (possibly multi line) SMTP reply and check the expected code. */
function smtp_expect($socket, string $expected, string &$error): bool
{
    $response = '';
    while (($line = fgets($socket, 515)) !== false) {
        $response .= $line;
        if (strlen($line) < 4 || $line[3] === ' ') {
            break;
        }
    }
    $code = substr($response, 0, 3);
    if ($code === '' || (int) $code >= 400) {
        $error = 'smtp_error_' . $code;

        return false;
    }
    if ($expected !== '' && $code !== $expected) {
        $error = 'smtp_unexpected_reply_' . $code;

        return false;
    }

    return true;
}

/** HELO/EHLO host name. */
function smtp_client_host(): string
{
    $host = parse_url(SITE_URL, PHP_URL_HOST);

    return is_string($host) && $host !== '' ? $host : 'localhost';
}