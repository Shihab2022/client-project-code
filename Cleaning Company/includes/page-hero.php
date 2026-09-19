<?php
/**
 * =====================================================================
 *  INNER PAGE HERO  (reusable: breadcrumbs + H1 + intro + CTAs + image)
 * =====================================================================
 *  Options:
 *    $hero['eyebrow']        Small label above the H1
 *    $hero['title']          H1 text
 *    $hero['text']           Supporting paragraph
 *    $hero['image']          Image path (optional)
 *    $hero['image_alt']      ALT text for that image
 *    $hero['points']         Array of short bullet points (optional)
 *    $hero['whatsapp']       Contextual WhatsApp message
 *    $hero['show_breadcrumbs'] Force breadcrumbs on/off (default: when set)
 * =====================================================================
 */

if (!function_exists('t')) {
    require_once __DIR__ . '/bootstrap.php';
}

$hero       = is_array($hero ?? null) ? $hero : [];
$heroWa     = (string) ($hero['whatsapp'] ?? whatsapp_quote_message());
$heroPoints = (array) ($hero['points'] ?? []);
$heroImage  = (string) ($hero['image'] ?? '');
?>
<section class="page-hero<?= $heroImage !== '' ? ' page-hero--media' : '' ?>">
    <div class="container page-hero__inner">
        <div class="page-hero__content">
            <?php if (!empty($hero['eyebrow'])) : ?>
                <p class="eyebrow eyebrow--light"><?= icon('sparkle', 'eyebrow__icon', 18) ?><?= e((string) $hero['eyebrow']) ?></p>
            <?php endif; ?>
            <h1 class="page-hero__title"><?= e((string) ($hero['title'] ?? '')) ?></h1>
            <?php if (!empty($hero['text'])) : ?>
                <p class="page-hero__text"><?= e((string) $hero['text']) ?></p>
            <?php endif; ?>

            <?php if ($heroPoints) : ?>
                <ul class="page-hero__points">
                    <?php foreach ($heroPoints as $point) : ?>
                        <li><?= icon('check', 'page-hero__check', 18) ?><span><?= e((string) $point) ?></span></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="page-hero__actions">
                <?= wa_button($heroWa, t('cta.whatsapp_us'), 'whatsapp', ['class' => 'btn--lg']) ?>
                <?= call_button(t('cta.call_now'), 'light', ['class' => 'btn--lg']) ?>
            </div>
        </div>

        <?php if ($heroImage !== '') : ?>
        <div class="page-hero__media">
            <?= img_tag([
                'src'        => $heroImage,
                'alt'        => (string) ($hero['image_alt'] ?? $hero['title'] ?? ''),
                'responsive' => true,
                'eager'      => !empty($hero['eager']),
                'class'      => 'page-hero__img',
                'sizes'      => '(max-width: 899px) 92vw, 560px',
            ]) ?>
        </div>
        <?php endif; ?>
    </div>
</section>