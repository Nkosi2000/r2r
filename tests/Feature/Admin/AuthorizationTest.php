<?php

use App\Models\User;

test('editors manage every kind of content', function (string $route) {
    $this->actingAs(User::factory()->create())
        ->get(route($route))
        ->assertOk();
})->with([
    'admin.dashboard',
    'admin.pillars.index',
    'admin.programmes.index',
    'admin.partners.index',
    'admin.events.index',
    'admin.media.index',
    'admin.resources.index',
    'admin.reports.index',
    'admin.profile.edit',
]);

test('editors cannot manage staff or site settings', function () {
    $editor = User::factory()->create();

    $this->actingAs($editor)->get(route('admin.users.index'))->assertForbidden();
    $this->actingAs($editor)->post(route('admin.users.store'), [])->assertForbidden();
    $this->actingAs($editor)->get(route('admin.settings.edit'))->assertForbidden();
    $this->actingAs($editor)->put(route('admin.settings.seo'), [])->assertForbidden();
});

test('editors do not see the administration links', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.dashboard'))
        ->assertDontSee('Site settings')
        ->assertDontSee(route('admin.users.index'));
});

test('admins manage staff and site settings', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)->get(route('admin.users.index'))->assertOk();
    $this->actingAs($admin)->get(route('admin.settings.edit'))->assertOk();
    $this->actingAs($admin)->get(route('admin.dashboard'))->assertSee('Site settings');
});
