<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kecelakaan extends Model
{
    use HasFactory;

    protected $table = 'kecelakaan';
    protected $primaryKey = 'id_kecelakaan';
    // public $incrementing = false;
    protected $guarded = ['id_kecelakaan'];

    public function scopeFilter($query)
    {
        if (request('nama_jalan') && request('tahun_kejadian')) {
            $jalan = strtolower(request('nama_jalan'));

            $query->join('lokasi', 'kecelakaan.id_lokasi', '=', 'lokasi.id_lokasi')
                // ->join('kecamatan', 'lokasi.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                ->select('kecelakaan.*', DB::raw('LOWER(lokasi.nama_jalan)'))
                ->where('lokasi.nama_jalan', 'LIKE', '%' . $jalan . '%')
                ->where('no_laka', 'LIKE', '%' . request('tahun_kejadian') . '%');
        } elseif (request('nama_jalan')) {
            $jalan = strtolower(request('nama_jalan'));
            $query->join('lokasi', 'kecelakaan.id_lokasi', '=', 'lokasi.id_lokasi')
                // ->join('kecamatan', 'lokasi.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                ->select('kecelakaan.*', DB::raw('LOWER(lokasi.nama_jalan)'))
                ->where('lokasi.nama_jalan', 'LIKE', '%' . request('nama_jalan') . '%');
        } elseif (request('tahun_kejadian')) {
            $query->join('lokasi', 'kecelakaan.id_lokasi', '=', 'lokasi.id_lokasi')
                ->join('kecamatan', 'lokasi.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                ->select('kecelakaan.*', 'lokasi.nama_jalan')
                ->where('no_laka', 'LIKE', '%' . request('tahun_kejadian') . '%');
        }

        if (request('id_kecamatan') ?? false) {
            $query->join('lokasi', 'kecelakaan.id_lokasi', '=', 'lokasi.id_lokasi')
                ->join('kecamatan', 'lokasi.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                ->select('kecelakaan.*', 'lokasi.id_lokasi')
                ->where('kecamatan.id_kecamatan', request('id_kecamatan'));
        }

        if (request('bulan') && request('bulan_akhir')) {
            $query->whereBetween(DB::raw('MONTH(tgl_kejadian)'), [request('bulan'), request('bulan_akhir')]);
        } elseif (request('bulan')) {
            $query->whereMonth('tgl_kejadian', '=', request('bulan'));
        }

        if (request('tahun')) {
            $query->where('no_laka', 'LIKE', '%' . request('tahun') . '%');
        }

        // if (request('tahun_kejadian') ?? false) {
        //     $query->join('lokasi', 'lokasi.id_lokasi', '=', 'kecelakaan.id_lokasi')
        //         ->join('kecamatan', 'kecamatan.id_kecamatan', '=', 'lokasi.id_kecamatan')
        //         ->select('kecelakaan.*', 'lokasi.id_kecamatan', 'kecamatan.nama')
        //         ->whereYear('tgl_kejadian', request('tahun_kejadian'));
        // }

        return $query;
    }

    public function scopeLaporan($query)
    {
        if (request('id_kecamatan') ?? false) {
            $query->join('lokasi', 'kecelakaan.id_lokasi', '=', 'lokasi.id_lokasi')
                ->join('kecamatan', 'lokasi.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                ->select('kecelakaan.*', 'lokasi.id_lokasi', 'kecamatan.nama')
                ->where('kecamatan.id_kecamatan', request('id_kecamatan'));
        }

        if (request('tahun')) {
            $query->where('no_laka', 'LIKE', '%' . request('tahun') . '%');
        }
        // $query->join('lokasi', 'lokasi.id_lokasi', '=', 'kecelakaan.id_lokasi')
        //     ->join('kecamatan', 'kecamatan.id_kecamatan', '=', 'lokasi.id_kecamatan')
        //     ->select('kecelakaan.*', 'lokasi.id_kecamatan', 'kecamatan.nama');

        return $query;
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }
}
