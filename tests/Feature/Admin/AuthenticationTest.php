<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

test('guests are sent to the sign-in page', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    $this->get(route('admin.pillars.index'))->assertRedirect(route('login'));
});

test('staff sign in with their email and password', function () {
    $user = User::factory()->create(['email' => 'thandi@rural2rural.co.za']);

    $this->post(route('login.store'), ['email' => 'thandi@rural2rural.co.za', 'password' => 'password'])
        ->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($user);
    $this->get(route('admin.dashboard'))->assertOk()->assertSee('Welcome, '.e($user->name), false);
});

test('a wrong password is rejected without revealing whether the account exists', function () {
    User::factory()->create(['email' => 'thandi@rural2rural.co.za']);

    $this->from(route('login'))
        ->post(route('login.store'), ['email' => 'thandi@rural2rural.co.za', 'password' => 'wrong-password'])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors(['email' => 'These details don\'t match a staff account.']);

    $this->assertGuest();
});

test('repeated failed sign-ins are rate limited', function () {
    User::factory()->create(['email' => 'thandi@rural2rural.co.za']);

    foreach (range(1, 5) as $attempt) {
        $this->post(route('login.store'), ['email' => 'thandi@rural2rural.co.za', 'password' => 'wrong-password']);
    }

    $this->post(route('login.store'), ['email' => 'thandi@rural2rural.co.za', 'password' => 'password'])
        ->assertTooManyRequests();

    $this->assertGuest();
});

test('signing out ends the session', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('admin.logout'))
        ->assertRedirect(route('login'));

    $this->assertGuest();
});

test('signed-in staff visiting the sign-in page go to the dashboard', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('login'))
        ->assertRedirect(route('admin.dashboard'));
});

test('staff can reset a forgotten password through the emailed link', function () {
    Notification::fake();
    $user = User::factory()->create(['email' => 'thandi@rural2rural.co.za']);

    $this->post(route('password.email'), ['email' => 'thandi@rural2rural.co.za'])
        ->assertSessionHas('status');

    Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use ($user): bool {
        $this->get(route('password.reset', ['token' => $notification->token, 'email' => $user->email]))->assertOk();

        $this->post(route('password.update'), [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'a-new-password',
            'password_confirmation' => 'a-new-password',
        ])->assertRedirect(route('login'));

        return true;
    });

    expect(Hash::check('a-new-password', $user->fresh()->password))->toBeTrue();
});

test('asking for a reset link for an unknown email gives the same response', function () {
    Notification::fake();

    $this->post(route('password.email'), ['email' => 'nobody@example.com'])
        ->assertSessionHas('status', 'If that address belongs to a staff account, a reset link is on its way.');

    Notification::assertNothingSent();
});

test('the create-admin command creates an admin who can sign in', function () {
    $this->artisan('cms:create-admin', ['--name' => 'Nkosi', '--email' => 'Nkosi@Rural2Rural.co.za', '--password' => 'secret-password'])
        ->assertSuccessful();

    $admin = User::query()->where('email', 'nkosi@rural2rural.co.za')->firstOrFail();

    expect($admin->isAdmin())->toBeTrue()
        ->and(Hash::check('secret-password', $admin->password))->toBeTrue();
});

test('the create-admin command rejects a weak password', function () {
    $this->artisan('cms:create-admin', ['--name' => 'Nkosi', '--email' => 'nkosi@rural2rural.co.za', '--password' => 'short'])
        ->assertFailed();

    expect(User::query()->count())->toBe(0);
});
