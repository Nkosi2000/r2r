<?php

use App\Models\SiteSetting;
use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->admin()->create());
});

/**
 * @return array<string, mixed>
 */
function contactForm(array $overrides = []): array
{
    return array_replace_recursive([
        'email' => 'hello@rural2rural.co.za',
        'phone' => '+27 12 000 0000',
        'mobile' => '+27 82 000 0000',
        'address' => "Corporate Park 66\nVon Willich Avenue\nCenturion\n0157",
        'postal' => ['street_address' => 'Corporate Park 66, Von Willich Avenue', 'locality' => 'Centurion', 'region' => 'Gauteng', 'postal_code' => '0157', 'country_name' => 'South Africa', 'country_code' => 'ZA'],
        'map' => ['label' => 'Gauteng · HQ', 'latitude' => '-25.85', 'longitude' => '28.19'],
        'google_maps' => ['place' => 'Corporate Park 66', 'url' => 'https://maps.app.goo.gl/vDi3Zg1EoHLXSjEk8', 'latitude' => '-25.8532455', 'longitude' => '28.1956626'],
    ], $overrides);
}

test('contact details are saved in the shape the website reads and shown on the contact page', function () {
    $this->put(route('admin.settings.contact'), contactForm())
        ->assertRedirect(route('admin.settings.edit').'#contact');

    $contact = SiteSetting::query()->where('key', 'contact')->value('value');

    expect($contact['address'])->toBe(['Corporate Park 66', 'Von Willich Avenue', 'Centurion', '0157'])
        ->and($contact['map']['latitude'])->toBe(-25.85)
        ->and($contact['google_maps']['latitude'])->toBe(-25.8532455);

    $this->get(route('contact'))
        ->assertSeeInOrder(['Corporate Park 66', 'Von Willich Avenue', 'Centurion'])
        ->assertSee('hello@rural2rural.co.za');
});

test('clearing the google map fields removes the map from the contact page', function () {
    $this->put(route('admin.settings.contact'), contactForm(['google_maps' => ['place' => '', 'url' => '', 'latitude' => '', 'longitude' => '']]))
        ->assertSessionHasNoErrors();

    expect(SiteSetting::query()->where('key', 'contact')->value('value'))->not->toHaveKey('google_maps');
    $this->get(route('contact'))->assertDontSee('maps.google.com/maps', false);
});

test('a half-filled google map is rejected', function () {
    $this->put(route('admin.settings.contact'), contactForm(['google_maps' => ['place' => 'Corporate Park 66', 'url' => '', 'latitude' => '', 'longitude' => '']]))
        ->assertSessionHasErrors(['google_maps.url', 'google_maps.latitude', 'google_maps.longitude']);
});

test('the mission is saved one commitment per line', function () {
    $this->put(route('admin.settings.about'), [
        'about' => 'Rural2Rural takes opportunity to rural South Africa.',
        'mission' => "Expose youth to real opportunities.\r\n\r\n  Develop rural teachers.  \n",
    ])->assertSessionHasNoErrors();

    expect(SiteSetting::query()->where('key', 'mission')->value('value'))->toBe(['Expose youth to real opportunities.', 'Develop rural teachers.']);
    $this->get(route('about'))->assertSee('Develop rural teachers.');
});

test('empty social rows are dropped and the rest appear on the website', function () {
    $this->put(route('admin.settings.social'), [
        'social' => [
            ['platform' => 'Facebook', 'url' => 'https://www.facebook.com/rural2rural'],
            ['platform' => 'LinkedIn', 'url' => 'https://www.linkedin.com/company/rural2rural'],
            ['platform' => '', 'url' => ''],
        ],
    ])->assertSessionHasNoErrors();

    expect(SiteSetting::query()->where('key', 'social')->value('value'))->toHaveCount(2);
    $this->get(route('contact'))->assertSee('https://www.linkedin.com/company/rural2rural', false)->assertDontSee('instagram.com', false);
});

test('seo settings change the page titles', function () {
    $this->put(route('admin.settings.seo'), [
        'title' => 'Rural2Rural — Opportunity on the road',
        'share_title' => 'Rural2Rural (R2R)',
        'description' => 'Skills, jobs and careers for rural South Africa.',
        'slogan' => 'Opportunity on the road',
        'keywords' => 'rural, careers',
    ])->assertSessionHasNoErrors();

    $this->get(route('home'))->assertSee('<title>Rural2Rural — Opportunity on the road</title>', false);
});

test('the settings page loads with the current values', function () {
    $this->get(route('admin.settings.edit'))
        ->assertOk()
        ->assertSee('info@rural2rural.co.za')
        ->assertSee('Celebrating over 10 years');
});
