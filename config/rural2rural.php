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
            'Corporate Park 66',
            '66 Von Willich Ave',
            'Die Hoewes, Centurion',
            'Pretoria, South Africa',
            '0163',
        ],
        'postal' => [
            'street_address' => 'Corporate Park 66, 66 Von Willich Ave, Die Hoewes',
            'locality' => 'Centurion',
            'region' => 'Gauteng',
            'postal_code' => '0163',
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
        ['step' => 'First', 'verb' => 'Careers', 'figure' => 'bloom', 'title' => 'Careers & Job Opportunities', 'body' => 'Career development roadshows, tutoring and guidance that open real career paths.'],
        ['step' => 'Second', 'verb' => 'Skills', 'figure' => 'orbit', 'title' => 'Skills Training Workshops', 'body' => 'Soft skills, employability and work-readiness training for rural youth.'],
        ['step' => 'Third', 'verb' => 'Enterprise', 'figure' => 'burst', 'title' => 'Entrepreneurship Opportunities', 'body' => 'Roadshows, trainings, pitch competitions and SMME coaching & mentoring.'],
        ['step' => 'Last', 'verb' => 'Teachers', 'figure' => 'seed', 'title' => 'Teacher Development Programmes', 'body' => 'Capacitation workshops distributed across rural communities and municipalities.'],
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
    ],

    /*
    |--------------------------------------------------------------------------
    | Past Events
    |--------------------------------------------------------------------------
    */

    'events' => [
        ['title' => 'Careers & Skills Expo', 'place' => 'Ficksburg', 'date' => '17 Aug 2018'],
        ['title' => 'Careers & Skills Expo', 'place' => 'Jozini', 'date' => '03 Aug 2018'],
        ['title' => 'R2R Career Development', 'place' => 'Northern Cape', 'date' => '19 Oct 2017'],
    ],

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
