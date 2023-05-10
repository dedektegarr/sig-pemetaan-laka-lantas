<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class KelurahanController extends Controller
{
    public function getDataByKecamatan(Request $request)
    {
        $id_kecamatan = $request->query('id_kecamatan');

        return response()->json([
            'kelurahan' => Kelurahan::where('id_kecamatan', $id_kecamatan)->get()
        ]);
    }
}
