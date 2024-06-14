<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class TodosExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    use Exportable;

    protected $todos;
    protected $index = 1;

    public function __construct($todos)
    {
        $this->todos = $todos;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->todos;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'User',
            'Task',
            'Status',
            'Assigned',
            'Updated',
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            $this->index++,
            $row->user->name,
            $row->name,
            $row->status,
            Carbon::parse($row->created_at)->format('d/m/Y'),
            Carbon::parse($row->updated_at)->format('d/m/Y'),
        ];
    }

    /**
     * @param \Maatwebsite\Excel\Sheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Ambil jumlah total baris data
        $rows = count($this->todos) + 1; // tambahkan 1 untuk header

        $styles = [];

        // Set gaya untuk header
        $styles[1] = [
            'font' => [
                'bold' => true,
                'size'      =>  15,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        // Set gaya untuk data
        for ($i = 2; $i <= $rows; $i++) {
            $styles[$i] = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ];
        }

        return $styles;
    }
}
