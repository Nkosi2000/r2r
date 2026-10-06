{{--
    Page title, search meta, Open Graph / Facebook business tags, Twitter card
    and schema.org NGO data — all driven by config('rural2rural').
--}}
@php
    $site = config('rural2rural');
    $seo = $site['seo'];
    $contact = $site['contact'];
    $postal = $contact['postal'];
    $homeUrl = route('home');

    $versioned = fn (string $path): string => asset($path).'?v='.(file_exists(public_path($path)) ? filemtime(public_path($path)) : '1');
    $shareImage = $versioned('images/og/rural2rural-og.png');
    $squareImage = $versioned('images/og/rural2rural-square.png');
    $imageAlt = 'Rural2Rural — '.$seo['slogan'].'. Careers & jobs, skills training, entrepreneurship and teacher development across rural South Africa.';

    $organisation = [
        '@context' => 'https://schema.org',
        '@type' => 'NGO',
        '@id' => $homeUrl.'#organization',
        'name' => 'Rural2Rural',
        'alternateName' => ['R2R', 'Rural2Rural Skills, Jobs, Careers & Entrepreneurship Initiative'],
        'url' => $homeUrl,
        'logo' => asset('images/rural2rural.png'),
        'image' => $shareImage,
        'description' => $seo['description'],
        'slogan' => $seo['slogan'],
        'email' => $contact['email'],
        'telephone' => $contact['phone'],
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $postal['street_address'],
            'addressLocality' => $postal['locality'],
            'addressRegion' => $postal['region'],
            'postalCode' => $postal['postal_code'],
            'addressCountry' => $postal['country_code'],
        ],
        'contactPoint' => [
            ['@type' => 'ContactPoint', 'contactType' => 'general enquiries', 'telephone' => $contact['phone'], 'email' => $contact['email'], 'areaServed' => $postal['country_code'], 'availableLanguage' => ['English']],
            ['@type' => 'ContactPoint', 'contactType' => 'mobile', 'telephone' => $contact['mobile'], 'areaServed' => $postal['country_code']],
        ],
        'areaServed' => ['@type' => 'Country', 'name' => $postal['country_name']],
        'knowsAbout' => collect($site['pillars'])->pluck('title')->all(),
        'sameAs' => array_values($site['social']),
    ];
@endphp

<title>{{ $seo['title'] }}</title>
<meta name="description" content="{{ $seo['description'] }}">
<meta name="keywords" content="{{ $seo['keywords'] }}">
<meta name="author" content="Rural2Rural">
<meta name="robots" content="index, follow, max-image-preview:large">
<link rel="canonical" href="{{ $homeUrl }}">
<link rel="apple-touch-icon" href="{{ asset('images/r2r/mark.png') }}">

{{-- Open Graph (WhatsApp, Facebook, LinkedIn, Slack, Teams) --}}
<meta property="og:type" content="business.business">
<meta property="og:site_name" content="Rural2Rural">
<meta property="og:locale" content="en_ZA">
<meta property="og:url" content="{{ $homeUrl }}">
<meta property="og:title" content="{{ $seo['share_title'] }}">
<meta property="og:description" content="{{ $seo['description'] }}">
<meta property="og:image" content="{{ $shareImage }}">
<meta property="og:image:secure_url" content="{{ $shareImage }}">
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ $imageAlt }}">
<meta property="og:image" content="{{ $squareImage }}">
<meta property="og:image:secure_url" content="{{ $squareImage }}">
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="600">
<meta property="og:image:height" content="600">
<meta property="og:image:alt" content="Rural2Rural logo">

{{-- Facebook business contact details --}}
<meta property="business:contact_data:street_address" content="{{ $postal['street_address'] }}">
<meta property="business:contact_data:locality" content="{{ $postal['locality'] }}">
<meta property="business:contact_data:region" content="{{ $postal['region'] }}">
<meta property="business:contact_data:postal_code" content="{{ $postal['postal_code'] }}">
<meta property="business:contact_data:country_name" content="{{ $postal['country_name'] }}">
<meta property="business:contact_data:email" content="{{ $contact['email'] }}">
<meta property="business:contact_data:phone_number" content="{{ $contact['phone'] }}">
<meta property="business:contact_data:website" content="{{ $homeUrl }}">

{{-- X / Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@Rural2Rural">
<meta name="twitter:title" content="{{ $seo['share_title'] }}">
<meta name="twitter:description" content="{{ $seo['description'] }}">
<meta name="twitter:image" content="{{ $shareImage }}">
<meta name="twitter:image:alt" content="{{ $imageAlt }}">

{{-- Search engines (Google knowledge panel / rich results) --}}
<script type="application/ld+json">{!! json_encode($organisation, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
