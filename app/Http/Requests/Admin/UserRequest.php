<?php

namespace App\Http\Requests\Admin;

use App\Enums\UserRole;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    /**
     * The route's "manage-staff" gate already limits this to admins.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * A password is required for new accounts; when editing, leaving it empty keeps the current one.
     * The last admin can't be demoted, so the CMS always has someone who can manage staff.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');
        $isEditing = $user instanceof User;

        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($isEditing ? $user->id : null)],
            'role' => [
                'required',
                Rule::enum(UserRole::class),
                function (string $attribute, mixed $value, Closure $fail) use ($user, $isEditing): void {
                    $isLastAdmin = $isEditing && $user->isAdmin() && User::query()->where('role', UserRole::Admin)->count() === 1;

                    if ($isLastAdmin && $value !== UserRole::Admin->value) {
                        $fail('This is the only admin. Make someone else an admin first.');
                    }
                },
            ],
            'password' => [$isEditing ? 'nullable' : 'required', 'confirmed', Password::defaults()],
        ];
    }
}
