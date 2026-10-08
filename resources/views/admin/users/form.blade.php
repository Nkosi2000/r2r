@php($isEditing = $user->exists)

<x-layouts.admin :title="$isEditing ? 'Edit staff member' : 'Add staff member'">
    <x-admin.page-header :title="$isEditing ? 'Edit staff member' : 'Add staff member'" :back="route('admin.users.index')" />

    <x-admin.form :action="$isEditing ? route('admin.users.update', $user) : route('admin.users.store')" :method="$isEditing ? 'PUT' : 'POST'" :submit="$isEditing ? 'Save changes' : 'Create account'" :cancel="route('admin.users.index')">
        <div class="grid gap-6 sm:grid-cols-2">
            <x-admin.input name="name" label="Name" :value="$user->name" autocomplete="off" required />
            <x-admin.input name="email" label="Email" type="email" :value="$user->email" autocomplete="off" hint="Used to sign in and to reset the password." required />
        </div>

        <fieldset>
            <legend class="mb-2 text-[13px] font-medium">Role <span class="text-red-600" aria-hidden="true">*</span></legend>
            <div class="grid gap-3 sm:grid-cols-2">
                @foreach (App\Enums\UserRole::cases() as $role)
                    <label class="flex cursor-pointer gap-3 border border-navy/20 p-4 has-checked:border-navy has-checked:bg-paper">
                        <input type="radio" name="role" value="{{ $role->value }}" @checked(old('role', $user->role?->value) === $role->value) class="mt-0.5 size-4 accent-navy">
                        <span>
                            <span class="block text-[14px] font-medium">{{ $role->label() }}</span>
                            <span class="text-[12px] text-navy/60">{{ $role->description() }}</span>
                        </span>
                    </label>
                @endforeach
            </div>
            @error('role')
                <p class="mt-1.5 text-[12px] text-red-600">{{ $message }}</p>
            @enderror
        </fieldset>

        <div class="grid gap-6 border-t border-navy/10 pt-6 sm:grid-cols-2">
            <x-admin.input name="password" :label="$isEditing ? 'New password' : 'Password'" type="password" autocomplete="new-password" :hint="$isEditing ? 'Leave empty to keep their current password.' : 'At least 8 characters. Share it with them securely.'" :required="! $isEditing" />
            <x-admin.input name="password_confirmation" label="Confirm password" type="password" autocomplete="new-password" :required="! $isEditing" />
        </div>
    </x-admin.form>
</x-layouts.admin>
