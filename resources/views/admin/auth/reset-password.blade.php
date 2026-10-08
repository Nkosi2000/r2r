<x-layouts.admin-guest title="Choose a new password">
    <form method="POST" action="{{ route('password.update') }}" class="grid gap-5">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <x-admin.input name="email" label="Email" type="email" :value="$email" autocomplete="username" required />
        <x-admin.input name="password" label="New password" type="password" hint="At least 8 characters." autocomplete="new-password" required autofocus />
        <x-admin.input name="password_confirmation" label="Confirm new password" type="password" autocomplete="new-password" required />
        <x-button type="submit" variant="navy" class="justify-center">Save password</x-button>
    </form>
</x-layouts.admin-guest>
