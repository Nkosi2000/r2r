<x-layouts.admin-guest title="Sign in">
    <form method="POST" action="{{ route('login.store') }}" class="grid gap-5">
        @csrf
        <x-admin.input name="email" label="Email" type="email" autocomplete="username" required autofocus />
        <x-admin.input name="password" label="Password" type="password" autocomplete="current-password" required />

        <label class="flex items-center gap-2 text-[13px]">
            <input type="checkbox" name="remember" value="1" class="size-4 accent-navy">
            Keep me signed in
        </label>

        <x-button type="submit" variant="navy" class="justify-center">Sign in</x-button>
        <a href="{{ route('password.request') }}" class="text-center text-[13px] text-navy/65 underline underline-offset-4 hover:text-navy">Forgot your password?</a>
    </form>
</x-layouts.admin-guest>
