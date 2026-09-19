# Cleaning Company Website — Kuwait

A complete, production-ready marketing website for a professional cleaning
company in Kuwait. Built with **PHP 8+, HTML5, CSS3 and vanilla JavaScript**.

* No database, no login, no online booking, no payment system.
* Conversions happen on **WhatsApp** and by **direct phone call**.
* Optional e-mail contact form (nothing is stored — it is validated,
  sanitized and e-mailed to the company inbox).

---

## 1. Quick start

Requirements: any PHP 8+ host (Apache with `mod_rewrite` recommended,
also runs on Nginx + PHP-FPM, cPanel, shared hosting, VPS).

1. Upload the project folder to your web root (or a sub-directory —
   the base path is detected automatically).
2. Make sure the web server can serve `index.php` as the default page.
3. Open the site — the language-prefixed URL `/en/` (or `/ar/`) is used
   automatically. Bare URLs such as `/about.php` are 301-redirected to
   their language-prefixed version.

**Web server configuration**

| Server | File to use |
|---|---|
| Apache / cPanel / shared hosting | `.htaccess` (already included — nothing to do) |
| Nginx + PHP-FPM | copy the rewrite rules from `deploy/nginx.conf.example` |

The website works **without** any rewrite rules too: every page is a
normal `.php` file, so `about.php`, `services/villa-cleaning.php` and
`areas/salmiya.php` are all reachable directly. The rewrite rules only
add the clean, extension-less and language-prefixed URL forms.

**Local development (no Apache needed)**

```bash
php -S 127.0.0.1:8000 tools/dev-router.php
```

`tools/dev-router.php` mirrors the `.htaccess` rules so that clean URLs,
language prefixes, `/sitemap.xml` and `/robots.txt` all behave the same
as on production. Do not deploy it as a public entry point — the
`tools/` folder is already blocked from web access.

---

## 2. Configure the business information (one file)

**All** business details live in one place:

```
config/config.php
```

Replace the placeholders there:

| Constant | Meaning |
|---|---|
| `COMPANY_NAME` / `COMPANY_LEGAL_NAME` / `COMPANY_SHORT_NAME` | Brand names |
| `COMPANY_PHONE` / `COMPANY_PHONE_E164` | Display phone / `tel:` number |
| `COMPANY_WHATSAPP` | WhatsApp number in international format, e.g. `96512345678` |
| `COMPANY_EMAIL` | Public e-mail address |
| `COMPANY_ADDRESS` / `COMPANY_CITY` / `COMPANY_POSTAL_CODE` | Postal address |
| `COMPANY_GOOGLE_MAPS_URL` / `COMPANY_MAP_EMBED_URL` | Google Maps link / embed |
| `COMPANY_WORKING_HOURS` / `COMPANY_OPENING_HOURS` | Display hours / machine-readable hours |
| `COMPANY_INSTAGRAM` / `COMPANY_FACEBOOK` / `COMPANY_TIKTOK` | Social profile URLs |
| `COMPANY_STATS` | Homepage/About statistics |
| `SITE_URL` | Production URL, e.g. `https://www.example.com` |
| `URL_LANG_MODE` | `prefixed` (`/en/…`) or `query` (`?lang=en`) |
| `MAIL_METHOD`, `MAIL_FROM`, `CONTACT_RECIPIENT` | Contact-form e-mail delivery |


---

## 3. Content you should review before launch

Everything marked as a **placeholder** is clearly flagged on the website
and must be replaced with real data:

* **Statistics** — `COMPANY_STATS` in `config/config.php`. The site shows
  a visible note while `SHOW_PLACEHOLDER_NOTE_STATS` is `true`; set it to
  `false` once the numbers are real.
* **Testimonials** — `data/testimonials.php`. Sample entries carry a
  "Sample" badge until `SHOW_PLACEHOLDER_NOTE_TESTIMONIALS` is `false`.
* **Images** — `assets/images/…` are original generated placeholder
  graphics. Replace them with real photos of your own work (WebP
  recommended), keeping the same file names.
* **Legal texts** — `data/legal.php` (privacy policy + terms). Have them
  reviewed by a qualified professional before publishing.
* **Services and areas** — `data/services.php`, `data/services/*.php`,
  `data/areas.php`.

---

## 4. Editing services, areas and copy

* **Service list / names / short descriptions** — `data/services.php`.
* **Full service page content** (problems, solution, what is included,
  process, FAQ, gallery, before/after) — one file per service in
  `data/services/<slug>.php`. The page under `/services/<slug>.php` only
  sets `$serviceSlug` and renders the shared template.
* **Service areas** — `data/areas.php` (name, governorate, intro,
  popular services, FAQ). Area pages in `/areas/` work the same way.
* **FAQs, testimonials, gallery, before/after** — `data/faqs.php`,
  `data/testimonials.php`, `data/gallery.php`, `data/before-after.php`.
* **English UI copy** — `lang/en.php`. **Arabic UI copy** — `lang/ar.php`.
* **Arabic SEO titles/descriptions** — `data/seo-ar.php`
  (see section 5).

After editing a service, regenerate the page stub if the slug is new:
`php tools/generate-pages.php` (or copy an existing
`services/<slug>.php` file and change the slug).

---

## 5. Languages (English + Arabic/RTL)

* URLs: `/en/…` and `/ar/…` (the home page is `/en/` and `/ar/`).
* The active language is detected from the URL, then the `?lang=` query,
  then a cookie. A language switcher is present in the top bar, the
  header and the mobile drawer.
* Arabic pages are fully RTL: `<html lang="ar" dir="rtl">`,
  `assets/css/rtl.css`, mirrored layout and Arabic typography.
* Arabic `<title>` and meta description come from `data/seo-ar.php`;
  without an entry the English copy is used, so you can translate
  page by page.
---

## 6. SEO features included

* Unique `<title>`, meta description, canonical URL, Open Graph and
  Twitter card tags on every page (Arabic variants included).
* JSON-LD: `LocalBusiness`/`CleaningService`, `WebSite`, `Service`,
  `BreadcrumbList`, `FAQPage` (only where the Q&A is really on the page).
* `sitemap.xml` (generated by `sitemap.php`, includes hreflang pairs)
  and `robots.txt` (generated by `robots.php`).
* Clean URLs with and without the `.php` extension, breadcrumbs on all
  internal pages, semantic headings, alt text on images, lazy loading.

---

## 7. Contact form (no database)

`includes/quote-form.php` posts to `actions/contact.php`, which:

1. verifies the CSRF token,
2. checks a honeypot field, a timing trap and a session rate limit,
3. sanitizes every field (header injection impossible),
4. validates name, Kuwait phone, optional e-mail, service, area, message,
5. sends the inquiry by `mail()` or SMTP (configured in `config.php`),
6. redirects back with `?status=sent` or `?status=error`.

Nothing is written to a database or a file. Old input and error
messages live in the PHP session for the single redirect only.

For **SMTP delivery** set `MAIL_METHOD = 'smtp'` and provide the
credentials through the environment variables listed in
`config/config.local.example.php`.

---

## 8. Deployment checklist

* [ ] `config/config.php` — replace every placeholder, set `SITE_URL`.
* [ ] Set `PRODUCTION = true` (enables minified assets + long cache).
* [ ] Copy `config/config.local.example.php` → `config/config.local.php`
      if you need SMTP or local overrides.
* [ ] Replace placeholder images in `assets/images/`.
* [ ] Replace placeholder statistics and testimonials.
* [ ] Review legal texts in `data/legal.php` with a professional.
* [ ] Verify `/sitemap.xml` and `/robots.txt` respond on the live domain.
* [ ] Test WhatsApp buttons and the `tel:` links on a real phone.
* [ ] Send one test message through the contact form.
* [ ] Confirm there are no leftover development files: every page of the
      site is a normal `.php` file in the project root, `services/` or
      `areas/`; helper folders (`config/`, `includes/`, `data/`, `lang/`,
      `tools/`, `deploy/`) are blocked from direct web access by
      `.htaccess` (and by the Nginx rules in `deploy/nginx.conf.example`).

---

## 9. Project structure

```
├── index.php  about.php  services.php  residential-cleaning.php
│   commercial-cleaning.php  specialized-cleaning.php  why-choose-us.php
│   service-areas.php  gallery.php  faq.php  contact.php
│   privacy-policy.php  terms.php  404.php
├── services/          one stub per service page
├── areas/             one stub per Kuwait area page
├── en/  ar/           language entry points for /en/ and /ar/
├── actions/           contact.php (form handler, no database)
├── includes/          bootstrap, header, footer, templates, helpers
├── config/            config.php (+ optional config.local.php)
├── data/              services, areas, FAQs, testimonials, gallery, legal, seo-ar
├── lang/              en.php, ar.php
├── assets/            css / js / images (WebP)
├── tools/             generate-pages.php, generate-images.php, dev-router.php
├── deploy/            nginx.conf.example (Nginx + PHP-FPM setup)
├── sitemap.php        served as /sitemap.xml
├── robots.php         served as /robots.txt
└── .htaccess          clean URLs, language prefixes, caching, security
```

---

## 10. Rebuild the placeholder images (optional)

The generated WebP artwork can be recreated after a PHP/GD change:

```
php -d extension=gd tools/generate-images.php
```
