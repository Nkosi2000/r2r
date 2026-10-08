<x-layouts.admin title="Your account">
    <x-admin.page-header title="Your account" :description="'Signed in as '.$user->role->label().'.'" />

    <x-admin.form :action="route('admin.profile.update')" method="PUT" submit="Save changes">
        <div class="grid gap-6 sm:grid-cols-2">
            <x-admin.input name="name" label="Name" :value="$user->name" autocomplete="name" required />
            <x-admin.input name="email" label="Email" type="email" :value="$user->email" autocomplete="username" required />
        </div>

        <fieldset class="grid gap-6 border-t border-navy/10 pt-6">
            <legend class="text-[13px] font-medium">Change password <span class="font-normal text-navy/55">(optional)</span></legend>
            <x-admin.input name="current_password" label="Current password" type="password" autocomplete="current-password" class="sm:max-w-sm" />
            <div class="grid gap-6 sm:grid-cols-2">
                <x-admin.input name="password" label="New password" type="password" autocomplete="new-password" hint="At least 8 characters." />
                <x-admin.input name="password_confirmation" label="Confirm new password" type="password" autocomplete="new-password" />
            </div>
        </fieldset>
    </x-admin.form>
</x-layouts.admin>
