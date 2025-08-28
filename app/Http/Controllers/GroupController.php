<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Groups::get();
        return view('pages.groups.index', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group = new Groups();
        $group->name = $request->name;
        $group->save();
        return redirect()->back()->with('success', 'Successfully.');
    }

    public function update(Request $request, Groups $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group->name = $request->name;
        $group->save();
        return redirect()->back()->with('success', 'Successfully.');
    }

    public function destroy($id)
    {
        
        $group = Groups::find($id);
        $group->delete();
        return redirect()->back()->with('success', 'Successfully.');
    }
}
