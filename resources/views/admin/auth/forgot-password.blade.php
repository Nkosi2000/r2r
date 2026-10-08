<x-layouts.admin-guest title="Reset your password">
    <p class="mb-5 text-[14px] text-navy/70">Enter your staff email address and we'll send you a link to choose a new password.</p>

    <form method="POST" action="{{ route('password.email') }}" class="grid gap-5">
        @csrf
        <x-admin.input name="email" label="Email" type="email" autocomplete="username" required autofocus />
        <x-button type="submit" variant="navy" class="justify-center">Email reset link</x-button>
        <a href="{{ route('login') }}" class="text-center text-[13px] text-navy/65 underline underline-offset-4 hover:text-navy">Back to sign in</a>
    </form>
</x-layouts.admin-guest>
