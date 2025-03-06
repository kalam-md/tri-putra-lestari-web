<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BahanBajuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bahanBajus = [
            ['nama_bahan' => 'Katun', 'motif_bahan' => 'Polos', 'stok' => 100, 'gambar' => 'katun_polos.jpg'],
            ['nama_bahan' => 'Linen', 'motif_bahan' => 'Garis', 'stok' => 50, 'gambar' => 'linen_garis.jpg'],
            ['nama_bahan' => 'Satin', 'motif_bahan' => 'Floral', 'stok' => 75, 'gambar' => 'satin_floral.jpg'],
            ['nama_bahan' => 'Denim', 'motif_bahan' => 'Polos', 'stok' => 30, 'gambar' => 'denim_polos.jpg'],
            ['nama_bahan' => 'Wool', 'motif_bahan' => 'Rajut', 'stok' => 60, 'gambar' => 'wool_rajut.jpg'],
            ['nama_bahan' => 'Chiffon', 'motif_bahan' => 'Abstrak', 'stok' => 40, 'gambar' => 'chiffon_abstrak.jpg'],
            ['nama_bahan' => 'Rayon', 'motif_bahan' => 'Polkadot', 'stok' => 80, 'gambar' => 'rayon_polkadot.jpg'],
            ['nama_bahan' => 'Spandex', 'motif_bahan' => 'Polos', 'stok' => 90, 'gambar' => 'spandex_polos.jpg'],
            ['nama_bahan' => 'Jersey', 'motif_bahan' => 'Garis', 'stok' => 55, 'gambar' => 'jersey_garis.jpg'],
            ['nama_bahan' => 'Velvet', 'motif_bahan' => 'Embossed', 'stok' => 35, 'gambar' => 'velvet_embossed.jpg'],
            ['nama_bahan' => 'Crepe', 'motif_bahan' => 'Geometris', 'stok' => 70, 'gambar' => 'crepe_geometris.jpg'],
            ['nama_bahan' => 'Flanel', 'motif_bahan' => 'Kotak-kotak', 'stok' => 65, 'gambar' => 'flanel_kotak.jpg'],
        ];

        DB::table('bahan_bajus')->insert($bahanBajus);
    }
}
