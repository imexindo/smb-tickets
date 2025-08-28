<?php

namespace App\Exports;

use App\Models\Trxs;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Http;

class ClaimsReportKwtExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    protected $startDate, $endDate, $groupId, $statusTrx, $subconCode, $picId;
    protected $data;

    public function __construct($startDate, $endDate, $groupId, $statusTrx, $subconCode, $picId)
    {
        $this->startDate  = $startDate;
        $this->endDate    = $endDate;
        $this->groupId    = $groupId;
        $this->statusTrx  = $statusTrx;
        $this->subconCode = $subconCode;
        $this->picId      = $picId;

        $this->fetchData();
    }

    protected function fetchData()
    {
        $query = Trxs::whereBetween('receipt_date', [$this->startDate, $this->endDate]);

        if ($this->groupId) {
            $query->where('group_id', $this->groupId);
        }
        if ($this->statusTrx) {
            $query->where('status', $this->statusTrx);
        }
        if ($this->subconCode) {
            $query->where('subcon_code', $this->subconCode);
        }
        if ($this->picId) {
            $query->where('created_by', $this->picId);
        }

        $trxList = $query->get();

        $results = [];

        foreach ($trxList as $trx) {
            try {
                $response = Http::timeout(5)->get(env('SAP_API') . "/api/po-numatcard?numatcard=" . $trx->kwitansi_no);
                if ($response->ok()) {
                    $sapItems = $response->json();

                    foreach ($sapItems as $sap) {
                        $results[] = [
                            $sap['docnum'] ?? '-',
                            $trx->subcon_name,
                            $trx->receipt_date,
                            $sap['Toko'] ?? '-',
                            (float) ($sap['doctotal'] ?? 0),
                            $sap['u_sol_po_type'] ?? '-',
                            $trx->kwitansi_no
                        ];
                    }
                }
            } catch (\Exception $e) {
                // Optional: Log error
            }
        }

        $this->data = collect($results);
    }


    public function array(): array
    {
        return $this->data->toArray();
    }

    public function headings(): array
    {
        return [
            'No. PO',
            'Subkon',
            'Tgl. Terima Dokumen',
            'Customer Name',
            'Jumlah Rp.',
            'Tipe PO',
            'No. Kwitansi'
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
            'A' => 15,
            'B' => 25,
            'C' => 18,
            'D' => 25,
            'E' => 18,
            'F' => 12,
            'G' => 30,
        ];
    }

    
}
