<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ArrayExport implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    public function __construct(
        private readonly array $headings,
        private readonly array $rows,
        private readonly string $title = ''
    ) {
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $sheet = $event->sheet->getDelegate();
                $sheet->setRightToLeft(true);
                $highestCol = $sheet->getHighestColumn();

                if ($this->title !== '') {
                    $sheet->insertNewRowBefore(1, 1);
                    $sheet->setCellValue('A1', $this->title);
                    $sheet->mergeCells('A1:' . $highestCol . '1');
                    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                }

                $headingsRow = $this->title !== '' ? 2 : 1;
                $sheet->getStyle('A' . $headingsRow . ':' . $highestCol . $headingsRow)->getFont()->setBold(true);
            },
        ];
    }
}
