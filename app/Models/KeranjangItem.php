<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeranjangItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function modelBaju()
    {
        return $this->belongsTo(ModelBaju::class);
    }
    
    public function ukuran()
    {
        return $this->belongsTo(Ukuran::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
