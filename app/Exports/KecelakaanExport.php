<?php

namespace App\Exports;

use App\Models\Kecamatan;
use App\Models\Kecelakaan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KecelakaanExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles, WithMapping, WithStrictNullComparison, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $all_data = Kecelakaan::filter()->orderBy('no_laka')->get();

        return $all_data->map(function ($data, $index) {
            $export['no'] = $index + 1;
            $export['no_laka'] = $data->no_laka;
            $export['tingkat_kecelakaan'] = $data->tingkat_kecelakaan;
            $export['luka_ringan'] = $data->luka_ringan;
            $export['luka_berat'] = $data->luka_berat;
            $export['meninggal'] = $data->meninggal;
            $export['tgl_kejadian'] = $data->tgl_kejadian;
            $export['nama_jalan'] = $data->lokasi->nama_jalan;
            $export['kecamatan'] = $data->lokasi->kecamatan->nama ?? '';
            return collect($export);
        });
    }

    public function headings(): array
    {
        $title = 'DATA KECELAKAAN TAHUN 2023';
        if (request('id_kecamatan')) {
            $kecamatan = Kecamatan::where('id_kecamatan', request('id_kecamatan'))->first();
            $title = 'DATA KECELAKAAN KEC.' . strtoupper($kecamatan->nama) . ' TAHUN 2023';
        }
        return [
            [$title, '', '', '', '', '', '', '', ''],
            [''],
            [
                'No',
                'No. Laka',
                'Tanggal Kejadian',
                'Jumlah Meninggal Dunia',
                'Jumlah Luka Berat',
                'Jumlah Luka Ringan',
                'Tingkat Kecelakaan',
                'Nama Jalan',
                'Kecamatan'
            ]
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

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 20,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 25
        ];
    }

    public function map($row): array
    {
        return [
            $row['no'],
            strtoupper($row['no_laka']),
            $row['tgl_kejadian'],
            $row['meninggal'],
            $row['luka_berat'],
            $row['luka_ringan'],
            ucwords($row['tingkat_kecelakaan']),
            $row['nama_jalan'],
            $row['kecamatan'],
        ];
    }
}
