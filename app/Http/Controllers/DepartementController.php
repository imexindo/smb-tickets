<?php

namespace App\Http\Controllers;

use App\Models\Devision;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function index()
    {
        $dprt = Devision::get();
        return view('pages.departments.index', compact('dprt'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $dprt = Devision::create($request->all());
        return redirect()->back()->with('success', 'Successfully.');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $dprt = Devision::find($id);
        $dprt->update($request->all());
        return response()->json(['success' => 'Successfully']);
    }
    
    public function destroy($id)
    {
        $dprt = Devision::find($id);
        $dprt->delete();
        return response()->json(['success' => 'Department deleted successfully']);
    }
    
    
}
