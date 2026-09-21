<?php
/**
 * =====================================================================
 *  HOME PAGE  —  conversion-focused landing page for a Kuwait audience
 * =====================================================================
 *  Sections: hero → stats → about preview → services grid (filterable) →
 *  process → why us → interactive service-area map → testimonials →
 *  FAQ → contact CTA + inquiry form.
 * =====================================================================
 */

require __DIR__ . '/includes/bootstrap.php';

$homeFaqGroup = (array) (faq_groups()['general'] ?? []);
$homeFaq      = array_slice(lxa($homeFaqGroup, 'items'), 0, 8);

/* The same Q&A is visible on this page, so it is eligible for FAQPage
   structured data (only Q&A pairs that are actually shown are sent). */
$faqSchema = [];
foreach ($homeFaq as $faqItem) {
    if (!empty($faqItem['q']) && !empty($faqItem['a'])) {
        $faqSchema[] = ['q' => (string) $faqItem['q'], 'a' => (string) $faqItem['a']];
    }
}

$page = [
    'slug'        => 'home',
    'path'        => '/index.php',
    'title'       => 'Professional Cleaning Services in Kuwait | ' . COMPANY_NAME,
    'description' => 'Professional residential and commercial cleaning services in Kuwait. Villas, apartments, offices, sofas, carpets and deep cleaning. Contact ' . COMPANY_NAME . ' on WhatsApp or by phone.',
    'keywords'    => 'cleaning company in Kuwait, cleaning services Kuwait, house cleaning Kuwait, villa cleaning Kuwait, apartment cleaning Kuwait, office cleaning Kuwait',
    'image'       => '/assets/images/og-cover.webp',
    'image_alt'   => alt_text('Professional cleaning team in Kuwait', 'فريق تنظيف محترف في الكويت'),
    'body_class'  => 'page-home',
    'faq'         => $faqSchema,
];

require __DIR__ . '/includes/header.php';

$homeWaMessage = t('wa.quote_message');
?>
<!-- 1. HERO (EverClean SA inspired) -->
<section class="hero" aria-labelledby="home-hero-title">
    <div class="container hero__inner">
        <div class="hero__content">
            <a href="#testimonials" class="hero__satisfaction-pill">
                <span class="hero__pulse-dot" aria-hidden="true"></span>
                <span><?= e(t('home.hero_satisfaction')) ?></span>
                <span class="hero__satisfaction-arrow" aria-hidden="true"><?= is_rtl() ? '←' : '→' ?></span>
            </a>

            <h1 class="hero__title" id="home-hero-title">
                <span class="hero__title-main"><?= e(t('home.hero_title')) ?></span>
                <span class="hero__title-sub"><?= e(t('home.hero_title_highlight')) ?></span>
            </h1>

            <p class="hero__text"><?= e(t('home.hero_text')) ?></p>

            <ul class="hero__points">
                <li><?= icon('check', 'hero__check', 16) ?><span><?= e(t('home.hero_point_1')) ?></span></li>
                <li><?= icon('check', 'hero__check', 16) ?><span><?= e(t('home.hero_point_2')) ?></span></li>
                <li><?= icon('check', 'hero__check', 16) ?><span><?= e(t('home.hero_point_3')) ?></span></li>
            </ul>

            <div class="hero__actions">
                <?= wa_button($homeWaMessage, t('cta.free_inspection'), 'whatsapp', ['class' => 'btn--lg hero__btn-wa']) ?>
                <a class="btn btn--outline btn--lg hero__btn-call" href="<?= e_url(tel_url()) ?>">
                    <?= icon('phone', 'btn__icon', 18) ?><span class="btn__label"><?= e(t('cta.call_us')) ?>: <span dir="ltr"><?= e(COMPANY_PHONE) ?></span></span>
                </a>
                <?= btn(['label' => t('cta.explore_services'), 'href' => '#services', 'variant' => 'ghost', 'icon' => 'arrow-right', 'icon_pos' => 'right', 'class' => 'btn--lg hero__btn-services']) ?>
            </div>
        </div>

        <div class="hero__aside">
            <div class="hero__media-wrapper reveal">
                <div class="hero__media">
                    <video class="hero__video" autoplay muted loop playsinline preload="auto"
                           poster="<?= e_url(media('/assets/images/hero-cleaning.webp')) ?>"
                           aria-hidden="true" tabindex="-1">
                        <source src="<?= e_url(media('/assets/images/project-image/banner-video.mp4')) ?>" type="video/mp4">
                    </video>
                </div>

                <!-- Floating EverClean style trust badges -->
                <div class="hero__float-badge hero__float-badge--top">
                    <span class="hero__float-badge-icon">⭐</span>
                    <span class="hero__float-badge-text"><?= e(t('home.hero_badge_rating')) ?></span>
                </div>
                <div class="hero__float-badge hero__float-badge--bottom">
                    <span class="hero__float-badge-icon">🛡️</span>
                    <span class="hero__float-badge-text"><?= e(t('home.hero_badge_guarantee')) ?></span>
                </div>
            </div>

            <div class="hero__card reveal">
                <h2 class="hero__card-title"><?= icon('whatsapp', 'icon', 20) ?><?= e(t('home.hero_card_title')) ?></h2>
                <p class="hero__card-text"><?= e(t('home.hero_card_text')) ?></p>
                <div class="hero__card-actions">
                    <?= wa_button($homeWaMessage, t('cta.whatsapp_us'), 'whatsapp', ['class' => 'btn--sm']) ?>
                    <a class="btn btn--outline btn--sm" href="<?= e_url(tel_url()) ?>">
                        <?= icon('phone', 'btn__icon', 16) ?><span class="btn__label"><?= e(t('cta.call_now')) ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php /* 2. TRUST / STATS */ ?>
<section class="section section--tight section--stats" aria-labelledby="home-stats-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('home.stats_eyebrow'),
            'title'   => t('home.stats_title'),
            'lead'    => t('home.stats_lead'),
            'level'   => 2,
            'align'   => 'center',
        ]) ?>
        <?php echo stats_block('light'); ?>
    </div>
</section>

<?php /* 3. ABOUT SHOWCASE (EverClean SA Dark Luxury Section) */ ?>
<section class="section section--dark about-showcase" aria-labelledby="home-about-title">
    <div class="about-showcase__gold-bar" aria-hidden="true"></div>
    <div class="container">
        <div class="about-showcase__grid">
            <div class="about-showcase__content reveal">
                <span class="about-showcase__pill"><?= e(t('home.about_eyebrow')) ?></span>
                <h2 class="about-showcase__title" id="home-about-title"><?= e(t('home.about_title')) ?></h2>
                <div class="about-showcase__accent-line" aria-hidden="true"></div>
                <p class="about-showcase__lead"><?= e(t('home.about_lead')) ?></p>
                <p class="about-showcase__text"><?= e(t('home.about_text')) ?></p>

                <ul class="about-showcase__list">
                    <li><?= icon('check', 'about-showcase__check', 18) ?><span><?= e(t('home.about_point_1')) ?></span></li>
                    <li><?= icon('check', 'about-showcase__check', 18) ?><span><?= e(t('home.about_point_2')) ?></span></li>
                    <li><?= icon('check', 'about-showcase__check', 18) ?><span><?= e(t('home.about_point_3')) ?></span></li>
                    <li><?= icon('check', 'about-showcase__check', 18) ?><span><?= e(t('home.about_point_4')) ?></span></li>
                </ul>

                <div class="about-showcase__cta">
                    <a class="btn btn--gold-outline btn--lg" href="<?= e_url(url('/about.php')) ?>">
                        <span class="btn__label"><?= e(t('cta.learn_more_about')) ?></span>
                        <?= icon('arrow-right', 'btn__icon', 18) ?>
                    </a>
                </div>
            </div>

            <div class="about-showcase__gallery reveal">
                <div class="about-gallery-grid">
                    <div class="about-gallery-item about-gallery-item--1">
                        <?= img_tag([
                            'src'        => '/assets/images/project-image/deep-cleaning.jpg',
                            'alt'        => alt_text('Deep cleaning service in Kuwait — trained cleaning team at work', 'خدمة التنظيف العميق في الكويت — فريق تنظيف مدرب أثناء العمل'),
                            'sizes'      => '(max-width: 899px) 46vw, 320px',
                        ]) ?>
                    </div>
                    <div class="about-gallery-item about-gallery-item--2">
                        <?= img_tag([
                            'src'        => '/assets/images/project-image/villa-cleaning.avif',
                            'alt'        => alt_text('Villa cleaning service in Kuwait', 'خدمة تنظيف الفلل في الكويت'),
                            'responsive' => true,
                            'sizes'      => '(max-width: 899px) 46vw, 320px',
                        ]) ?>
                    </div>
                    <div class="about-gallery-item about-gallery-item--3">
                        <?= img_tag([
                            'src'        => '/assets/images/project-image/sofa-cleaning.avif',
                            'alt'        => alt_text('Steam sofa cleaning in Kuwait', 'تنظيف الكنب بالبخار في الكويت'),
                            'responsive' => true,
                            'sizes'      => '(max-width: 899px) 46vw, 320px',
                        ]) ?>
                    </div>
                    <div class="about-gallery-item about-gallery-item--4">
                        <?= img_tag([
                            'src'        => '/assets/images/project-image/kitchen-cleaning.avif',
                            'alt'        => alt_text('Kitchen deep cleaning and degreasing in Kuwait', 'تنظيف مطبخ عميق وإزالة دهون في الكويت'),
                            'responsive' => true,
                            'sizes'      => '(max-width: 899px) 46vw, 320px',
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php /* 4. SERVICES (one section, no category tabs — categories live in the nav) */
$featuredSlugs = [
    'villa-cleaning', 'apartment-cleaning', 'deep-cleaning',
    'sofa-cleaning', 'kitchen-cleaning', 'move-out-cleaning',
    'office-cleaning', 'shop-cleaning', 'post-construction-cleaning',
];
?>
<section class="section section--muted" id="services" aria-labelledby="home-services-title">
    <div class="container">
        <div class="service-section-head">
            <?= section_head([
                'eyebrow' => t('home.services_eyebrow'),
                'title'   => t('home.services_title'),
                'lead'    => t('home.services_lead'),
                'level'   => 2,
            ]) ?>
            <?= btn(['label' => t('cta.view_all_services'), 'href' => url('/services.php'), 'variant' => 'primary', 'icon' => 'arrow-right', 'icon_pos' => 'right', 'class' => 'btn--sm']) ?>
        </div>

        <div class="card-grid grid-3">
            <?php foreach ($featuredSlugs as $featuredSlug) : ?>
                <?php echo service_card($featuredSlug); ?>
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

<?php /* 7. SERVICE AREAS — interactive map with one pin + link per district */ ?>
<section class="section" aria-labelledby="home-areas-title">
    <div class="container">
        <?= section_head([
            'eyebrow' => t('home.areas_eyebrow'),
            'title'   => t('home.areas_title'),
            'lead'    => t('home.areas_lead'),
            'level'   => 2,
        ]) ?>
        <?= area_map(['title' => t('areas.map_title')]) ?>
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

<?php /* Gallery section removed on request. */ ?>

<?php /* 9. FAQ (id="faqs" is the anchor used by the footer quick links) */
if ($homeFaq) :
?>
<section class="section section--muted" id="faqs" aria-labelledby="home-faq-title">
    <div class="container container--narrow">
        <?= section_head([
            'eyebrow' => t('home.faq_eyebrow'),
            'title'   => t('home.faq_title'),
            'level'   => 2,
            'align'   => 'center',
        ]) ?>
        <?= accordion($homeFaq, 'home-faq') ?>
        <p class="section-cta">
            <?= wa_button(whatsapp_quote_message(), t('cta.whatsapp_us'), 'whatsapp', ['class' => 'btn--lg']) ?>
        </p>
    </div>
</section>
<?php endif; ?>

<?php
/* 10. CONTACT CTA + inquiry form (no database) */
$formOptions = [
    'title'  => t('cta.get_quote'),
    'source' => '/index.php',
];
require __DIR__ . '/includes/quote-form.php';

echo cta_band();

require __DIR__ . '/includes/footer.php';