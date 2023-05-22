<?php

namespace App\Exports;

use App\Models\Kecelakaan;
use Maatwebsite\Excel\Concerns\FromCollection;

class KecelakaanExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Kecelakaan::filter()->get();
    }
}
