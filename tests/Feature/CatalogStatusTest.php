<?php

namespace Tests\Feature;

use App\Http\Controllers\BarangController;
use App\Http\Controllers\RuangController;
use App\Models\Barang;
use App\Models\Role;
use App\Models\Ruang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_barang_catalog_menampilkan_item_yang_statusnya_tersedia_meski_disimpan_dengan_huruf_kapital(): void
    {
        Barang::create([
            'nama_barang' => 'Proyektor Test',
            'jumlah' => 2,
            'status' => 'Tersedia',
            'uppk' => 'UPPK Test',
        ]);

        $controller = new BarangController();
        $view = $controller->katalogMahasiswa(new Request(['status' => 'tersedia']));

        $this->assertTrue($view->getData()['barang']->contains('id', 1));
    }

    public function test_ruang_catalog_menampilkan_item_yang_statusnya_tersedia_meski_disimpan_dengan_huruf_kapital(): void
    {
        Role::create(['nama_role' => 'mahasiswa']);
        $this->actingAs(User::factory()->create(['role_id' => 1]));

        Ruang::create([
            'nama_ruangan' => 'Ruang Test',
            'kapasitas' => 40,
            'lokasi' => 'Gedung A',
            'status' => 'Tersedia',
            'uppk' => 'UPPK Test',
        ]);

        $controller = new RuangController();
        $view = $controller->index(new Request(['status' => 'tersedia']));

        $this->assertTrue($view->getData()['ruang']->contains('id', 1));
    }
}
