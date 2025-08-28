<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class CustomersController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $response = Http::get(env('SAP_API') . '/api/customers');

            if ($response->successful()) {
                $allData = collect($response->json());

                // Ambil semua data Customers lokal
                $localCustomers = Customers::pluck('name', 'groupcode', 'status'); // [groupcode => name]

                // Tambahkan kolom 'local_name' ke setiap item berdasarkan groupcode
                $allData = $allData->map(function ($item) use ($localCustomers) {
                    $item['local_name'] = $localCustomers[$item['groupcode']] ?? '-';
                    return $item;
                });

                // ✨ Search
                $searchValue = $request->input('search.value');
                if ($searchValue) {
                    $allData = $allData->filter(function ($item) use ($searchValue) {
                        return Str::contains(Str::lower($item['groupcode'] ?? ''), Str::lower($searchValue))
                            || Str::contains(Str::lower($item['u_sol_c_cust_code'] ?? ''), Str::lower($searchValue))
                            || Str::contains(Str::lower($item['cardname'] ?? ''), Str::lower($searchValue))
                            || Str::contains(Str::lower($item['u_sol_subcon'] ?? ''), Str::lower($searchValue))
                            || Str::contains(Str::lower($item['fathercard'] ?? ''), Str::lower($searchValue))
                            || Str::contains(Str::lower($item['phone1'] ?? ''), Str::lower($searchValue))
                            || Str::contains(Str::lower($item['city'] ?? ''), Str::lower($searchValue))
                            || Str::contains(Str::lower($item['address'] ?? ''), Str::lower($searchValue));
                    });
                }

                // ✨ Sort
                $orderColumnIndex = $request->input('order.0.column');
                $orderDirection = $request->input('order.0.dir');
                $columns = [
                    'DT_RowIndex',
                    'groupcode',
                    'u_sol_c_cust_code',
                    'cardname',
                    'u_sol_subcon',
                    'fathercard',
                    'phone1',
                    'city',
                    'address',
                    'createdate',
                    'actions',
                    'local_name'
                ];
                $orderColumn = $columns[$orderColumnIndex] ?? 'DT_RowIndex';

                if ($orderColumn !== 'DT_RowIndex' && $orderColumn !== 'actions') {
                    $allData = $allData->sortBy([
                        [$orderColumn, $orderDirection === 'asc' ? SORT_ASC : SORT_DESC]
                    ])->values();
                }

                $recordsFiltered = $allData->count();

                // ✨ Pagination
                $start = $request->input('start', 0);
                $length = $request->input('length', 10);
                $paginated = $allData->slice($start, $length)->values();

                // Tambahkan kolom tambahan seperti actions
                $paginated->transform(function ($item, $index) use ($start) {
                    $item['DT_RowIndex'] = $start + $index + 1;
                    $item['actions'] = '<button class="btn btn-sm btn-success" style="font-size: 12px"><i class="fa fa-folder-open"></i> History</button>';
                    return $item;
                });

                return response()->json([
                    'draw' => intval($request->input('draw')),
                    'recordsTotal' => $recordsFiltered,
                    'recordsFiltered' => $recordsFiltered,
                    'data' => $paginated,
                ]);
            }

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
            ]);
        }

        return view('pages.master.customers.index');
    }
}
