<?php

namespace Tests\Feature;

use App\Models\Tempat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TempatCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_a_place_photo_and_see_it_in_the_catalog_grid(): void
    {
        Storage::fake('public');
        $admin = $this->createAdminUser();

        $this->actingAs($admin)
            ->post(route('tempats.store'), [
                'nama_tempat' => 'Kafe Contoh',
                'kategori' => 'makan',
                'alamat' => 'Taman Kota Bandung',
                'foto' => UploadedFile::fake()->createWithContent(
                    'kafe.png',
                    base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/lWQAAAAASUVORK5CYII=')
                ),
            ])
            ->assertRedirect(route('tempats.index'));

        $tempat = Tempat::firstOrFail();
        Storage::disk('public')->assertExists($tempat->foto);
        $this->assertSame(
            'https://www.google.com/maps/search/?api=1&query=Taman%20Kota%20Bandung',
            $tempat->link_google_maps
        );

        $this->get(route('tempats.index'))
            ->assertOk()
            ->assertSee('Tempat Favoritku')
            ->assertSee('Koleksi pribadi · bebas lokasi')
            ->assertSee('Simpan semua tempat yang kamu suka')
            ->assertDontSee('Tempat Favorit Bandung')
            ->assertSee('Jelajahi koleksi')
            ->assertSee('grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 lg:gap-6', false)
            ->assertSee('alt="Foto Kafe Contoh"', false)
            ->assertSee('src="'.Storage::url($tempat->foto).'"', false)
            ->assertSee('Buka di Google Maps')
            ->assertSee(
                'href="https://www.google.com/maps/search/?api=1&amp;query=Taman%20Kota%20Bandung"',
                false
            );
    }

    public function test_asset_urls_use_https_when_request_is_forwarded_by_railway(): void
    {
        $response = $this->withHeaders([
            'X-Forwarded-Proto' => 'https',
            'X-Forwarded-Port' => '443',
        ])->get(route('tempats.index'));

        $response->assertOk()
            ->assertSee('href="https://localhost/build/assets/app-', false)
            ->assertDontSee('href="http://localhost/build/assets/app-', false);
    }

    public function test_address_is_required_when_adding_a_place(): void
    {
        $this->actingAs($this->createAdminUser())
            ->from(route('tempats.create'))
            ->post(route('tempats.store'), [
                'nama_tempat' => 'Tempat Contoh',
                'kategori' => 'makan',
            ])
            ->assertRedirect(route('tempats.create'))
            ->assertSessionHasErrors(['alamat']);

        $this->assertDatabaseMissing('tempats', ['nama_tempat' => 'Tempat Contoh']);
    }

    public function test_create_form_uses_one_required_address_field(): void
    {
        $this->actingAs($this->createAdminUser())
            ->get(route('tempats.create'))
            ->assertOk()
            ->assertSee('Alamat tempat')
            ->assertSee('id="alamat" type="text" name="alamat"', false)
            ->assertSee('required', false)
            ->assertDontSee('opsional')
            ->assertDontSee('link_google_maps');
    }

    public function test_updating_an_address_updates_its_google_maps_search_link(): void
    {
        $admin = $this->createAdminUser();
        $tempat = Tempat::create([
            'nama_tempat' => 'Kafe Contoh',
            'kategori' => 'makan',
            'alamat' => 'Alamat lama',
            'link_google_maps' => 'https://maps.app.goo.gl/abc123',
        ]);

        $this->actingAs($admin)
            ->put(route('tempats.update', $tempat), [
                'nama_tempat' => 'Kafe Contoh',
                'kategori' => 'makan',
                'alamat' => 'Jalan Merdeka Jakarta',
            ])
            ->assertRedirect(route('tempats.index'));

        $this->assertSame(
            'https://www.google.com/maps/search/?api=1&query=Jalan%20Merdeka%20Jakarta',
            $tempat->fresh()->link_google_maps
        );
    }

    public function test_deleting_a_place_also_removes_its_photo(): void
    {
        Storage::fake('public');
        $admin = $this->createAdminUser();
        $foto = UploadedFile::fake()->create('kafe.jpg', 10, 'image/jpeg')->store('tempats', 'public');
        $tempat = Tempat::create([
            'nama_tempat' => 'Kafe Contoh',
            'kategori' => 'makan',
            'alamat' => 'Bandung',
            'foto' => $foto,
        ]);

        $this->actingAs($admin)
            ->delete(route('tempats.destroy', $tempat))
            ->assertRedirect(route('tempats.index'));

        Storage::disk('public')->assertMissing($foto);
    }

    private function createAdminUser(): User
    {
        config(['app.admin_email' => 'admin@example.com']);

        return User::factory()->create(['email' => 'admin@example.com']);
    }
}
