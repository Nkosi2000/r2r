<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
    $this->actingAs($this->admin);
});

test('an admin can add an editor who can then sign in', function () {
    $this->post(route('admin.users.store'), [
        'name' => 'Lerato Mokoena',
        'email' => 'lerato@rural2rural.co.za',
        'role' => 'editor',
        'password' => 'welcome-to-r2r',
        'password_confirmation' => 'welcome-to-r2r',
    ])->assertRedirect(route('admin.users.index'));

    $editor = User::query()->where('email', 'lerato@rural2rural.co.za')->firstOrFail();

    expect($editor->role)->toBe(UserRole::Editor)
        ->and(Hash::check('welcome-to-r2r', $editor->password))->toBeTrue();
});

test('staff emails must be unique', function () {
    $this->post(route('admin.users.store'), [
        'name' => 'Duplicate',
        'email' => $this->admin->email,
        'role' => 'editor',
        'password' => 'welcome-to-r2r',
        'password_confirmation' => 'welcome-to-r2r',
    ])->assertSessionHasErrors('email');
});

test('editing a staff member without a new password keeps their password', function () {
    $editor = User::factory()->create();
    $passwordHash = $editor->password;

    $this->put(route('admin.users.update', $editor), ['name' => 'New Name', 'email' => $editor->email, 'role' => 'admin', 'password' => '', 'password_confirmation' => ''])
        ->assertRedirect(route('admin.users.index'));

    expect($editor->fresh())
        ->name->toBe('New Name')
        ->role->toBe(UserRole::Admin)
        ->password->toBe($passwordHash);
});

test('the only admin cannot be demoted', function () {
    $this->put(route('admin.users.update', $this->admin), ['name' => $this->admin->name, 'email' => $this->admin->email, 'role' => 'editor'])
        ->assertSessionHasErrors('role');

    expect($this->admin->fresh()->isAdmin())->toBeTrue();
});

test('staff cannot delete their own account', function () {
    $this->from(route('admin.users.index'))
        ->delete(route('admin.users.destroy', $this->admin))
        ->assertSessionHasErrors('user');

    expect($this->admin->fresh())->not->toBeNull();
});

test('an admin can delete another staff member', function () {
    $editor = User::factory()->create();

    $this->delete(route('admin.users.destroy', $editor))->assertRedirect(route('admin.users.index'));

    expect($editor->fresh())->toBeNull();
});

test('staff can change their own password only with their current one', function () {
    $editor = User::factory()->create();
    $this->actingAs($editor);

    $this->put(route('admin.profile.update'), ['name' => $editor->name, 'email' => $editor->email, 'current_password' => 'wrong', 'password' => 'brand-new-pass', 'password_confirmation' => 'brand-new-pass'])
        ->assertSessionHasErrors('current_password');

    $this->put(route('admin.profile.update'), ['name' => $editor->name, 'email' => $editor->email, 'current_password' => 'password', 'password' => 'brand-new-pass', 'password_confirmation' => 'brand-new-pass'])
        ->assertRedirect(route('admin.profile.edit'));

    expect(Hash::check('brand-new-pass', $editor->fresh()->password))->toBeTrue();
});
