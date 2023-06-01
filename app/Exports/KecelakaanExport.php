<?php

namespace App\Exports;

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
        $all_data = Kecelakaan::latest()->filter()->get();
        return $all_data->map(function ($data, $index) {
            $export['no'] = $index + 1;
            $export['no_laka'] = $data->no_laka;
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
        return [
            'No',
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

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 20,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 15,
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
            $row['nama_jalan'],
            $row['kecamatan'],
        ];
    }
}
