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
            $query->whereBetween(DB::raw('MONTH(tgl_kejadian)'), [request('bulan'), request('bulan_akhir')]);
        } elseif (request('bulan')) {
            $query->whereMonth('tgl_kejadian', '=', request('bulan'));
        }

        if (request('tahun')) {
            $query->whereYear('tgl_kejadian', request('tahun'));
        }

        // Tampilkan peta berdasarkan lokasi
        if (request('nama_jalan') ?? false) {
            $query->join('lokasi', 'kecelakaan.id_lokasi', '=', 'lokasi.id_lokasi')
                ->select('kecelakaan.*', 'lokasi.nama_jalan')
                ->where('lokasi.nama_jalan', request('nama_jalan'));
        }

        if (request('tahun_kejadian') ?? false) {
            $query->whereYear('tgl_kejadian', request('tahun_kejadian'));
        }

        return $query;
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }
}