<?php

dataset('pages', [
    'home' => ['home', 'Delivering Real'],
    'who we are' => ['about', 'Our mission, in four commitments.'],
    'what we do' => ['what-we-do', 'Meet the programmes built for every rural learner'],
    'our partners' => ['partners', 'Ways to'],
    'media' => ['media', 'Photo gallery'],
    'events' => ['events', 'Upcoming events'],
    'resources' => ['resources', 'NSFAS'],
    'reports' => ['reports', 'Reports &amp; documents'],
    'contact us' => ['contact', 'Head office'],
]);

test('every page renders with the shared navigation', function (string $routeName, string $expectedContent) {
    $this->get(route($routeName))
        ->assertOk()
        ->assertSee($expectedContent, false)
        ->assertSeeInOrder(['Home', 'Who We Are', 'What We Do', 'Our Partners', 'Media', 'Events', 'Resources', 'Reports', 'Contact Us'])
        ->assertSee('aria-current="page"', false);
})->with('pages');

test('inner pages have their own title and canonical url', function () {
    $this->get(route('partners'))
        ->assertOk()
        ->assertSee('<title>Our Partners — Rural2Rural</title>', false)
        ->assertSee('<link rel="canonical" href="'.route('partners').'">', false);
});

test('only the home page shows the preloader', function () {
    $this->get(route('home'))->assertSee('data-preloader', false);
    $this->get(route('about'))->assertDontSee('data-preloader', false);
});

test('every partner is listed on the partners page', function () {
    $response = $this->get(route('partners'))->assertOk();

    foreach (config('rural2rural.partners') as $partner) {
        $response->assertSee(e($partner['name']), false)
            ->assertSee('images/partners/'.$partner['logo'], false);
    }

    $response->assertSee('Green Youth Network')->assertSee('Influence Afrika');
});

test('events are shown by province', function () {
    $this->get(route('events'))
        ->assertOk()
        ->assertSee('Free State')
        ->assertSee('KwaZulu-Natal')
        ->assertSee('Gauteng · HQ')
        ->assertDontSee('Ficksburg')
        ->assertDontSee('Jozini');
});

test('the contact page shows the office address', function () {
    $this->get(route('contact'))
        ->assertOk()
        ->assertSeeInOrder(['28 Panorama Road', 'Rooihuiskraal', 'Centurion', '0157'])
        ->assertDontSee('Von Willich');
});
