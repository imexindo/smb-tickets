<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::with(['pt', 'user'])->get();
        return view('pages.karyawan.index', compact('karyawan'));
    }
}
