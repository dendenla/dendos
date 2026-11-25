<?php

namespace Tests\Feature;

use App\Models\Tempat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_view_the_catalog_but_cannot_open_admin_pages(): void
    {
        $this->get(route('tempats.index'))
            ->assertOk()
            ->assertDontSee(route('login'), false)
            ->assertDontSee('Masuk');

        $this->get(route('tempats.create'))
            ->assertRedirect(route('login'));
    }

    public function test_configured_admin_can_log_in_and_manage_places(): void
    {
        config(['app.admin_email' => 'admin@example.com']);
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'secret-password',
        ]);

        $this->post(route('login'), [
            'email' => 'admin@example.com',
            'password' => 'secret-password',
        ])->assertRedirect(route('tempats.index'));

        $this->assertAuthenticatedAs($admin);
        $this->get(route('tempats.create'))->assertOk();
    }

    public function test_other_users_cannot_log_in_as_admin(): void
    {
        config(['app.admin_email' => 'admin@example.com']);
        User::factory()->create([
            'email' => 'visitor@example.com',
            'password' => 'secret-password',
        ]);

        $this->from(route('login'))
            ->post(route('login'), [
                'email' => 'visitor@example.com',
                'password' => 'secret-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors(['email']);

        $this->assertGuest();
    }

    public function test_login_is_denied_until_an_admin_email_is_configured(): void
    {
        config(['app.admin_email' => null]);
        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'secret-password',
        ]);

        $this->from(route('login'))
            ->post(route('login'), [
                'email' => 'admin@example.com',
                'password' => 'secret-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors(['email']);

        $this->assertGuest();
    }

    public function test_existing_non_admin_sessions_cannot_manage_places(): void
    {
        config(['app.admin_email' => 'admin@example.com']);
        $visitor = User::factory()->create(['email' => 'visitor@example.com']);
        Tempat::create([
            'nama_tempat' => 'Tempat Contoh',
            'kategori' => 'makan',
            'alamat' => 'Garut',
        ]);

        $this->actingAs($visitor)
            ->get(route('tempats.index'))
            ->assertOk()
            ->assertDontSee('Tambah tempat')
            ->assertDontSee('Edit')
            ->assertDontSee('Hapus');

        $this->get(route('tempats.create'))->assertForbidden();
    }
}
