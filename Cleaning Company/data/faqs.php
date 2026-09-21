<?php
/**
 * =====================================================================
 *  FAQ CONTENT  —  grouped questions (no database)
 * =====================================================================
 *  Answers describe how the company works. They deliberately avoid
 *  unsupported promises (no guaranteed same-day service, no medical or
 *  "100% germ free" claims, no fixed prices without a site assessment).
 * =====================================================================
 */

return [
    'groups' => [

        'general' => [
            'title'    => 'General',
            'title_ar' => 'أسئلة عامة',
            'items'    => [
                [
                    'q' => 'Do you provide cleaning services in Kuwait?',
                    'a' => 'Yes. We provide residential, commercial and specialised cleaning services in Kuwait. Our service areas page lists the districts we cover, and you can confirm availability for your building or street by messaging us on WhatsApp.',
                ],
                [
                    'q' => 'How can I contact you?',
                    'a' => 'The fastest way is WhatsApp or a phone call using the number shown at the top and bottom of every page. You can also use the quick quote form on our home page and your inquiry will be delivered to our e-mail inbox.',
                ],
                [
                    'q' => 'Do I need to create an account or book online?',
                    'a' => 'No. There is no registration, no customer account and no online booking on this website. You speak directly to our team on WhatsApp or by phone and we agree the details together.',
                ],
                [
                    'q' => 'Which cleaning services do you offer?',
                    'a' => 'Residential cleaning (villas, apartments, deep cleaning, sofas, carpets, mattresses, kitchens, bathrooms, windows, move-in, move-out and chalets), commercial cleaning (offices, shops, restaurants, cafes, schools, clinics, hotels, warehouses, showrooms and commercial buildings) and specialised services such as steam cleaning, facade washing, glass cleaning, floor polishing and post-construction cleaning.',
                ],
                [
                    'q' => 'Do you work with homes and businesses?',
                    'a' => 'Yes. We clean private homes as well as offices, shops, restaurants and other business premises. For businesses we can agree a one-time visit or a recurring schedule that fits your opening hours.',
                ],
                [
                    'q' => 'How much does a cleaning service cost?',
                    'a' => 'The price depends on the size of the space, its condition and the type of service. Send us the details on WhatsApp (or use the quick quote form on our home page) and we will give you a clear estimate. The final price is always agreed with you before the team starts.',
                ],
                [
                    'q' => 'Do you bring your own cleaning equipment and products?',
                    'a' => 'Yes. The team arrives with professional equipment and cleaning products matched to the surfaces being cleaned. You only need to provide water and electricity on site.',
                ],
                [
                    'q' => 'Which areas of Kuwait do you cover?',
                    'a' => 'We serve the districts listed on our service areas page, including Kuwait City, Salmiya, Hawally, Farwaniya, Ahmadi and Jahra. The interactive map on that page shows each area, and you can confirm availability for your address on WhatsApp.',
                ],
                [
                    'q' => 'Do I need to be at home during the cleaning?',
                    'a' => 'Not necessarily. Many customers are present for the first visit and then arrange access with a family member, building security or a key handover. You decide the access arrangement with us when booking.',
                ],
                [
                    'q' => 'Can I book a regular weekly or monthly cleaning?',
                    'a' => 'Yes. Recurring visits (weekly, every two weeks or monthly) can be agreed on WhatsApp, and we do our best to send the same team each time so the routine stays familiar.',
                ],
            ],
        ],

        'residential' => [
            'title'    => 'Residential Cleaning',
            'title_ar' => 'تنظيف المنازل',
            'items'    => [
                [
                    'q' => 'Do you clean villas and apartments?',
                    'a' => 'Yes. Villa and apartment cleaning are two of our most requested services. The team, the equipment and the time needed are planned according to the size of the property and the number of rooms and bathrooms.',
                ],
                [
                    'q' => 'Can you clean sofas, carpets and mattresses at home?',
                    'a' => 'Yes. Upholstery, carpet and mattress cleaning are done on site using extraction and steam equipment. We check the fabric type first, because some materials need a gentler method or a lower moisture level.',
                ],
                [
                    'q' => 'Do you clean kitchens and bathrooms separately?',
                    'a' => 'Yes. Kitchen cleaning, bathroom cleaning and kitchen degreasing can be requested on their own, for example before guests arrive or after long use. They are also included in our deep cleaning service.',
                ],
                [
                    'q' => 'Do you offer move-in and move-out cleaning?',
                    'a' => 'Yes. Move-in and move-out cleaning covers an empty property: cupboards inside and out, kitchens, bathrooms, floors, glass and the areas that are normally hidden by furniture. It is often requested before handover to a landlord or a new tenant.',
                ],
                [
                    'q' => 'Do you clean chalets in Kuwait?',
                    'a' => 'Yes, chalet cleaning is available. Because chalets are usually larger and used seasonally, tell us the number of rooms, whether there is a pool area, and if the water and electricity are connected when you message us.',
                ],
            ],
        ],

        'commercial' => [
            'title'    => 'Commercial Cleaning',
            'title_ar' => 'تنظيف الشركات',
            'items'    => [
                [
                    'q' => 'Do you provide commercial cleaning for businesses in Kuwait?',
                    'a' => 'Yes. We clean offices, shops, restaurants, cafes, clinics, schools, hotels, warehouses, showrooms and commercial buildings. We can work before opening, after closing or during quiet hours so your operations are not interrupted.',
                ],
                [
                    'q' => 'Can you clean after business hours?',
                    'a' => 'Yes, after-hours cleaning is one of our standard options for commercial clients. The exact window depends on your opening hours and on team availability for that day.',
                ],
                [
                    'q' => 'Do you offer recurring cleaning contracts?',
                    'a' => 'Yes. We can agree daily, several-times-per-week, weekly or monthly schedules. For recurring work we prepare a written task list so the standard stays the same on every visit.',
                ],
                [
                    'q' => 'Do you clean restaurants and commercial kitchens?',
                    'a' => 'Yes. Restaurant cleaning includes the dining area, front of house and the kitchen surfaces we can safely reach, plus degreasing of extractor-adjacent surfaces such as hood exteriors and filters when the client requests it. We follow your food-safety rules while working.',
                ],
                [
                    'q' => 'Do you provide disinfection for clinics and offices?',
                    'a' => 'Yes, disinfection and sanitization is available for commercial spaces. We agree the products, the contact time and the areas to be treated in advance, and we follow the manufacturer instructions for each product.',
                ],
            ],
        ],

        'pricing' => [
            'title'    => 'Pricing',
            'title_ar' => 'الأسعار',
            'items'    => [
                [
                    'q' => 'How much does cleaning cost in Kuwait?',
                    'a' => 'The price depends on the service, the size of the space, the condition it is in, the number of cleaners needed and the equipment required. Send us the details on WhatsApp or by phone and we will give you a clear price for your specific job.',
                ],
                [
                    'q' => 'Is the quotation free?',
                    'a' => 'Yes, the quotation itself is free. For larger or more technical jobs we may need a few questions answered, or a short visit, before we can confirm an accurate price.',
                ],
                [
                    'q' => 'What affects the final price?',
                    'a' => 'Property size, number of rooms and bathrooms, level of soiling, the materials to be treated, access and parking, whether furniture must be moved, and the time window you need. Extra services such as mattress, sofa or carpet cleaning are quoted separately.',
                ],
                [
                    'q' => 'Do you require a deposit?',
                    'a' => 'For standard residential visits there is no deposit. If a specific arrangement is needed for a large or recurring commercial job, it will be explained and agreed in writing before any work starts.',
                ],
            ],
        ],

        'areas' => [
            'title'    => 'Service Areas',
            'title_ar' => 'مناطق الخدمة',
            'items'    => [
                [
                    'q' => 'Which areas of Kuwait do you serve?',
                    'a' => 'We serve Kuwait City, Hawally, Salmiya, Farwaniya, Mubarak Al-Kabeer, Ahmadi, Jahra, Sabah Al Salem, Fintas, Mahboula, Mangaf, Abu Al Hasaniya, Mishref, Bayan, Jabriya, Shuwaikh and surrounding districts. Availability for a specific building is confirmed when you contact us.',
                ],
                [
                    'q' => 'Is there an extra charge for travelling to my area?',
                    'a' => 'For the areas listed on our service areas page there is normally no separate travel charge. If your location is far from our usual routes, any additional cost is stated in the quotation before you confirm.',
                ],
                [
                    'q' => 'Do you clean outside Kuwait?',
                    'a' => 'No. Our services are provided inside Kuwait only.',
                ],
            ],
        ],

        'contact' => [
            'title'    => 'WhatsApp & Contact',
            'title_ar' => 'واتساب والتواصل',
            'items'    => [
                [
                    'q' => 'Can I contact you through WhatsApp?',
                    'a' => 'Yes, WhatsApp is the fastest way to reach us. Every service page has a WhatsApp button with a message already prepared for that service, so you only need to press send.',
                ],
                [
                    'q' => 'What should I include in my first message?',
                    'a' => 'The service you need, your area in Kuwait, the type of property (villa, apartment, office, shop), the approximate size or number of rooms, your preferred day and time, and any specific problem you want solved.',
                ],
                [
                    'q' => 'Can I send photos of the space?',
                    'a' => 'Photos help a lot, especially for sofa, carpet, mattress and post-construction work. Send them on WhatsApp and we can give more accurate information without a visit.',
                ],
                [
                    'q' => 'Is the website contact form stored anywhere?',
                    'a' => 'No. The form does not use a database: your message is validated, sanitized and sent to our e-mail inbox, then the page confirms that it was sent. See our privacy policy for details.',
                ],
            ],
        ],

        'scheduling' => [
            'title'    => 'Scheduling',
            'title_ar' => 'المواعيد',
            'items'    => [
                [
                    'q' => 'Do you provide same-day cleaning?',
                    'a' => 'Sometimes a slot is available on the same day, but we do not guarantee it. Message us with your area and the service you need and we will tell you honestly what the earliest available time is.',
                ],
                [
                    'q' => 'How far in advance should I book?',
                    'a' => 'For regular villa and apartment cleaning, one or two days is usually enough. For deep cleaning, post-construction or large commercial jobs, more notice helps us plan the team and equipment.',
                ],
                [
                    'q' => 'How long does a cleaning visit take?',
                    'a' => 'It depends on the service and the size of the space. A small apartment clean can take two to three hours, while a full villa deep clean or a large commercial site may take most of a day or require several cleaners. We give an estimate before the visit.',
                ],
                [
                    'q' => 'Can I reschedule or cancel an appointment?',
                    'a' => 'Yes, please tell us as early as possible on WhatsApp or by phone so the slot can be given to another customer and your team can be re-planned.',
                ],
            ],
        ],

        'products' => [
            'title'    => 'Cleaning Products & Safety',
            'title_ar' => 'مواد التنظيف والسلامة',
            'items'    => [
                [
                    'q' => 'Which cleaning products do you use?',
                    'a' => 'We use professional cleaning products selected for the surface being cleaned, and we follow the dilution, contact time and ventilation instructions provided by the manufacturer. If you prefer specific products, tell us before the visit.',
                ],
                [
                    'q' => 'Are the products safe for children and pets?',
                    'a' => 'We use products at their recommended dilution and rinse surfaces that come into regular contact. Tell us in advance if there are children, pets, allergies or sensitivities in the property so we can adjust the products and the drying time.',
                ],
                [
                    'q' => 'Do you need water and electricity on site?',
                    'a' => 'Most cleaning equipment needs both. If the property is empty, under renovation or has the supply disconnected, tell us when booking so we can plan an alternative approach.',
                ],
                [
                    'q' => 'Do you move furniture?',
                    'a' => 'We move light items such as chairs, small tables and floor lamps to clean underneath them. Heavy furniture, fixed units and fragile items are cleaned around unless you specifically ask us to move them.',
                ],
            ],
        ],
    ],
];