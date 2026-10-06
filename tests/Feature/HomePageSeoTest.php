<?php

test('the home page has a rich social share preview', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('<meta property="og:type" content="business.business">', false)
        ->assertSee('<meta property="og:title" content="Rural2Rural (R2R) | Skills, Jobs, Careers &amp; Entrepreneurship Initiative">', false)
        ->assertSee('property="og:description" content="Rural2Rural (R2R) travels across rural South Africa', false)
        ->assertSee('images/og/rural2rural-og.png?v=', false)
        ->assertSee('<meta property="og:image:width" content="1200">', false)
        ->assertSee('images/og/rural2rural-square.png?v=', false)
        ->assertSee('<meta property="business:contact_data:email" content="info@rural2rural.co.za">', false)
        ->assertSee('<meta property="business:contact_data:phone_number" content="+27 12 440 1325">', false)
        ->assertSee('<meta name="twitter:card" content="summary_large_image">', false);
});

test('the home page publishes schema.org organisation data', function () {
    $html = $this->get(route('home'))->assertOk()->getContent();

    preg_match('#<script type="application/ld\+json">(.+?)</script>#s', $html, $matches);
    $organisation = json_decode($matches[1] ?? '', true);

    expect($organisation)
        ->toBeArray()
        ->and($organisation['@type'])->toBe('NGO')
        ->and($organisation['name'])->toBe('Rural2Rural')
        ->and($organisation['email'])->toBe('info@rural2rural.co.za')
        ->and($organisation['address']['addressLocality'])->toBe('Centurion')
        ->and($organisation['sameAs'])->toContain('https://www.facebook.com/rural2rural')
        ->and($organisation['knowsAbout'])->toContain('Teacher Development Programmes');
});
