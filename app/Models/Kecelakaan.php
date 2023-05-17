<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecelakaan extends Model
{
    use HasFactory;

    protected $table = 'kecelakaan';
    protected $guarded = ['id_kecelakaan'];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }
}