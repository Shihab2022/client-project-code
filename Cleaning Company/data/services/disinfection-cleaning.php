<?php
/**
 * Service definition – see /data/services.php for the full documentation.
 */
return [
    'name'       => 'Disinfection & Sanitization',
    'name_ar'    => 'التعقيم والتطهير',
    'category'   => 'specialised',
    'icon'       => 'shield',
    'image'      => '/assets/images/services/disinfection-cleaning.webp',
    'image_alt'  => 'Disinfection and sanitization service in Kuwait',
    'short'      => 'Surface disinfection for homes and businesses using agreed products and contact times.',
    'meta_title' => 'Disinfection & Sanitization in Kuwait | Surface Disinfection Service',
    'meta_description' => 'Disinfection and sanitization in Kuwait for homes, offices, clinics and schools. Agreed products, contact times and coverage. Contact us on WhatsApp.',
    'keywords'   => 'disinfection service Kuwait, sanitization Kuwait, office disinfection Kuwait',
    'hero_intro' => 'Disinfection only works when the surface is clean first, the product is right for it, and the contact time is respected. Our disinfection and sanitization service in Kuwait is planned around those three points, with the products and coverage agreed in advance.',
    'duration'   => 'Around 1 to 4 hours depending on the area and the number of surfaces to be treated.',
    'problems'   => [
        'Spraying a product over a dirty surface does not disinfect it, because soil protects what is underneath.',
        'Different products need different contact times, and skipping that step means paying for no result.',
        'Some materials and electronic equipment are damaged by the wrong product or by over-wetting.',
    ],
    'solutions'  => [
        'Surfaces are cleaned first, then treated, so the product reaches the surface itself.',
        'The product, dilution and contact time are agreed with you and applied as the manufacturer instructs.',
        'Sensitive surfaces, electronics and fabrics are identified in advance and treated only with an appropriate method.',
    ],
    'includes'   => [
        'Assessment of the areas to be treated and the surfaces involved',
        'Pre-cleaning of surfaces before treatment',
        'Application of the agreed disinfectant to high-contact points: handles, switches, rails, counters',
        'Treatment of washrooms, kitchens and shared high-use areas',
        'Treatment of office equipment exteriors where permitted',
        'Respecting the required contact time before surfaces are wiped or used',
        'Ventilation and drying guidance',
        'Completion note confirming which areas and products were used, on request',
    ],
    'why'        => [
        'Clean first, treat second: the correct order for disinfection to mean anything.',
        'Products and contact times agreed in writing rather than assumed.',
        'Suitable for homes, offices, clinics, schools, gyms and hospitality premises.',
        'After-hours scheduling to avoid disruption to your staff or family.',
    ],
    'surfaces'   => [
        'Door handles, switches and handrails', 'Counters, desks and shared tables',
        'Washroom fixtures and taps', 'Kitchen surfaces and shared equipment exteriors',
        'Lift buttons and reception surfaces',
    ],
    'prepare'    => [
        'Tell us which areas and surfaces you want treated and whether they will be empty at the time.',
        'Confirm any products you require or must avoid, for example for allergy or equipment reasons.',
        'Allow ventilation time afterwards, as instructed by the product data sheet.',
    ],
    'faq'        => [
        ['q' => 'What is the difference between cleaning and disinfection?', 'a' => 'Cleaning removes soil and residues from a surface. Disinfection is a separate step that is applied to a cleaned surface for a specified contact time, in order to reduce micro-organisms.'],
        ['q' => 'Do you disinfect homes as well as offices?', 'a' => 'Yes. We treat homes, offices, clinics, schools, gyms and hospitality premises. The areas and products are agreed before the visit.'],
        ['q' => 'How long must I stay out of a treated room?', 'a' => 'It depends on the product used and on ventilation. We tell you the required time at the end of the visit, based on the product data sheet.'],
        ['q' => 'Do you claim that all germs are removed?', 'a' => 'No. Disinfection reduces contamination on treated surfaces when applied correctly. No service can claim to eliminate every micro-organism everywhere, and surfaces become recontaminated with use.'],
        ['q' => 'Can you treat a clinic or school outside working hours?', 'a' => 'Yes. Disinfection for clinics, schools and offices is normally scheduled after hours or at the weekend so the space is not in use during treatment and contact time.'],
    ],
    'related'    => ['clinic-cleaning', 'school-cleaning', 'deep-cleaning', 'kitchen-degreasing'],
];