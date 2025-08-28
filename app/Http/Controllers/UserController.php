<?php

namespace App\Http\Controllers;

use App\Models\Devision;
use App\Models\Groups;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index() {

        $users = User::with(['groupuser'])->orderBy('created_at', 'desc')->get();
        
        $roles = Role::all();
        $groups = Groups::all();
        $divisions = Devision::all();
        return view('pages.users.index', compact('users', 'roles', 'groups', 'divisions'));
    }

    public function update(Request $request, User $user)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'roles' => 'required',
            'division' => 'required',
            'group' => 'required',
        ]);

        $user->update($request->only(['name', 'email']));

        if ($request->has('roles')) {
            $user->roles()->sync($request->input('roles'));
        } else {
            $user->roles()->sync([]);
        }

        GroupUser::updateOrCreate(
            ['user_id' => $user->id],
            [
            'group_id' => $request->input('group'),
            'division_id' => $request->input('division'),
        ]
    );

        return response()->json(['success' => 'User updated successfully']);
    }


    public function destroy(string $id)
    {

        $user = DB::table('users')->where('id', $id)->delete();

        if ($user) {
            return redirect()->back()->with('success', 'Successfully.');
        } else {
            return redirect()->back()->with('error', 'User not found or could not be deleted.');
        }
    }
}
