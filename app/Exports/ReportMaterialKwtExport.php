<?php

namespace App\Exports;

use App\Models\Trxs;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\{
    FromArray,
    WithHeadings,
    WithStyles,
    WithEvents,
    ShouldAutoSize
};
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportMaterialKwtExport implements FromArray, WithHeadings, WithStyles, WithEvents, ShouldAutoSize
{
    protected $startDate, $endDate, $subconCode, $subconName, $data;
    protected $totals = ['qty' => 0, 'avg_price' => 0, 'total_rp' => 0, 'jumlah_spk' => 0];

    public function __construct($startDate, $endDate, $subconCode)
    {
        $this->startDate  = $startDate;
        $this->endDate    = $endDate;
        $this->subconCode = $subconCode;
        $this->subconName = $subconCode ? null : 'All';
        $this->data = $this->fetchData();
    }

    protected function fetchData()
    {
        $trxQuery = Trxs::query()
            ->whereBetween('kwitansi_date', [$this->startDate, $this->endDate]);

        if ($this->subconCode) {
            $trxQuery->where('subcon_code', $this->subconCode);
        }

        $trxs = $trxQuery->get();

        $allData = [];

        foreach ($trxs as $trx) {
            $responseKwt = Http::get(env('SAP_API') . '/api/po-numatcard-by-report?numatcard=' . $trx->kwitansi_no);
            $responseData = $responseKwt->json();

            if ($responseKwt->failed() || empty($responseData)) {
                continue;
            }

            foreach ($responseData as $item) {
                $item['subcon_name'] = $trx->subcon_name ?? '-';
                $allData[] = $item;
            }
        }

        if (empty($allData)) {
            $this->subconName = $this->subconCode ?? 'All';
            return [];
        }

        $grouped = collect($allData)->groupBy(['subcon_name', 'itemcode']);

        $results = [];
        foreach ($grouped as $subconName => $items) {
            if ($this->subconCode && $this->subconName === null) {
                $this->subconName = $subconName;
            }

            foreach ($items as $itemCode => $details) {
                $qty = $details->sum('quantity');
                $totalPrice = $details->sum('price');
                $avgPrice = $totalPrice / count($details);
                $uom = $details->first()['uomcode'];
                $itemDesc = $details->first()['dscription'];
                $totalRp = $qty * $avgPrice;
                $jumlahSpk = collect($details)->pluck('docnum')->unique()->count();

                $this->totals['qty'] += $qty;
                $this->totals['avg_price'] += $avgPrice;
                $this->totals['total_rp'] += $totalRp;
                $this->totals['jumlah_spk'] += $jumlahSpk;

                $row = [];

                if (is_null($this->subconCode)) {
                    $row[] = $subconName;
                }

                $row[] = $itemCode;
                $row[] = $itemDesc;
                $row[] = $qty;
                $row[] = $uom;
                $row[] = round($avgPrice, 2);
                $row[] = round($totalRp, 2);
                $row[] = $jumlahSpk;

                $results[] = $row;
            }
        }


        return $results;
    }

    public function array(): array
    {
        $data = $this->data;

        if (!empty($data)) {
            $totalRow = [];

            if (is_null($this->subconCode)) {
                $totalRow[] = '';
            }

            $totalRow = array_merge($totalRow, [
                '',
                'TOTAL',
                $this->totals['qty'],
                '',
                round($this->totals['avg_price'], 2),
                round($this->totals['total_rp'], 2),
                $this->totals['jumlah_spk']
            ]);

            $data[] = $totalRow;
        }

        return $data;
    }


    public function headings(): array
    {
        $heading = ['Item Code', 'Item Name / Description', 'Qty', 'Satuan', 'AVG Price', 'Total (RP)', 'Jumlah SPK'];

        if (is_null($this->subconCode)) {
            array_unshift($heading, 'Subcon');
        }

        $subconDisplayName = $this->subconName ?? ($this->subconCode ? '-' : 'All');

        return [
            ['Report Pemakaian Material - Subcon: ' . $subconDisplayName],
            $heading
        ];
    }



    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            2 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $mergeTo = is_null($this->subconCode) ? 'H1' : 'G1';
                $event->sheet->mergeCells("A1:$mergeTo");
            },
        ];
    }
}
