<?php

namespace Tests\Feature\Console\Commands;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_creates_the_configured_admin_with_a_usable_password(): void
    {
        config(['app.admin_email' => 'denden@gmail.com']);
        $password = 'correct-horse-battery-42';

        $this->artisan('admin:create')
            ->expectsQuestion('Admin name', 'Denden')
            ->expectsQuestion('Password (minimum 12 characters)', $password)
            ->expectsQuestion('Confirm password', $password)
            ->expectsOutputToContain('Admin account created for denden@gmail.com.')
            ->assertExitCode(0);

        $admin = User::query()->where('email', 'denden@gmail.com')->firstOrFail();

        $this->post(route('login'), [
            'email' => 'denden@gmail.com',
            'password' => $password,
        ])->assertRedirect(route('tempats.index'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_command_requires_a_valid_configured_admin_email(): void
    {
        config(['app.admin_email' => null]);

        $this->artisan('admin:create')
            ->expectsOutputToContain('Set a valid ADMIN_EMAIL')
            ->assertExitCode(1);

        $this->assertDatabaseCount('users', 0);
    }

    public function test_command_rejects_mismatched_passwords_without_creating_an_account(): void
    {
        config(['app.admin_email' => 'denden@gmail.com']);

        $this->artisan('admin:create')
            ->expectsQuestion('Admin name', 'Denden')
            ->expectsQuestion('Password (minimum 12 characters)', 'correct-horse-battery-42')
            ->expectsQuestion('Confirm password', 'different-horse-battery-42')
            ->expectsOutputToContain('Passwords do not match.')
            ->assertExitCode(1);

        $this->assertDatabaseMissing('users', ['email' => 'denden@gmail.com']);
    }

    public function test_command_does_not_overwrite_an_existing_admin_account(): void
    {
        config(['app.admin_email' => 'denden@gmail.com']);
        $admin = User::factory()->create(['email' => 'denden@gmail.com']);

        $this->artisan('admin:create')
            ->expectsOutputToContain('An account with the configured ADMIN_EMAIL already exists.')
            ->assertExitCode(1);

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'email' => 'denden@gmail.com',
        ]);
    }
}
