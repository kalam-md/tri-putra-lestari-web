<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaju extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getGambarUrlAttribute()
    {
        // Jika gambar ada, gunakan gambar yang diupload
        // Jika tidak, gunakan gambar default
        return $this->gambar 
            ? asset('storage/bahan_baju/' . $this->gambar) 
            : asset('images/default-image.webp');
    }
}
