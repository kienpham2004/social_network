<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Profile\ProfileRepositoryInterface;

class SearchController extends Controller
{
    protected $profileRepo;

    public function __construct(ProfileRepositoryInterface $profileRepo)
    {
        $this->profileRepo = $profileRepo;
    }

    public function search(Request $request)
    {
        if ($request->valueSearch != "") {
            $users = $this->profileRepo->getValueSearch('username', $request->valueSearch);
            
            return view('layouts.search', compact('users'));
        }
    }
}
