<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->valueSearch != "") {
            $users = User::where('username', 'like', '%' . $request->valueSearch . '%')->get();
       
            return view('layouts.search', compact('users'));
        }
    }
}
