<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

/**
 * Bootstraps the CMS: creates an admin who can then add the rest of the staff from /admin/users.
 */
#[Signature('cms:create-admin {--name= : Full name} {--email= : Email address used to sign in} {--password= : Password (prompted for when left out)}')]
#[Description('Create a CMS admin account')]
class CreateAdmin extends Command
{
    public function handle(): int
    {
        $attributes = [
            'name' => $this->option('name') ?? text('Name', required: true),
            'email' => $this->option('email') ?? text('Email', required: true),
            'password' => $this->option('password') ?? password('Password (at least 8 characters)', required: true),
        ];

        $validator = Validator::make($attributes, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Password::defaults()],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->components->error($error);
            }

            return self::FAILURE;
        }

        User::query()->create([...$attributes, 'email' => strtolower($attributes['email']), 'role' => UserRole::Admin]);

        $this->components->info('Admin created. Sign in at '.route('login').' with '.strtolower($attributes['email']).'.');

        return self::SUCCESS;
    }
}
