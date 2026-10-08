<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * The signed-in staff member's own name, email and password.
     */
    public function edit(Request $request): View
    {
        return view('admin.profile', ['user' => $request->user()]);
    }

    public function update(ProfileRequest $request): RedirectResponse
    {
        $request->user()->update($request->safe()->only(['name', 'email']));

        if ($request->filled('password')) {
            $request->user()->update(['password' => $request->validated('password')]);
        }

        return to_route('admin.profile.edit')->with('status', 'Your account has been updated.');
    }
}
