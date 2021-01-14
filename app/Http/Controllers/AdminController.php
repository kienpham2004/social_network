<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Profile\ProfileRepositoryInterface;

class AdminController extends Controller
{
    protected $roleRepo, $profileRepo;

    public function __construct(
        RoleRepositoryInterface $roleRepo,
        ProfileRepositoryInterface $profileRepo
    ) {
        $this->middleware(['checkadmin', 'checkstatus']);
        $this->roleRepo = $roleRepo;
        $this->profileRepo = $profileRepo;
    }

    public function index()
    {
        return view('admin.admin');
    }

    public function listUsers()
    {
        $roles = $this->roleRepo->getListUser();
        
        return view('admin.manage-user', compact('roles'));
    }

    public function changeStatusDisabled(Request $request, $id)
    {
        $user = $this->profileRepo->find($id);
        $data = [
            'status' => $request->status,
        ];
        $this->profileRepo->update($id, $data);
        $result = [
            'id' => $user->id,
        ];

        return response()->json($result);
    }

    public function changeStatusActive(Request $request, $id)
    {
        $user = $this->profileRepo->find($id);
        $data = [
            'status' => $request->status,
        ];
        $this->profileRepo->update($id, $data);
        $result = [
            'id' => $user->id,
        ];

        return response()->json($result);
    }
}
