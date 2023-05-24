<?php

namespace App\Exports;

use App\Models\Kecelakaan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment as StyleAlignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KecelakaanExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $all_data = Kecelakaan::latest()->filter()->get();
        $filtered_data = $all_data->map(function ($data) {
            $export['no_laka'] = $data->no_laka;
            $export['luka_ringan'] = $data->luka_ringan;
            $export['luka_berat'] = $data->luka_berat;
            $export['meninggal'] = $data->meninggal;
            $export['tgl_kejadian'] = Carbon::parse($data->tgl_kejadian)->locale('id')->translatedFormat('d M Y, h:i');
            $export['nama_jalan'] = $data->lokasi->nama_jalan;
            $export['kecamatan'] = $data->lokasi->kecamatan->nama;
            return collect($export);
        });

        return $filtered_data;
    }

    public function headings(): array
    {
        return [
            'No. Laka',
            'Tanggal Kejadian',
            'Jumlah Meninggal Dunia',
            'Jumlah Luka Berat',
            'Jumlah Luka Ringan',
            'Nama Jalan',
            'Kecamatan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . 1)
            ->getFont()
            ->setSize(15)
            ->setBold(true);

        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
    }

    public function map($row): array
    {
        return [
            strtoupper($row['no_laka']),
            $row['luka_ringan'],
            $row['luka_berat'],
            $row['meninggal'],
            $row['tgl_kejadian'],
            $row['nama_jalan'],
            $row['kecamatan'],
        ];
    }
}
