<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelBaju extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ukurans()
    {
        return $this->belongsToMany(Ukuran::class, 'model_baju_ukuran')
                    ->withPivot('stok')
                    ->withTimestamps();
    }

    // Relasi ke tabel BahanBaju
    public function bahanBaju()
    {
        return $this->belongsTo(BahanBaju::class, 'bahan_id');
    }

    public function getGambarUrlAttribute()
    {
        // Jika gambar ada, gunakan gambar yang diupload
        // Jika tidak, gunakan gambar default
        return $this->gambar 
            ? asset('storage/model_baju/' . $this->gambar) 
            : asset('images/default-image.webp');
    }
}
