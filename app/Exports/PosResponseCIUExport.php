<?php

namespace App\Exports;

use App\Models\PosResponseCIU;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PosResponseCIUExport implements FromQuery, WithHeadings
{
    protected $search;
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return PosResponseCIU::query()
            ->when($this->startDate && $this->endDate, function($query) {
                return $query->whereBetween('InsuranceDate', [$this->startDate, $this->endDate]);
            })
            ->orderBy('InsuranceDate'); // Order by InsuranceDate
    }

    public function headings(): array
    {
        return [
            'AwbNo',
            'No Polis',
            'Status',
            'Tanggal',
            'Remark',
        ];
    }
}
