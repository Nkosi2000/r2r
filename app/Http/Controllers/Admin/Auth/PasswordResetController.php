<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    /**
     * Show the "forgot password" form.
     */
    public function request(): View
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Email a reset link. The response is the same whether or not the address has an account,
     * so the form can't be used to discover staff email addresses.
     */
    public function email(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        Password::sendResetLink($request->only('email'));

        return back()->with('status', 'If that address belongs to a staff account, a reset link is on its way.');
    }

    /**
     * Show the form for choosing a new password.
     */
    public function edit(Request $request, string $token): View
    {
        return view('admin.auth.reset-password', ['token' => $token, 'email' => $request->query('email')]);
    }

    /**
     * Save the new password.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                $user->forceFill(['password' => $password])->setRememberToken(Str::random(60));
                $user->save();

                event(new PasswordReset($user));
            },
        );

        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('status', 'Your password has been reset. You can sign in now.')
            : back()->withInput($request->only('email'))->withErrors(['email' => __($status)]);
    }
}
