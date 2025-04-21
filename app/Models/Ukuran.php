<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ukuran extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function modelBajus()
{
    return $this->belongsToMany(ModelBaju::class, 'model_baju_ukuran')
                ->withPivot('stok')
                ->withTimestamps();
}
}
