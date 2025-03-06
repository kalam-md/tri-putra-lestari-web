<?php

namespace Database\Seeders;

use App\Models\Ukuran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UkuranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ukuran::truncate();

        // Predefined sizes with typical measurements
        $sizes = [
            ['ukuran_baju' => 'S', 'panjang_badan' => 55, 'panjang_tangan' => 25, 'lebar_dada' => 35],
            ['ukuran_baju' => 'M', 'panjang_badan' => 60, 'panjang_tangan' => 28, 'lebar_dada' => 40],
            ['ukuran_baju' => 'L', 'panjang_badan' => 65, 'panjang_tangan' => 30, 'lebar_dada' => 45],
            ['ukuran_baju' => 'XL', 'panjang_badan' => 70, 'panjang_tangan' => 33, 'lebar_dada' => 50],
            ['ukuran_baju' => 'XXL', 'panjang_badan' => 75, 'panjang_tangan' => 36, 'lebar_dada' => 55],
            ['ukuran_baju' => 'XXXL', 'panjang_badan' => 80, 'panjang_tangan' => 39, 'lebar_dada' => 60],
            ['ukuran_baju' => 'M Slim', 'panjang_badan' => 60, 'panjang_tangan' => 28, 'lebar_dada' => 35],
            ['ukuran_baju' => 'L Slim', 'panjang_badan' => 65, 'panjang_tangan' => 30, 'lebar_dada' => 40],
            ['ukuran_baju' => 'XL Slim', 'panjang_badan' => 70, 'panjang_tangan' => 33, 'lebar_dada' => 45],
            ['ukuran_baju' => 'Kids S', 'panjang_badan' => 40, 'panjang_tangan' => 20, 'lebar_dada' => 30],
            ['ukuran_baju' => 'Kids M', 'panjang_badan' => 45, 'panjang_tangan' => 22, 'lebar_dada' => 32],
            ['ukuran_baju' => 'Kids L', 'panjang_badan' => 50, 'panjang_tangan' => 24, 'lebar_dada' => 34],
        ];

        // Insert the data
        foreach ($sizes as $size) {
            Ukuran::create($size);
        }
    }
}
