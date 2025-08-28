<?php

namespace App\Exports;

use App\Models\Trxs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ClaimsReportExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $req = $this->request;

        $query = Trxs::with(['group:id,name,colors', 'user:id,name', 'status_trx:id,name', 'items.statusTrx:id,name']);

        if ($req->filled('type_tgl')) {
            $query->whereHas('items', function ($q) use ($req) {
                $q->where('status_trx_id', $req->type_tgl);

                if ($req->filled('tglrange')) {
                    [$from, $to] = explode(' - ', $req->tglrange);
                    $from = Carbon::createFromFormat('d/m/Y', trim($from))->startOfDay();
                    $to   = Carbon::createFromFormat('d/m/Y', trim($to))->endOfDay();

                    $q->whereBetween('created_at', [$from, $to]);
                }
            });
        }

        if ($req->filled('group_id')) {
            $query->where('group_id', $req->group_id);
        }

        if ($req->filled('status_trx')) {
            $query->whereHas('items', function ($q) use ($req) {
                $q->where('status_trx_id', $req->status_trx);
            });
        }

        if ($req->filled('subcon_code')) {
            $query->where('subcon_code', $req->subcon_code);
        }

        $trx = $query->get();

        $total = 0;

        $data = $trx->map(function ($item) use ($req, &$total) {
            $tanggal = optional($item->items->firstWhere('status_trx_id', $req->type_tgl))->created_at;
            $nilai = 'Rp ' . number_format($item->kwitansi_value_final ?? 0, 0, ',', '.');
            $total += $item->kwitansi_value_final ?? 0;

            return [
                $item->kwitansi_no ?? '-',
                $tanggal ? $tanggal->format('d/m/Y') : '-',
                $item->subcon_name ?? '-',
                $nilai,
                optional($item->group)->name ?? '-',
                optional($item->status_trx)->name ?? '-',
            ];
        });

        $data->push([
            '', '', 'Total', 'Rp ' . number_format($total, 0, ',', '.'), '', ''
        ]);

        return $data;
    }

    public function headings(): array
    {
        $name = $this->request->type_tgl_name ?? 'Tindakan';
        return [
            'No Kwitansi',
            'Tgl. ' . $name,
            'Subkon',
            'Jumlah Tagihan',
            'Group',
            'Status Terakhir',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle("C{$lastRow}:D{$lastRow}")->getFont()->setBold(true);
        $sheet->getStyle("D{$lastRow}")->getAlignment()->setHorizontal('right');

        $sheet->getStyle('D')->getAlignment()->setHorizontal('right');

        return [];
    }
}