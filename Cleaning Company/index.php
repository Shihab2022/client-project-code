<?php
/**
 * =====================================================================
 *  HOME PAGE  —  conversion-focused landing page for a Kuwait audience
 * =====================================================================
 *  Sections: hero → stats → about preview → services grid (filterable) →
 *  process → why us → service areas → testimonials → gallery preview →
 *  FAQ preview → contact CTA.
 * =====================================================================
 */

require __DIR__ . '/includes/bootstrap.php';

$page = [
    'slug'        => 'home',
    'path'        => '/index.php',
    'title'       => 'Professional Cleaning Services in Kuwait | ' . COMPANY_NAME,
    'description' => 'Professional residential and commercial cleaning services in Kuwait. Villas, apartments, offices, sofas, carpets and deep cleaning. Contact ' . COMPANY_NAME . ' on WhatsApp or by phone.',
    'keywords'    => 'cleaning company in Kuwait, cleaning services Kuwait, house cleaning Kuwait, villa cleaning Kuwait, apartment cleaning Kuwait, office cleaning Kuwait',
    'image'       => '/assets/images/og-cover.webp',
    'image_alt'   => 'Professional cleaning team in Kuwait',
    'body_class'  => 'page-home',
    'scripts'     => ['/assets/js/services.js'],
];

require __DIR__ . '/includes/header.php';

$homeWaMessage = t('wa.quote_message');
?>
<!-- 1. HERO -->
<section class="hero" aria-labelledby="home-hero-title">
    <div class="container hero__inner">
        <div class="hero__content">
            <p class="eyebrow"><?= icon('sparkle', 'eyebrow__icon', 18) ?><?= e(t('home.hero_eyebrow')) ?></p>
            <h1 class="hero__title" id="home-hero-title"><?= e(t('home.hero_title')) ?></h1>
            <p class="hero__text"><?= e(t('home.hero_text')) ?></p>

            <ul class="hero__points">
                <li><?= icon('check', 'hero__check', 16) ?><span><?= e(t('home.hero_point_1')) ?></span></li>
                <li><?= icon('check', 'hero__check', 16) ?><span><?= e(t('home.hero_point_2')) ?></span></li>
                <li><?= icon('check', 'hero__check', 16) ?><span><?= e(t('home.hero_point_3')) ?></span></li>
            </ul>

            <div class="hero__actions">
                <?= wa_button($homeWaMessage, t('cta.whatsapp_us'), 'whatsapp', ['class' => 'btn--lg']) ?>
                <?= call_button(t('cta.call_now'), 'accent', ['class' => 'btn--lg']) ?>
                <?= btn(['label' => t('cta.explore_services'), 'href' => url('/services.php'), 'variant' => 'ghost', 'icon' => 'arrow-right', 'icon_pos' => 'right', 'class' => 'btn--lg']) ?>
            </div>
        </div>

        <div class="hero__aside">
            <div class="hero__media reveal">
                <?= img_tag([
                    'src'        => '/assets/images/hero-cleaning.webp',
                    'alt'        => 'Professional cleaning team working in a villa in Kuwait',
                    'responsive' => true,
                    'eager'      => true,
                    'sizes'      => '(max-width: 899px) 92vw, 520px',
                ]) ?>
            </div>
            <div class="hero__card reveal">
                <h2 class="hero__card-title"><?= icon('whatsapp', 'icon', 20) ?><?= e(t('home.hero_card_title')) ?></h2>
                <p class="hero__card-text"><?= e(t('home.hero_card_text')) ?></p>
                <div class="hero__card-actions">
                    <?= wa_button($homeWaMessage, t('cta.whatsapp_us'), 'whatsapp', ['class' => 'btn--sm']) ?>
                    <?= call_button(t('cta.call_now'), 'outline', ['class' => 'btn--sm']) ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php /* 2. TRUST / STATS */ ?>
<section class="section section--tight section--dark" aria-labelledby="home-stats-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('home.stats_eyebrow'),
            'title'   => t('home.stats_title'),
            'lead'    => t('home.stats_lead'),
            'level'   => 2,
            'align'   => 'center',
        ]) ?>
        <?php echo stats_block('dark'); ?>
    </div>
</section>

<?php /* 3. ABOUT PREVIEW */ ?>
<section class="section" aria-labelledby="home-about-title">
    <div class="container">
        <div class="split">
            <div class="split__body">
                <?= section_head([
                    'eyebrow' => t('home.about_eyebrow'),
                    'title'   => t('home.about_title'),
                    'lead'    => t('home.about_text'),
                    'level'   => 2,
                ]) ?>
                <div class="media-duo reveal">
                    <div class="media-card">
                        <?= img_tag([
                            'src'        => '/assets/images/about-team.webp',
                            'alt'        => 'Cleaning team with professional equipment in Kuwait',
                            'responsive' => true,
                            'sizes'      => '(max-width: 899px) 92vw, 640px',
                        ]) ?>
                    </div>
                </div>
                <?= check_list([
                    'Experienced and trained cleaning staff',
                    'Quality checked at the end of every visit',
                    'Cleaning products suitable for each surface',
                    'Direct communication in English and Arabic',
                ]) ?>
                <p class="section-cta">
                    <?= btn(['label' => t('cta.learn_more_about'), 'href' => url('/about.php'), 'variant' => 'primary', 'icon' => 'arrow-right', 'icon_pos' => 'right', 'class' => 'btn--lg']) ?>
                </p>
            </div>
            <aside class="split__aside">
                <?= feature_cards(array_slice(trust_points(), 0, 3), 'grid-1-stack') ?>
            </aside>
        </div>
    </div>
</section>

<?php /* 4. SERVICES GRID (filterable) */ ?>
<section class="section section--muted" id="services" data-services-grid aria-labelledby="home-services-title">
    <div class="container">
        <div class="service-section-head">
            <?= section_head([
                'eyebrow' => t('home.services_eyebrow'),
                'title'   => t('home.services_title'),
                'lead'    => t('home.services_lead'),
                'level'   => 2,
            ]) ?>
            <div class="filter-tabs" role="tablist" aria-label="<?= e(t('home.services_eyebrow')) ?>">
                <button type="button" class="filter-tabs__btn is-active" data-filter="all" aria-selected="true"><?= e(t('home.filter_all')) ?></button>
                <button type="button" class="filter-tabs__btn" data-filter="residential" aria-selected="false"><?= e(t('category.residential')) ?></button>
                <button type="button" class="filter-tabs__btn" data-filter="commercial" aria-selected="false"><?= e(t('category.commercial')) ?></button>
                <button type="button" class="filter-tabs__btn" data-filter="specialised" aria-selected="false"><?= e(t('category.specialised')) ?></button>
            </div>
        </div>

        <div class="card-grid grid-3" data-filter-target="[data-services-grid]">
            <?php foreach (services() as $serviceSlug => $serviceRow) : ?>
                <?php echo service_card($serviceSlug); ?>
            <?php endforeach; ?>
        </div>

        <p class="section-cta">
            <?= btn(['label' => t('cta.view_all_services'), 'href' => url('/services.php'), 'variant' => 'primary', 'icon' => 'arrow-right', 'icon_pos' => 'right', 'class' => 'btn--lg']) ?>
        </p>
    </div>
</section>

<?php /* 5. PROCESS */ ?>
<section class="section" aria-labelledby="home-process-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('home.process_eyebrow'),
            'title'   => t('home.process_title'),
            'lead'    => t('cta.band_text'),
            'level'   => 2,
            'align'   => 'center',
        ]) ?>
        <?= numbered_steps((array) (data('services')['default_process'] ?? [])) ?>
    </div>
</section>

<?php /* 6. WHY CHOOSE US */ ?>
<section class="section section--muted" aria-labelledby="home-why-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('home.why_eyebrow'),
            'title'   => t('home.why_title'),
            'level'   => 2,
            'align'   => 'center',
        ]) ?>
        <?= feature_cards(array_slice(trust_points(), 0, 6)) ?>
        <p class="section-cta">
            <?= btn(['label' => t('cta.learn_more'), 'href' => url('/why-choose-us.php'), 'variant' => 'ghost', 'icon' => 'arrow-right', 'icon_pos' => 'right']) ?>
        </p>
    </div>
</section>

<?php /* 7. SERVICE AREAS */ ?>
<section class="section" aria-labelledby="home-areas-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('home.areas_eyebrow'),
            'title'   => t('home.areas_title'),
            'lead'    => t('home.areas_lead'),
            'level'   => 2,
        ]) ?>
        <div class="area-grid">
            <?php foreach (array_keys(areas()) as $areaSlug) : ?>
                <?php echo area_card($areaSlug); ?>
            <?php endforeach; ?>
        </div>
        <p class="section-cta">
            <?= btn(['label' => t('cta.view_all_areas'), 'href' => url('/service-areas.php'), 'variant' => 'primary', 'icon' => 'arrow-right', 'icon_pos' => 'right']) ?>
        </p>
    </div>
</section>

<?php /* 8. TESTIMONIALS (clearly marked placeholders until real reviews exist) */
$homeTestimonials = array_slice(testimonials(), 0, 4);
if ($homeTestimonials) :
?>
<section class="section section--muted" id="testimonials" aria-labelledby="home-testimonials-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('home.testimonials_eyebrow'),
            'title'   => t('home.testimonials_title'),
            'level'   => 2,
            'align'   => 'center',
        ]) ?>
        <div class="testimonial-row">
            <?php foreach ($homeTestimonials as $testimonial) : ?>
                <?php echo testimonial_card($testimonial); ?>
            <?php endforeach; ?>
        </div>
        <?php if (SHOW_PLACEHOLDER_NOTE_TESTIMONIALS) : ?>
            <p class="placeholder-note"><?= icon('info', 'placeholder-note__icon', 16) ?><span><?= e(t('note.testimonials_placeholder')) ?></span></p>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<?php /* 9. GALLERY PREVIEW */ ?>
<section class="section" aria-labelledby="home-gallery-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('home.gallery_eyebrow'),
            'title'   => t('home.gallery_title'),
            'lead'    => t('gallery.hero_text'),
            'level'   => 2,
        ]) ?>
        <div class="gallery-grid">
            <?php foreach (array_slice(gallery_items(), 0, 6) as $galleryItem) : ?>
                <figure class="gallery-item" data-category="<?= e($galleryItem['category']) ?>">
                    <?= img_tag([
                        'src'        => $galleryItem['image'],
                        'alt'        => $galleryItem['alt'],
                        'responsive' => true,
                        'sizes'      => '(max-width: 599px) 46vw, (max-width: 1199px) 31vw, 300px',
                    ]) ?>
                    <figcaption class="gallery-item__caption"><?= e($galleryItem['caption']) ?></figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
        <p class="section-cta">
            <?= btn(['label' => t('cta.view_gallery'), 'href' => url('/gallery.php'), 'variant' => 'primary', 'icon' => 'arrow-right', 'icon_pos' => 'right']) ?>
        </p>
    </div>
</section>

<?php /* 10. FAQ PREVIEW */
$homeFaq = array_slice((array) (faq_groups()['general']['items'] ?? []), 0, 4);
if ($homeFaq) :
?>
<section class="section section--muted" aria-labelledby="home-faq-title">
    <div class="container container--narrow">
        <?= section_head([
            'eyebrow' => t('home.faq_eyebrow'),
            'title'   => t('home.faq_title'),
            'level'   => 2,
            'align'   => 'center',
        ]) ?>
        <?= accordion($homeFaq, 'home-faq') ?>
        <p class="section-cta">
            <?= btn(['label' => t('cta.read_faqs'), 'href' => url('/faq.php'), 'variant' => 'ghost', 'icon' => 'arrow-right', 'icon_pos' => 'right']) ?>
        </p>
    </div>
</section>
<?php endif; ?>

<?php
/* 11. CONTACT CTA + inquiry form (no database) */
$formOptions = ['source' => '/index.php'];
require __DIR__ . '/includes/quote-form.php';

echo cta_band();

require __DIR__ . '/includes/footer.php';