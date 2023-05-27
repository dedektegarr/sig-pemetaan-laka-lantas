<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';
    protected $guarded = ['id_lokasi'];
    protected $primaryKey = 'id_lokasi';

    public function scopeFilter($query)
    {
        if (request('id_kecamatan') ?? false) {
            $query->where('id_kecamatan', request('id_kecamatan'));
        }
        if (request('id_kelurahan') ?? false) {
            $query->where('id_kelurahan', request('id_kelurahan'));
        }
        if (request('tahun') ?? false) {
            $query->whereYear('tgl_kejadian', request('tahun'));
        }

        return $query;
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
    }

    public function kecelakaan()
    {
        return $this->hasOne(Kecelakaan::class, 'id_lokasi');
    }
}
