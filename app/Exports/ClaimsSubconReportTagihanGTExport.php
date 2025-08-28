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


class ClaimsSubconReportTagihanGTExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths, WithMapping, WithEvents
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
        $query = Trxs::with(['group:id,name'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate]);

        if ($this->groupId)    $query->where('group_id', $this->groupId);
        if ($this->statusTrx)  $query->where('status', $this->statusTrx);
        if ($this->subconCode) $query->where('subcon_code', $this->subconCode);
        if ($this->picId)      $query->where('created_by', $this->picId);

        $data = $query->get();

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

        $groupList = $data->pluck('group.name')->map(fn($g) => $g ?: 'No Group')->unique()->sort()->values()->all();

        $pivot = [];
        foreach ($this->activeMonths as $m) {
            $pivot[$m] = array_fill_keys($groupList, 0);
        }

        foreach ($data as $item) {
            if (is_null($item->kwitansi_value_final)) continue;

            $bulan = Carbon::parse($item->created_at)->month;
            if (!in_array($bulan, $this->activeMonths)) continue;

            $groupName = $item->group->name ?? 'No Group';
            $pivot[$bulan][$groupName] += floatval($item->kwitansi_value_final);
        }

        $rows = [];
        foreach ($this->activeMonths as $m) {
            $row = [$monthNames[$m]];
            $total = 0;

            foreach ($groupList as $groupName) {
                $val = $pivot[$m][$groupName] ?? 0;
                $row[] = $val ?: '';
                $total += $val;
            }

            $row[] = $total;
            $rows[] = $row;
        }

        $grandRow = ['GRAND TOTAL'];
        $totalPerGroup = [];

        foreach ($groupList as $groupName) {
            $sum = 0;
            foreach ($this->activeMonths as $m) {
                $sum += $pivot[$m][$groupName] ?? 0;
            }
            $grandRow[] = $sum ?: '';
            $totalPerGroup[] = $sum;
        }

        $grandRow[] = array_sum($totalPerGroup);
        $rows[] = $grandRow;

        return $rows;
    }


    public function headings(): array
    {
        $query = Trxs::with(['group:id,name'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate]);

        if ($this->groupId)    $query->where('group_id', $this->groupId);
        if ($this->statusTrx)  $query->where('status', $this->statusTrx);
        if ($this->subconCode) $query->where('subcon_code', $this->subconCode);
        if ($this->picId)      $query->where('created_by', $this->picId);

        $data = $query->get();

        $groups = $data->map(function ($item) {
            return $item->group->name ?? 'No Group';
        })->unique()->sort()->values()->all();

        return array_merge(['BULAN'], $groups, ['TOTAL']);
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
