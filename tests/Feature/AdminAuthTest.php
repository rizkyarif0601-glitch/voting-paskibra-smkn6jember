<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Pastikan tamu yang belum login ditolak saat mengakses dashboard admin.
     */
    public function test_unauthenticated_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect(route('admin.login'));
    }

    /**
     * Pastikan halaman login admin dapat dimuat dengan baik.
     */
    public function test_admin_login_page_can_be_rendered(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
        $response->assertSee('Admin E-Voting');
    }

    /**
     * Pastikan admin berhasil login menggunakan kredensial yang valid.
     */
    public function test_admin_can_login_with_valid_credentials(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'rizkyarif0106@gmail.com'],
            [
                'name' => 'Rizqi Arif Ardiansyah',
                'password' => Hash::make('1juni2008'),
            ]
        );

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'rizkyarif0106@gmail.com',
            'password' => '1juni2008',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Pastikan login gagal jika password salah.
     */
    public function test_admin_cannot_login_with_invalid_password(): void
    {
        User::updateOrCreate(
            ['email' => 'rizkyarif0106@gmail.com'],
            [
                'name' => 'Rizqi Arif Ardiansyah',
                'password' => Hash::make('1juni2008'),
            ]
        );

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'rizkyarif0106@gmail.com',
            'password' => 'passwordsalah',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Pastikan admin dapat logout dan sesi dibersihkan.
     */
    public function test_admin_can_logout(): void
    {
        $user = User::where('email', 'rizkyarif0106@gmail.com')->first()
            ?? User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    /**
     * Pastikan admin yang login dapat mengakses halaman Live Quick Count.
     */
    public function test_admin_can_access_realtime_quick_count(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.realtime'));

        $response->assertStatus(200);
        $response->assertSee('HASIL PEROLEHAN SUARA');
    }

    /**
     * Pastikan endpoint realtime data JSON dapat diakses dan mengembalikan data yang benar.
     */
    public function test_admin_can_fetch_realtime_data_json(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.realtime.data'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'total_voters',
            'total_voted',
            'total_not_voted',
            'total_votes',
            'participation_rate',
            'candidates',
            'updated_at',
        ]);
    }
}
