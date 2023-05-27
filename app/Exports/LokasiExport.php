<?php

namespace App\Exports;

use App\Models\Lokasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LokasiExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $all_data = Lokasi::latest()->filter()->get();

        return $all_data->map(function ($data) {
            $export['nama_jalan'] = $data->nama_jalan;
            $export['kelurahan'] = $data->kelurahan->nama;
            $export['kecamatan'] = $data->kecamatan->nama;
            $export['kota_kabupaten'] = $data->kota_kabupaten;
            $export['longitude'] = $data->longitude;
            $export['latitude'] = $data->latitude;
            return collect($export);
        });
    }

    public function headings(): array
    {
        return [
            'Nama Jalan',
            'Kelurahan',
            'Kecamatan',
            'Kota/Kabupaten',
            'Bujur',
            'Lintang'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // HEADING CELL
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . 1)
            ->getFont()
            ->setSize(15)
            ->setBold(true);
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . 1)
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB(Color::COLOR_YELLOW);

        // ALL CELL
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color(Color::COLOR_BLACK));
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
            ->getAlignment()
            ->setWrapText(true);
    }
}