<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataExport implements FromCollection, WithHeadings, WithTitle
{
    use Exportable;

    protected $data, $headings, $title;

    public function __construct($data, array $headings, string $title)
    {
        $this->data = $data;
        $this->headings = $headings;
        $this->title = $title;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        return $this->data;
    }

    public function headings(): array
    {
        return $this->headings;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }
}
