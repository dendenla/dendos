<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('admin:create')]
#[Description('Create the configured application administrator')]
class CreateAdmin extends Command
{
    public function handle(): int
    {
        $email = config('app.admin_email');

        if (! is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->error('Set a valid ADMIN_EMAIL before creating the admin account.');

            return self::FAILURE;
        }

        if (User::query()->where('email', $email)->exists()) {
            $this->error('An account with the configured ADMIN_EMAIL already exists.');

            return self::FAILURE;
        }

        $name = trim((string) $this->ask('Admin name', 'Admin'));
        $password = $this->secret('Password (minimum 12 characters)', false);
        $passwordConfirmation = $this->secret('Confirm password', false);

        if ($name === '') {
            $this->error('Admin name cannot be empty.');

            return self::FAILURE;
        }

        if (! is_string($password) || mb_strlen($password) < 12) {
            $this->error('Password must contain at least 12 characters.');

            return self::FAILURE;
        }

        if ($password !== $passwordConfirmation) {
            $this->error('Passwords do not match.');

            return self::FAILURE;
        }

        User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $this->info("Admin account created for {$email}.");

        return self::SUCCESS;
    }
}
