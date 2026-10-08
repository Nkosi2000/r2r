<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));

        return view('admin.users.index', [
            'search' => $search,
            'users' => User::query()
                ->when($search !== '', fn ($query) => $query->whereLike('name', "%{$search}%")->orWhereLike('email', "%{$search}%"))
                ->orderBy('name')
                ->paginate(25)
                ->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.form', ['user' => new User(['role' => UserRole::Editor])]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        User::query()->create($request->validated());

        return to_route('admin.users.index')->with('status', 'Staff account created. Share the password with them securely; they can change it under "Your account".');
    }

    public function edit(User $user): View
    {
        return view('admin.users.form', ['user' => $user]);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update(array_filter($request->validated(), fn (mixed $value, string $key): bool => $key !== 'password' || filled($value), ARRAY_FILTER_USE_BOTH));

        return to_route('admin.users.index')->with('status', 'Staff account updated.');
    }

    /**
     * Staff can't delete themselves. As only admins reach this, the admin doing the deleting always remains,
     * so the CMS keeps someone who can manage staff.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->withErrors(['user' => 'You can\'t delete your own account.']);
        }

        $user->delete();

        return to_route('admin.users.index')->with('status', 'Staff account deleted.');
    }
}
