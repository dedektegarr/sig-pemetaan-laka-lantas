<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function getData()
    {
        return response()->json([
            'kecamatan' => Kecamatan::all()
        ]);
    }
}
