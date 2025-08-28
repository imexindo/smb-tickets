<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                
                $response = Http::get(env('SAP_API') . '/api/supplier');
                
                if ($response->successful()) {
                    $items = collect($response->json());

                    return datatables()->of($items)->addIndexColumn()->make(true);
                }

                return response()->json(
                    [
                        'message' => 'Gagal mengambil data dari API',
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ],
                    $response->status(),
                );
            } catch (\Exception $e) {
                return response()->json(
                    [
                        'error' => true,
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ],
                    500,
                );
            }
        }

        return view('pages.master.supplier.index');
    }
}
