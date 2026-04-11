<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Denda;
use App\Models\Peminjaman;
use App\Models\User;
use App\Services\PeminjamanService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PeminjamanFlowTest extends TestCase
{
    use RefreshDatabase;

    private PeminjamanService $service;

    private User $admin;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(PeminjamanService::class);

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->user = User::factory()->create(['role' => 'user']);
    }

    /** Alur normal: pending → disetujui → dikembalikan (tepat waktu, tanpa denda) */
    public function test_alur_pinjam_disetujui_dikembalikan_tanpa_denda(): void
    {
        $buku = Buku::factory()->create(['stok' => 3]);

        // 1. Buat peminjaman pending
        $peminjaman = $this->service->buat([
            'user_id' => $this->user->id,
            'buku_id' => $buku->id,
            'tanggal_request' => now()->toDateString(),
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali' => null,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('peminjaman', ['id' => $peminjaman->id, 'status' => 'pending']);
        $buku->refresh();
        $this->assertEquals(3, $buku->stok); // stok belum berkurang

        // 2. Admin setujui → stok berkurang
        $this->service->ubah($peminjaman, array_merge($peminjaman->toArray(), ['status' => 'disetujui']));
        $buku->refresh();
        $this->assertEquals(2, $buku->stok);

        // 3. Kembalikan tepat waktu (dalam 7 hari) → stok kembali, tidak ada denda
        $peminjaman->refresh();
        $this->service->ubah($peminjaman, array_merge($peminjaman->toArray(), [
            'status' => 'dikembalikan',
            'tanggal_kembali' => now()->toDateString(),
        ]));

        $buku->refresh();
        $this->assertEquals(3, $buku->stok);
        $this->assertDatabaseMissing('denda', ['peminjaman_id' => $peminjaman->id]);
    }

    /** Alur terlambat: dikembalikan lewat 7 hari → denda otomatis dibuat */
    public function test_alur_dikembalikan_terlambat_membuat_denda(): void
    {
        $buku = Buku::factory()->create(['stok' => 1]);

        $tanggalPinjam = now()->subDays(12)->toDateString(); // pinjam 12 hari lalu
        $tanggalKembali = now()->toDateString();              // batas 7 hari → terlambat 5 hari

        $peminjaman = $this->service->buat([
            'user_id' => $this->user->id,
            'buku_id' => $buku->id,
            'tanggal_request' => $tanggalPinjam,
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => null,
            'status' => 'disetujui',
        ]);

        $this->service->ubah($peminjaman, array_merge($peminjaman->toArray(), [
            'status' => 'dikembalikan',
            'tanggal_kembali' => $tanggalKembali,
        ]));

        $denda = Denda::where('peminjaman_id', $peminjaman->id)->first();
        $this->assertNotNull($denda);
        $this->assertEquals(5, $denda->terlambat_hari);
        $this->assertEquals(5000, $denda->total_denda); // Rp 1.000 × 5 hari
        $this->assertEquals('belum bayar', $denda->status);
    }

    /** Stok habis → tidak bisa disetujui */
    public function test_stok_habis_tidak_bisa_disetujui(): void
    {
        $buku = Buku::factory()->habis()->create(); // stok = 0

        $peminjaman = Peminjaman::factory()->create([
            'buku_id' => $buku->id,
            'status' => 'pending',
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches('/habis/i');

        $this->service->ubah($peminjaman, array_merge($peminjaman->toArray(), ['status' => 'disetujui']));
    }

    /** API: user biasa hanya bisa lihat denda milik sendiri */
    public function test_api_user_hanya_lihat_denda_sendiri(): void
    {
        $bukuA = Buku::factory()->create(['stok' => 5]);
        $bukuB = Buku::factory()->create(['stok' => 5]);

        $peminjamanUser = Peminjaman::factory()->terlambat(3)->create(['user_id' => $this->user->id, 'buku_id' => $bukuA->id]);
        $peminjamanOther = Peminjaman::factory()->terlambat(2)->create(['user_id' => $this->admin->id, 'buku_id' => $bukuB->id]);

        Denda::create(['peminjaman_id' => $peminjamanUser->id,  'terlambat_hari' => 3, 'total_denda' => 3000, 'status' => 'belum bayar']);
        Denda::create(['peminjaman_id' => $peminjamanOther->id, 'terlambat_hari' => 2, 'total_denda' => 2000, 'status' => 'belum bayar']);

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/denda');

        $response->assertOk();
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals($peminjamanUser->id, $data[0]['peminjaman_id']);
    }
}
