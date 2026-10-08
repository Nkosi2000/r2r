<?php

use App\Models\Event;
use App\Models\MediaItem;
use App\Models\Pillar;
use App\Models\Programme;
use App\Models\ResourceLink;
use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

test('a pillar can be added, edited and deleted, and the website reflects each change', function () {
    $this->post(route('admin.pillars.store'), [
        'step' => 'Next',
        'verb' => 'Digital',
        'figure' => 'gears',
        'title' => 'Digital Skills Bootcamps',
        'body' => 'Coding and digital literacy for rural youth.',
    ])->assertRedirect(route('admin.pillars.index'));

    $pillar = Pillar::query()->where('verb', 'Digital')->firstOrFail();
    expect($pillar->position)->toBe(Pillar::query()->max('position'));
    $this->get(route('what-we-do'))->assertSee('Digital Skills Bootcamps');

    $this->put(route('admin.pillars.update', $pillar), [...$pillar->only(['step', 'verb', 'figure', 'body']), 'title' => 'Digital Futures'])
        ->assertRedirect(route('admin.pillars.index'));
    $this->get(route('what-we-do'))->assertSee('Digital Futures')->assertDontSee('Digital Skills Bootcamps');

    $this->delete(route('admin.pillars.destroy', $pillar))->assertRedirect(route('admin.pillars.index'));
    expect(Pillar::query()->whereKey($pillar->id)->exists())->toBeFalse();
    $this->get(route('what-we-do'))->assertDontSee('Digital Futures');
});

test('invalid content is rejected with field errors', function () {
    $this->post(route('admin.pillars.store'), ['figure' => 'rocket'])
        ->assertSessionHasErrors(['step', 'verb', 'title', 'body', 'figure']);

    $this->post(route('admin.resources.store'), ['group' => 'Bursaries', 'title' => 'Unsafe link', 'description' => 'Funding', 'url' => 'javascript:alert(1)'])
        ->assertSessionHasErrors('url');

    expect(ResourceLink::query()->where('title', 'Unsafe link')->exists())->toBeFalse();
});

test('an event without coordinates is pinned in the middle of its province', function () {
    $this->post(route('admin.events.store'), [
        'title' => 'Limpopo Careers Expo',
        'place' => 'Limpopo',
        'held_on' => now()->addMonth()->toDateString(),
    ])->assertRedirect(route('admin.events.index'));

    $event = Event::query()->where('title', 'Limpopo Careers Expo')->firstOrFail();

    expect([$event->latitude, $event->longitude])->toBe(Event::PROVINCES['Limpopo']);
    $this->get(route('events'))->assertSeeInOrder(['Upcoming events', 'Limpopo Careers Expo']);
});

test('event coordinates must be given as a pair inside South Africa', function () {
    $this->post(route('admin.events.store'), ['title' => 'Expo', 'place' => 'Limpopo', 'held_on' => '2026-01-01', 'latitude' => -23.9])
        ->assertSessionHasErrors('longitude');

    $this->post(route('admin.events.store'), ['title' => 'Expo', 'place' => 'Narnia', 'held_on' => '2026-01-01', 'latitude' => 51.5, 'longitude' => -0.1])
        ->assertSessionHasErrors(['place', 'latitude', 'longitude']);
});

test('the event list can be searched', function () {
    Event::factory()->create(['title' => 'Mpumalanga Teachers Summit', 'place' => 'Mpumalanga']);

    $this->get(route('admin.events.index', ['q' => 'teachers']))
        ->assertOk()
        ->assertSee('Mpumalanga Teachers Summit')
        ->assertDontSee('R2R Career Development');
});

test('moving an item swaps it with its neighbour and the website follows the new order', function () {
    [$first, $second] = Programme::query()->orderBy('position')->take(2)->get()->all();

    $this->from(route('admin.programmes.index'))
        ->post(route('admin.reorder', ['programmes', $second->id, 'up']))
        ->assertRedirect(route('admin.programmes.index'));

    expect($second->fresh()->position)->toBeLessThan($first->fresh()->position);
    $this->get(route('what-we-do'))->assertSeeInOrder([$second->title, $first->title]);
});

test('moving the first item up leaves the order unchanged', function () {
    $positions = Programme::query()->orderBy('id')->pluck('position', 'id');
    $first = Programme::query()->orderBy('position')->first();

    $this->post(route('admin.reorder', ['programmes', $first->id, 'up']));

    expect(Programme::query()->orderBy('id')->pluck('position', 'id'))->toEqual($positions);
});

test('media is reordered only among items of the same type', function () {
    $photo = MediaItem::query()->where('type', 'photo')->orderBy('position')->get()->last();
    $videoPositions = MediaItem::query()->where('type', 'video')->pluck('position', 'id');

    $this->post(route('admin.reorder', ['media', $photo->id, 'up']));

    expect(MediaItem::query()->where('type', 'video')->pluck('position', 'id'))->toEqual($videoPositions);
});

test('unknown content types cannot be reordered', function () {
    $this->post('/admin/reorder/users/1/up')->assertNotFound();
});
