<x-layouts.admin title="Staff">
    <x-admin.page-header title="Staff" description="Everyone who can sign in to the CMS. Editors manage website content; admins can also manage staff and site settings.">
        <x-button :href="route('admin.users.create')" variant="navy">Add staff member</x-button>
    </x-admin.page-header>

    <x-admin.search :value="$search" placeholder="Search by name or email" />

    <div class="overflow-x-auto border border-navy/10">
        <table class="admin-table">
            <thead>
                <tr><th>Name</th><th>Email</th><th>Role</th><th><span class="sr-only">Actions</span></th></tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="font-medium">{{ $user->name }}@if ($user->is(auth()->user()))<span class="ml-2 font-mono text-[9px] tracking-[0.1em] text-navy/50 uppercase">(you)</span>@endif</td>
                        <td class="text-[13px]">{{ $user->email }}</td>
                        <td><span class="px-2 py-1 font-mono text-[9px] tracking-[0.1em] uppercase {{ $user->isAdmin() ? 'bg-navy text-white' : 'ring-1 ring-navy/20' }}">{{ $user->role->label() }}</span></td>
                        <td>
                            @if ($user->is(auth()->user()))
                                <div class="text-right"><a href="{{ route('admin.profile.edit') }}" class="px-2.5 py-1.5 text-[13px] text-blue hover:underline">Your account</a></div>
                            @else
                                <x-admin.row-actions :edit="route('admin.users.edit', $user)" :destroy="route('admin.users.destroy', $user)" :name="$user->name" />
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $users->links() }}</div>
</x-layouts.admin>
