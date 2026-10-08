<?php

use App\Models\Event;
use Illuminate\Support\Collection;

beforeEach(function () {
    Event::query()->delete();

    Event::factory()->create(['title' => 'Limpopo Careers Expo', 'place' => 'Limpopo', 'held_on' => '2019-03-10']);
    Event::factory()->create(['title' => 'Rural Teachers Summit', 'place' => 'Eastern Cape', 'held_on' => '2021-06-02']);
    Event::factory()->create(['title' => 'Entrepreneurship Roadshow', 'place' => 'Mpumalanga', 'held_on' => '2023-09-15']);
    Event::factory()->upcoming()->create(['title' => 'Limpopo Skills Roadshow', 'place' => 'Limpopo']);
});

/**
 * Titles of the events the archive lists, in display order.
 *
 * @param  array<string, mixed>  $query
 * @return array<int, string>
 */
function filteredEventTitles(array $query = []): array
{
    $titles = [];

    test()->get(route('events', $query))
        ->assertOk()
        ->assertViewHas('filteredEvents', function (Collection $events) use (&$titles): bool {
            $titles = $events->pluck('title')->all();

            return true;
        });

    return $titles;
}

test('without filters every event is listed newest first', function () {
    expect(filteredEventTitles())->toBe([
        'Limpopo Skills Roadshow',
        'Entrepreneurship Roadshow',
        'Rural Teachers Summit',
        'Limpopo Careers Expo',
    ]);

    $this->get(route('events'))->assertSee('Showing 4 of 4 events');
});

test('keywords match title and province, ignoring case, and every word must match', function () {
    expect(filteredEventTitles(['q' => 'roadshow']))->toBe(['Limpopo Skills Roadshow', 'Entrepreneurship Roadshow'])
        ->and(filteredEventTitles(['q' => 'eastern']))->toBe(['Rural Teachers Summit'])
        ->and(filteredEventTitles(['q' => 'LIMPOPO expo']))->toBe(['Limpopo Careers Expo']);
});

test('several provinces can be selected at once', function () {
    expect(filteredEventTitles(['province' => ['Limpopo', 'Mpumalanga']]))->toBe([
        'Limpopo Skills Roadshow',
        'Entrepreneurship Roadshow',
        'Limpopo Careers Expo',
    ]);
});

test('events can be narrowed to upcoming or past', function () {
    expect(filteredEventTitles(['status' => 'upcoming']))->toBe(['Limpopo Skills Roadshow'])
        ->and(filteredEventTitles(['status' => 'past']))->toBe(['Entrepreneurship Roadshow', 'Rural Teachers Summit', 'Limpopo Careers Expo']);
});

test('a year range includes both end years and a reversed range is corrected', function () {
    expect(filteredEventTitles(['from' => '2019', 'to' => '2021']))->toBe(['Rural Teachers Summit', 'Limpopo Careers Expo'])
        ->and(filteredEventTitles(['from' => '2021', 'to' => '2019']))->toBe(['Rural Teachers Summit', 'Limpopo Careers Expo']);
});

test('filters combine and can be sorted oldest first', function () {
    expect(filteredEventTitles(['province' => ['Limpopo'], 'q' => 'roadshow']))->toBe(['Limpopo Skills Roadshow'])
        ->and(filteredEventTitles(['status' => 'past', 'sort' => 'oldest']))->toBe(['Limpopo Careers Expo', 'Rural Teachers Summit', 'Entrepreneurship Roadshow']);
});

test('malformed filter values are ignored instead of failing', function () {
    expect(filteredEventTitles(['q' => ['array'], 'province' => 'Limpopo', 'status' => 'soon', 'from' => 'abc', 'to' => '20231', 'sort' => 'random']))->toBe([
        'Limpopo Skills Roadshow',
        'Limpopo Careers Expo',
    ]);
});

test('no matches show an empty state with a way back to every event', function () {
    $this->get(route('events', ['q' => 'nothing matches this']))
        ->assertOk()
        ->assertSee('Showing 0 of 4 events')
        ->assertSee('No events match these filters')
        ->assertSee('Clear all filters');
});

test('removing one active filter keeps the others', function () {
    $this->get(route('events', ['province' => ['Limpopo', 'Mpumalanga'], 'status' => 'past']))
        ->assertOk()
        ->assertSee(e(route('events', ['province' => ['Mpumalanga'], 'status' => 'past']).'#all-events'), false)
        ->assertSee(e(route('events', ['province' => ['Limpopo', 'Mpumalanga']]).'#all-events'), false);
});
