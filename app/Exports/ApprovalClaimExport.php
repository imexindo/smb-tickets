<?php

namespace App\Exports;

use App\Models\Trxs;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ApprovalClaimExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $from, $to, $groupId, $subconCode;

    public function __construct($from, $to, $groupId, $subconCode)
    {
        $this->from = $from;
        $this->to = $to;
        $this->groupId = $groupId;
        $this->subconCode = $subconCode;
    }

    public function collection()
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $this->from)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $this->to)->endOfDay();

        $data = Trxs::with(['group:id,name', 'user:id,name'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when($this->groupId, fn($q) => $q->where('group_id', $this->groupId))
            ->when($this->subconCode, fn($q) => $q->where('subcon_code', $this->subconCode))
            ->get();

        $no = 1;
        $total = 0;

        $rows = $data->map(function ($item) use (&$no, &$total) {
            $total += $item->kwitansi_value_final;

            return [
                $no++,
                $item->created_at->format('d/m/Y'),
                $item->receipt_no_final,
                $item->receipt_date_final,
                $item->kwitansi_no,
                $item->kwitansi_date,
                $item->subcon_name,
                'Rp ' . number_format($item->kwitansi_value_final, 0, ',', '.'),
                $item->group->name ?? '-',
                $item->user->name ?? '-',
            ];
        });

        $rows->push([
            '', '', '', '', '', '', 'Total',
            'Rp ' . number_format($total, 0, ',', '.'),
            '', ''
        ]);

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Approval',
            'No Terima Final',
            'Tgl Terima Final',
            'No Kwitansi',
            'Tgl Kwitansi',
            'Subcon',
            'Total Kwt Final',
            'Group Tagihan',
            'PIC OPR',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        foreach (['A', 'B', 'D', 'F', 'H', 'I', 'J'] as $column) {
            $sheet->getStyle("{$column}")->getAlignment()->setHorizontal('center');
        }

        $sheet->getStyle('1')->getFont()->setBold(true);

        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("G{$lastRow}:H{$lastRow}")->getFont()->setBold(true);
        $sheet->getStyle("H{$lastRow}")->getAlignment()->setHorizontal('center');

        return [];
    }
}
