<?php

use App\Models\Event;
use App\Models\Partner;
use App\Models\Report;
use App\Models\SiteSetting;
use Database\Seeders\ContentSeeder;
use Illuminate\Support\Facades\Route;

test('an upcoming event is listed under upcoming and placed on the map', function () {
    Event::factory()->upcoming()->create([
        'title' => 'Limpopo Careers Expo',
        'place' => 'Limpopo',
        'latitude' => -23.9,
        'longitude' => 29.45,
    ]);

    $this->get(route('events'))
        ->assertOk()
        ->assertSeeInOrder(['Upcoming events', 'Limpopo Careers Expo', 'Past events'])
        ->assertDontSee('Route being planned')
        ->assertSee('data-map-node="limpopo"', false)
        ->assertSee('hq-limpopo', false);
});

test('events without upcoming dates show the host-a-roadshow prompt', function () {
    $this->get(route('events'))
        ->assertOk()
        ->assertSee('Route being planned');
});

test('published reports replace the coming soon panel', function () {
    Report::factory()->create(['title' => 'Annual Report', 'year' => 2025, 'file' => 'reports/annual-2025.pdf']);

    $this->get(route('reports'))
        ->assertOk()
        ->assertSee('Annual Report')
        ->assertSee('reports/annual-2025.pdf', false)
        ->assertDontSee('Coming soon');
});

test('editing a setting updates the site straight away', function () {
    $this->get(route('contact'))->assertSee('+27 12 440 1325');

    $setting = SiteSetting::query()->where('key', 'contact')->firstOrFail();
    $setting->update(['value' => [...$setting->value, 'phone' => '+27 12 000 0000']]);

    $this->get(route('contact'))
        ->assertSee('+27 12 000 0000')
        ->assertDontSee('+27 12 440 1325');
});

test('the deploy health check passes when the database and content are ready', function () {
    $this->get('/up')->assertOk();
});

test('the deploy health check fails when the site content is missing', function () {
    SiteSetting::query()->get()->each->delete();

    $this->get('/up')->assertServerError();
});

test('the deploy health check fails when a page cannot render', function () {
    Route::view('/broken-page', 'pages.does-not-exist');

    $this->get('/up')->assertServerError();
});

test('re-running the content seeder keeps edits made in the database', function () {
    Partner::query()->where('name', 'TETA')->firstOrFail()->update(['description' => 'Edited description']);

    $this->seed(ContentSeeder::class);

    expect(Partner::query()->where('name', 'TETA')->value('description'))->toBe('Edited description')
        ->and(Partner::query()->where('name', 'TETA')->count())->toBe(1);
});

test('a new partner appears on the home page strip and partners page', function () {
    Partner::factory()->create(['name' => 'Limpopo Youth Trust', 'logo' => 'images/partners/limpopo-youth-trust.png']);

    $this->get(route('home'))->assertSee('Limpopo Youth Trust');
    $this->get(route('partners'))->assertSee('images/partners/limpopo-youth-trust.png', false);
});
