<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\PT;
use App\Models\User;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{

    public function index()
    {
        $karyawan = Karyawan::with(['pt', 'user'])->get();
        $pt = PT::all();
        $user = User::select('id', 'name')
            ->whereNotIn('id', $karyawan->pluck('user_id'))
            ->get();
        return view('pages.karyawan.index', compact('karyawan', 'pt', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:karyawan,nik',
            'user_id' => 'required|unique:karyawan,user_id',
            'pt_id' => 'required',
        ]);

        Karyawan::create([
            'nik' => $request->nik,
            'user_id' => $request->user_id,
            'pt_id' => $request->pt_id,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'successfully');
    }

    public function edit($id)
    {
        $pt = PT::select('id', 'name')->get();

        $karyawan = Karyawan::with(['pt:id,name', 'user:id,name'])
            ->select('id', 'nik', 'user_id', 'pt_id')
            ->find($id);

        return response()->json([
            'karyawan' => $karyawan,
            'pt' => $pt,
        ]);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'pt_id' => 'required',
        ]);

        Karyawan::where('id', $id)->update([
            'pt_id' => $request->pt_id,
        ]);

        return response()->json(['success' => 'successfully']);
    }

    public function destroy($id)
    {
        Karyawan::where('id', $id)->delete();

        return response()->json(['success' => 'successfully']);
    }
}
