<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['checkadmin', 'checkstatus']);
    }

    public function index()
    {
        return view('admin.admin');
    }

    public function listUsers()
    {
        $roles = Role::with('users')->get();
     
        return view('admin.manage-user', compact('roles'));
    }

    public function changeStatusDisabled(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([ 
            'status' => $request->status,
        ]);

        $result = [
            'id' => $user->id,
        ];

        return response()->json($result);
    }

    public function changeStatusActive(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([ 
            'status' => $request->status,
        ]);

        $result = [
            'id' => $user->id,
        ];

        return response()->json($result);
    }
}
