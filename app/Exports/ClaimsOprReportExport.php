<?php

namespace App\Exports;

use App\Models\Trxs;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClaimsOprReportExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths, WithMapping
{
    protected $startDate, $endDate, $groupId, $statusTrx, $subconCode, $picId;

    public function __construct($startDate, $endDate, $groupId, $statusTrx, $subconCode, $picId)
    {
        $this->startDate  = $startDate;
        $this->endDate    = $endDate;
        $this->groupId    = $groupId;
        $this->statusTrx  = $statusTrx;
        $this->subconCode = $subconCode;
        $this->picId      = $picId;
    }

    public function array(): array
    {
        $trx = Trxs::select(
                'id',
                'subcon_name',
                'group_id',
                'receipt_date',
                'kwitansi_no',
                'kwitansi_value_final',
                'created_by'
            )
            ->with([
                'group:id,name',
                'user:id,name',
                'items' => function ($q) {
                    $q->latest()->with('statusTrx:id,name');
                }
            ])
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->when($this->groupId, fn($q) => $q->where('group_id', $this->groupId))
            ->when($this->statusTrx, fn($q) => $q->where('status', $this->statusTrx))
            ->when($this->subconCode, fn($q) => $q->where('subcon_code', $this->subconCode))
            ->when($this->picId, fn($q) => $q->where('created_by', $this->picId))
            ->get()
            ->map(function ($item) {
                return [
                    $item->subcon_name,
                    $item->group?->name,
                    $item->receipt_date,
                    $item->kwitansi_no,
                    $item->kwitansi_value_final,
                    $item->user?->name,
                    optional($item->items->first()?->statusTrx)->name,
                ];
            })
            ->toArray();

        return $trx;
    }

    public function headings(): array
    {
        return [
            'Subcon Name',
            'Group Tagihan',
            'Receipt Date',
            'No. Kwitansi',
            'Jumlah (Rp)',
            'PIC',
            'Last Status',
        ];
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
            'A' => 20,
            'B' => 20,
            'C' => 15,
            'D' => 20,
            'E' => 15,
            'F' => 15,
            'G' => 15,
        ];
    }

    public function map($row): array
    {
        return $row;
    }
}

