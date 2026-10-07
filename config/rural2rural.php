<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Organisation
    |--------------------------------------------------------------------------
    |
    | Core facts about the initiative. These feed both the marketing page and
    | the knowledge r2rBot is allowed to answer from.
    |
    */

    'about' => 'Rural2Rural (R2R) Skills, Jobs, Careers and Entrepreneurship Initiative is a programme that travels across rural South Africa aimed at educating, training, exposing and advising small businesses, youth, women and people living with disabilities in rural areas to engage in further education and career opportunities, skills development, entrepreneurship opportunities, training and employment opportunities.',

    'mission' => [
        'Celebrating over 10 years of organising career guidance development programmes in rural communities.',
        'Promoting and exposing real opportunities to youth in rural communities.',
        'Hosting capacitation workshops and programmes aimed at school teacher development.',
        'Tackling the national crisis of poverty and unemployment whilst restoring the dignity of rural communities.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Contact Details
    |--------------------------------------------------------------------------
    */

    'contact' => [
        'email' => 'info@rural2rural.co.za',
        'phone' => '+27 12 440 1325',
        'mobile' => '+27 64 503 4334',
        'address' => [
            '28 Panorama Road',
            'Rooihuiskraal',
            'Centurion',
            '0157',
        ],
        'postal' => [
            'street_address' => '28 Panorama Road, Rooihuiskraal',
            'locality' => 'Centurion',
            'region' => 'Gauteng',
            'postal_code' => '0157',
            'country_name' => 'South Africa',
            'country_code' => 'ZA',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Search & Social Sharing
    |--------------------------------------------------------------------------
    |
    | Used for the page title, meta description, Open Graph / Twitter cards
    | and schema.org structured data.
    |
    */

    'seo' => [
        'title' => 'Rural2Rural — Delivering Real Opportunities to Rural Communities',
        'share_title' => 'Rural2Rural (R2R) | Skills, Jobs, Careers & Entrepreneurship Initiative',
        'description' => 'Rural2Rural (R2R) travels across rural South Africa delivering career guidance, skills training, entrepreneurship support and teacher development to youth, women, small businesses and people living with disabilities. 10+ years on the road. Based in Centurion, Gauteng.',
        'slogan' => 'Delivering real opportunities to rural communities',
        'keywords' => 'Rural2Rural, R2R, rural development South Africa, career guidance, skills development, youth employment, entrepreneurship, SMME support, teacher development, career expo',
    ],

    /*
    |--------------------------------------------------------------------------
    | Social Profiles
    |--------------------------------------------------------------------------
    */

    'social' => [
        'X / Twitter' => 'https://twitter.com/Rural2Rural',
        'Facebook' => 'https://www.facebook.com/rural2rural',
        'Instagram' => 'https://www.instagram.com/rural2rural',
    ],

    /*
    |--------------------------------------------------------------------------
    | Programme Pillars
    |--------------------------------------------------------------------------
    */

    'pillars' => [
        ['step' => 'First', 'verb' => 'Careers', 'figure' => 'signpost', 'title' => 'Careers & Job Opportunities', 'body' => 'Career development roadshows, tutoring and guidance that open real career paths.'],
        ['step' => 'Second', 'verb' => 'Skills', 'figure' => 'gears', 'title' => 'Skills Training Workshops', 'body' => 'Soft skills, employability and work-readiness training for rural youth.'],
        ['step' => 'Third', 'verb' => 'Enterprise', 'figure' => 'stall', 'title' => 'Entrepreneurship Opportunities', 'body' => 'Roadshows, trainings, pitch competitions and SMME coaching & mentoring.'],
        ['step' => 'Last', 'verb' => 'Teachers', 'figure' => 'chalkboard', 'title' => 'Teacher Development Programmes', 'body' => 'Capacitation workshops distributed across rural communities and municipalities.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Programmes
    |--------------------------------------------------------------------------
    */

    'programmes' => [
        ['title' => 'Career Development Programme & Roadshow', 'pillar' => 'Careers'],
        ['title' => 'R2R Tutor Programme', 'pillar' => 'Maths · Science · Accounting'],
        ['title' => 'Teachers Capacitation Programme', 'pillar' => 'Teachers'],
        ['title' => 'Rural Teachers Summit', 'pillar' => 'Teachers'],
        ['title' => 'Entrepreneurship Opportunities Roadshow', 'pillar' => 'Enterprise'],
        ['title' => 'Business Idea Pitch Competition', 'pillar' => 'Enterprise'],
        ['title' => 'Rural SMME Coaching & Mentoring', 'pillar' => 'Enterprise'],
        ['title' => 'Skills & Job Opportunities Roadshow', 'pillar' => 'Skills'],
        ['title' => 'Work-Readiness & Soft Skills Programme', 'pillar' => 'Skills'],
        ['title' => 'Skills & Job Application Centre', 'pillar' => 'Skills'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Partners
    |--------------------------------------------------------------------------
    |
    | Logos live in public/images/partners.
    |
    */

    'partners' => [
        ['name' => 'EWSETA', 'description' => 'Energy and Water Sector Education and Training Authority', 'logo' => 'ewseta.png'],
        ['name' => 'FP&M SETA', 'description' => 'Fibre Processing & Manufacturing Sector Education and Training Authority', 'logo' => 'fpm-seta.png'],
        ['name' => 'TETA', 'description' => 'Transport Education Training Authority', 'logo' => 'teta.png'],
        ['name' => 'Zakhele N Foundation', 'description' => 'Career Accelerators', 'logo' => 'zakhele-n-foundation.png'],
        ['name' => 'Nongoma FM 88.3', 'description' => 'Community radio station', 'logo' => 'nongoma-fm.png'],
        ['name' => 'Green Youth Network', 'description' => 'Youth environmental network', 'logo' => 'Green-Youth-Network-Logo-1-150x150.jpeg'],
        ['name' => 'Influence Afrika', 'description' => 'Branding agency', 'logo' => 'Influence-Afrika-Logo-150x150.png'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    |
    | "place" is the province the event was held in. Add future events to
    | "upcoming" using the same shape; the Events page lists them first.
    |
    */

    'events' => [
        ['title' => 'Careers & Skills Expo', 'place' => 'Free State', 'date' => '17 Aug 2018'],
        ['title' => 'Careers & Skills Expo', 'place' => 'KwaZulu-Natal', 'date' => '03 Aug 2018'],
        ['title' => 'R2R Career Development', 'place' => 'Northern Cape', 'date' => '19 Oct 2017'],
    ],

    'upcoming_events' => [],

    /*
    |--------------------------------------------------------------------------
    | Media
    |--------------------------------------------------------------------------
    |
    | Photos live in public/images, videos in public/images/videos.
    |
    */

    'media' => [
        'photos' => [
            ['image' => 'partners/IMG_0300-scaled.jpg', 'caption' => 'Career Guidance Roadshow 2022'],
            ['image' => 'gallery/DSC0199-1024x683.jpg', 'caption' => 'Learners speak up'],
            ['image' => 'gallery/DSC0256-1024x683.jpg', 'caption' => 'Panel discussion with TETA'],
            ['image' => 'gallery/IMG_1609-1024x683.jpg', 'caption' => 'R2R Initiative panel'],
            ['image' => 'gallery/DSC0297-1024x683.jpg', 'caption' => 'R2R Connect magazine, 2017'],
            ['image' => 'r2r/learners.jpg', 'caption' => 'Career guidance session'],
            ['image' => 'r2r/volunteers.jpg', 'caption' => 'R2R roadshow team'],
            ['image' => 'r2r/leaders.jpg', 'caption' => 'Community & partners'],
            ['image' => 'r2r/village.jpg', 'caption' => 'Rural South Africa'],
        ],
        'videos' => [
            ['file' => 'videos/R2R-Limpopo_Marble-Hall.mp4', 'title' => 'R2R in Marble Hall', 'place' => 'Limpopo'],
        ],
        'publications' => [
            ['title' => 'Rural 2 Rural Opportunities: Connect', 'edition' => 'August/September 2017 · Health Special Edition', 'image' => 'gallery/DSC0297-1024x683.jpg'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    |
    | Useful links for learners, job seekers, teachers and small businesses.
    |
    */

    'resources' => [
        [
            'group' => 'Study & bursaries',
            'links' => [
                ['title' => 'NSFAS', 'description' => 'National Student Financial Aid Scheme — funding for university and TVET studies.', 'url' => 'https://www.nsfas.org.za'],
            ],
        ],
        [
            'group' => 'Jobs & youth opportunities',
            'links' => [
                ['title' => 'SAYouth.mobi', 'description' => 'Zero-rated platform for youth jobs, learnerships and opportunities.', 'url' => 'https://sayouth.mobi'],
                ['title' => 'NYDA', 'description' => 'National Youth Development Agency — youth business grants and support.', 'url' => 'https://www.nyda.gov.za'],
            ],
        ],
        [
            'group' => 'Skills & learnerships (our SETA partners)',
            'links' => [
                ['title' => 'EWSETA', 'description' => 'Energy and Water Sector Education and Training Authority.', 'url' => 'https://www.ewseta.org.za'],
                ['title' => 'FP&M SETA', 'description' => 'Fibre Processing & Manufacturing SETA.', 'url' => 'https://www.fpmseta.org.za'],
                ['title' => 'TETA', 'description' => 'Transport Education Training Authority.', 'url' => 'https://www.teta.org.za'],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    |
    | Annual and impact reports. PDFs go in public/reports, e.g.
    | ['title' => 'Annual Report', 'year' => '2024', 'file' => 'reports/annual-2024.pdf'].
    |
    */

    'reports' => [],

    /*
    |--------------------------------------------------------------------------
    | r2rBot
    |--------------------------------------------------------------------------
    |
    | The AI assistant on the site. It answers only from the facts above and
    | is rate limited per visitor to keep API spend predictable.
    |
    */

    'bot' => [
        'model' => env('R2R_BOT_MODEL', 'claude-opus-5-5'),
        'max_tokens' => (int) env('R2R_BOT_MAX_TOKENS', 4096),
        'max_turns' => 20,
        'max_message_length' => 1000,
        'per_minute' => (int) env('R2R_BOT_PER_MINUTE', 8),
        'per_day' => (int) env('R2R_BOT_PER_DAY', 60),
    ],

];
