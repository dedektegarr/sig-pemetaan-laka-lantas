<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kecelakaan extends Model
{
    use HasFactory;

    protected $table = 'kecelakaan';
    protected $guarded = ['id_kecelakaan'];

    public function scopeFilter($query)
    {
        if (request('id_kecamatan') ?? false) {
            $query->join('lokasi', 'kecelakaan.id_lokasi', '=', 'lokasi.id_lokasi')
                ->join('kecamatan', 'lokasi.id_kecamatan', '=', 'kecamatan.id')
                ->select('kecelakaan.*', 'lokasi.id_lokasi', 'kecamatan.nama')
                ->where('kecamatan.id', request('id_kecamatan'));
        }

        if (request('bulan') && request('bulan_akhir')) {
            $query->whereBetween(DB::raw('MONTH(tgl_lp)'), [request('bulan'), request('bulan_akhir')]);
        } elseif (request('bulan')) {
            $query->whereMonth('tgl_lp', '=', request('bulan'));
        }

        if (request('tahun')) {
            $query->whereYear('tgl_lp', request('tahun'));
        }

        return $query;
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }
}