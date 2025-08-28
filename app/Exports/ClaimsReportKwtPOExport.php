<?php

namespace App\Exports;

use App\Models\Trxs;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClaimsReportKwtPOExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths, WithMapping, WithEvents
{
    protected $startDate, $endDate, $groupId, $statusTrx, $subconCode, $picId;

    protected array $activeMonths = [];

    public function __construct($startDate, $endDate, $groupId, $statusTrx, $subconCode, $picId)
    {
        $this->startDate  = $startDate;
        $this->endDate    = $endDate;
        $this->groupId    = $groupId;
        $this->statusTrx  = $statusTrx;
        $this->subconCode = $subconCode;
        $this->picId      = $picId;

        $query = Trxs::query()
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->whereNotNull('kwitansi_value_final');

        if ($this->groupId)    $query->where('group_id', $this->groupId);
        if ($this->statusTrx)  $query->where('status', $this->statusTrx);
        if ($this->subconCode) $query->where('subcon_code', $this->subconCode);
        if ($this->picId)      $query->where('created_by', $this->picId);

        $this->activeMonths = $query->selectRaw('MONTH(created_at) AS m')
            ->distinct()
            ->pluck('m')
            ->sort()
            ->values()
            ->all();
    }

    public function array(): array
    {
        $query = Trxs::query()
            ->whereBetween('created_at', [$this->startDate, $this->endDate]);

        if ($this->groupId)    $query->where('group_id', $this->groupId);
        if ($this->statusTrx)  $query->where('status', $this->statusTrx);
        if ($this->subconCode) $query->where('subcon_code', $this->subconCode);
        if ($this->picId)      $query->where('created_by', $this->picId);

        $data        = $query->get();
        $summary     = [];
        $monthTotals = [];

        foreach ($data as $item) {
            if (is_null($item->kwitansi_value_final)) continue;

            $subcon = $item->subcon_name;
            $bulan  = Carbon::parse($item->created_at)->month;
            $value  = floatval($item->kwitansi_value_final);

            if (!isset($summary[$subcon])) {
                $summary[$subcon] = array_fill(1, 12, 0);
            }

            $summary[$subcon][$bulan] += $value;
            $monthTotals[$bulan]       = ($monthTotals[$bulan] ?? 0) + $value;
        }

        $rows = [];
        foreach ($summary as $subcon => $monthly) {
            $row   = [$subcon];
            $total = 0;

            foreach ($this->activeMonths as $m) {
                $val   = $monthly[$m] ?? 0;
                $row[] = $val ?: '';
                $total += $val;
            }
            $row[] = $total;
            $rows[] = $row;
        }

        $grandRow   = ['GRAND TOTAL :'];
        $grandTotal = 0;
        foreach ($this->activeMonths as $m) {
            $val       = $monthTotals[$m] ?? 0;
            $grandRow[] = $val ?: '';
            $grandTotal += $val;
        }
        $grandRow[] = $grandTotal;
        $rows[]     = $grandRow;

        return $rows;
    }

    public function headings(): array
    {
        $monthNames = [
            1 => 'JANUARI',
            2 => 'FEBRUARI',
            3 => 'MARET',
            4 => 'APRIL',
            5 => 'MEI',
            6 => 'JUNI',
            7 => 'JULI',
            8 => 'AGUSTUS',
            9 => 'SEPTEMBER',
            10 => 'OKTOBER',
            11 => 'NOVEMBER',
            12 => 'DESEMBER',
        ];

        $headings = ['SUBCON'];
        foreach ($this->activeMonths as $m) {
            $headings[] = $monthNames[$m];
        }
        $headings[] = 'TOTAL';

        return $headings;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 45,
        ];
    }

    public function map($row): array
    {
        return array_map(function ($value, $index) {
            return $index === 0 || $value === '' ? $value : 'Rp ' . number_format($value, 0, ',', '.');
        }, $row, array_keys($row));
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $headerRange = 'A1:' . $event->sheet->getHighestColumn() . '1';

                $event->sheet->getDelegate()->getStyle($headerRange)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '000000'],
                    ],
                ]);
            },
        ];
    }
}
