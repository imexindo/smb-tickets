<?php

namespace App\Exports;

use App\Models\Trxs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportKesalahanOpr implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $startDate, $endDate, $group_id, $status_trx, $subcon_code, $pic_id;

    public function __construct($startDate, $endDate, $group_id = null, $status_trx = null, $subcon_code = null, $pic_id = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->group_id = $group_id;
        $this->status_trx = $status_trx;
        $this->subcon_code = $subcon_code;
        $this->pic_id = $pic_id;
    }

    public function collection()
    {
        $query = Trxs::with(['group', 'user', 'status_trx', 'items.statusTrx'])
            ->whereBetween('kwitansi_date', [$this->startDate, $this->endDate]);

        if ($this->group_id) {
            $query->where('group_id', $this->group_id);
        }

        if ($this->status_trx) {
            $query->whereHas('items', function ($q) {
                $q->where('status_trx_id', $this->status_trx);
            });
        }

        if ($this->subcon_code) {
            $query->where('subcon_code', $this->subcon_code);
        }

        if ($this->pic_id) {
            $query->where('pic_id', $this->pic_id);
        }

        $data = $query->get();
        $results = [];
        $no = 1;

        foreach ($data as $trx) {
            $tolakItem = $trx->items->firstWhere('status_trx_id', 2);
            if (!$tolakItem) continue;

            $tglTolak = optional($tolakItem->created_at)->format('d/m/Y H:i');

            $jenisKesalahan = $tolakItem->statusTrx->name ?? '-';
            if ($tolakItem->remark) {
                $jenisKesalahan .= ' - ' . $tolakItem->remark;
            }

            $indexTolak = $trx->items->search(function ($item) {
                return $item->status_trx_id == 2;
            });

            $tglSelesai = '-';
            $lamaSelesai = '-';

            if ($indexTolak !== false && $indexTolak < $trx->items->count() - 1) {
                $nextItem = $trx->items[$indexTolak + 1];
                if ($nextItem->created_at) {
                    $tglSelesai = $nextItem->created_at->format('d/m/Y H:i');
                    $diff = $nextItem->created_at->diffInDays($tolakItem->created_at);
                    $lamaSelesai = $diff . ' hari';
                }
            }

            $lastItem = $trx->items->last();
            $lastStatus = $lastItem->statusTrx->name ?? '-';

            $results[] = [
                $no++,
                $tglTolak,
                $jenisKesalahan,
                $trx->kwitansi_no,
                $lastStatus,
                $trx->kwitansi_date,
                $trx->subcon_name,
                $tglSelesai . ' (' . $lamaSelesai . ')',
                $trx->user->name ?? '-',
                $trx->group->name ?? '-',
            ];
        }

        return collect($results);
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Tolak',
            'Jenis Kesalahan',
            'No Kwitansi',
            'Status Terakhir',
            'Tanggal Kwitansi',
            'Subkon',
            'Tgl Selesai + Lama',
            'PIC',
            'Group',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header style
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                'borders' => ['bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 18,  // Tanggal Tolak
            'C' => 30,  // Jenis Kesalahan
            'D' => 18,  // No Kwitansi
            'E' => 20,  // Status Terakhir
            'F' => 18,  // Tanggal Kwitansi
            'G' => 20,  // Subkon
            'H' => 30,  // Tgl Selesai + Lama
            'I' => 20,  // PIC
            'J' => 20,  // Group
        ];
    }
}
