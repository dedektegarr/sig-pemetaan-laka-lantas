<?php

namespace App\Exports;

use App\Models\Kecamatan;
use App\Models\Lokasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LokasiExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $all_data = Lokasi::filter()->get();

        $filteredData = $all_data->unique('nama_jalan')->map(function ($data) use (&$i) {
            $export['no'] = $i + 1;
            $export['nama_jalan'] = $data->nama_jalan;
            $export['kelurahan'] = $data->kelurahan->nama ?? '';
            $export['kecamatan'] = $data->kecamatan->nama ?? '';
            $export['polresta'] = $data->polresta;
            $export['longitude'] = $data->longitude;
            $export['latitude'] = $data->latitude;

            $i++;
            return collect($export);
        });

        return $filteredData;
    }

    public function headings(): array
    {
        $title = 'DATA JALAN KOTA BENGKULU';
        if (request('id_kecamatan')) {
            $kecamatan = Kecamatan::where('id', request('id_kecamatan'))->first();
            $title = 'DATA JALAN KEC.' . strtoupper($kecamatan->nama);
        }

        return [
            [$title, '', '', '', '', '', ''],
            [''],
            [
                'No',
                'Nama Jalan',
                'Kelurahan',
                'Kecamatan',
                'Polresta',
                'Bujur',
                'Lintang'
            ]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 25
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // TITLE
        $sheet->mergeCells('A1:' . $sheet->getHighestColumn() . 1);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB(Color::COLOR_YELLOW);
        // HEADING CELL
        $sheet->getStyle('A3:' . $sheet->getHighestColumn() . 3)
            ->getFont()
            ->setSize(15)
            ->setBold(true);
        $sheet->getStyle('A3:' . $sheet->getHighestColumn() . 3)
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
