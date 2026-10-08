<?php

use App\Models\MediaItem;
use App\Models\Partner;
use App\Models\Report;
use App\Models\User;
use App\Support\Uploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake(Uploads::DISK);
    $this->actingAs(User::factory()->create());
});

test('a partner logo is uploaded to object storage and shown on the website', function () {
    $this->post(route('admin.partners.store'), [
        'name' => 'Sasol Foundation',
        'description' => 'Corporate social investment',
        'website' => 'https://www.sasol.com',
        'logo' => UploadedFile::fake()->image('sasol.png', 300, 150),
    ])->assertRedirect(route('admin.partners.index'));

    $partner = Partner::query()->where('name', 'Sasol Foundation')->firstOrFail();

    expect($partner->logo)->toStartWith('partners/');
    Storage::disk(Uploads::DISK)->assertExists($partner->logo);
    $this->get(route('partners'))->assertSee($partner->logo_url, false);
});

test('a partner needs a logo, and it must be an image', function () {
    $this->post(route('admin.partners.store'), ['name' => 'No Logo', 'description' => 'Missing'])
        ->assertSessionHasErrors('logo');

    $this->post(route('admin.partners.store'), ['name' => 'Bad Logo', 'description' => 'Wrong type', 'logo' => UploadedFile::fake()->create('logo.pdf', 100, 'application/pdf')])
        ->assertSessionHasErrors('logo');
});

test('replacing an uploaded file removes the old one', function () {
    $report = Report::factory()->create(['file' => UploadedFile::fake()->create('old.pdf', 100, 'application/pdf')->storeAs('reports', 'old.pdf', Uploads::DISK)]);

    $this->put(route('admin.reports.update', $report), [
        'title' => $report->title,
        'year' => $report->year,
        'file' => UploadedFile::fake()->create('annual-2025.pdf', 200, 'application/pdf'),
    ])->assertRedirect(route('admin.reports.index'));

    Storage::disk(Uploads::DISK)->assertMissing('reports/old.pdf');
    Storage::disk(Uploads::DISK)->assertExists($report->fresh()->file);
});

test('editing without choosing a new file keeps the current one', function () {
    $partner = Partner::query()->firstOrFail();
    $logo = $partner->logo;

    $this->put(route('admin.partners.update', $partner), ['name' => 'Renamed Partner', 'description' => $partner->description])
        ->assertRedirect(route('admin.partners.index'));

    expect($partner->fresh())->name->toBe('Renamed Partner')->logo->toBe($logo);
});

test('deleting a record removes its upload but never the files bundled with the site', function () {
    $uploaded = MediaItem::factory()->create(['path' => UploadedFile::fake()->image('road.jpg')->storeAs('media/photo', 'road.jpg', Uploads::DISK)]);
    $bundled = Partner::query()->where('logo', 'like', 'images/%')->firstOrFail();

    $this->delete(route('admin.media.destroy', $uploaded));
    $this->delete(route('admin.partners.destroy', $bundled));

    Storage::disk(Uploads::DISK)->assertMissing('media/photo/road.jpg');
    expect(file_exists(public_path($bundled->logo)))->toBeTrue();
});

test('a video upload accepts video files and rejects images', function () {
    $this->post(route('admin.media.store'), ['type' => 'video', 'title' => 'Roadshow highlights', 'file' => UploadedFile::fake()->image('still.jpg')])
        ->assertSessionHasErrors('file');

    $this->post(route('admin.media.store'), ['type' => 'video', 'title' => 'Roadshow highlights', 'subtitle' => 'Limpopo', 'file' => UploadedFile::fake()->create('clip.mp4', 500, 'video/mp4')])
        ->assertRedirect(route('admin.media.index', ['type' => 'video']));

    $video = MediaItem::query()->where('title', 'Roadshow highlights')->firstOrFail();
    expect($video->path)->toStartWith('media/video/');
    $this->get(route('media'))->assertSee($video->url, false);
});

test('a published report links to its PDF in object storage', function () {
    $this->post(route('admin.reports.store'), ['title' => 'Impact Report', 'year' => 2025, 'file' => UploadedFile::fake()->create('impact.pdf', 300, 'application/pdf')])
        ->assertRedirect(route('admin.reports.index'));

    $report = Report::query()->where('title', 'Impact Report')->firstOrFail();

    $this->get(route('reports'))->assertSee('Impact Report')->assertSee($report->file_url, false)->assertDontSee('Coming soon');
});
