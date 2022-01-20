<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function create()
    {
        $roles = Role::orderBy('name')->get();
        $users = User::whereNotNull('email_verified_at')->orderBy('name')->get();

        if (request()->ajax()) {
            $query = User::query()->orderBy('name');
            return DataTables::of($query)
                ->addColumn('aksi', function($item){
                    return '
                    '.implode(', ', $item->getRoleNames()->toArray()).'
                    ';
                })->addColumn('sync', function ($item) {
                    return '
                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    
                    <a href = "' . route('user_edit', $item->id) . '"
                    class = "btn btn-link float-left">
                         <i class="bi bi-pencil-fill"></i></a>
                     <form action="' . route('user_delete', $item->id) . '" method="POST">
                                ' . method_field('assign_delete') . csrf_field() . '
                                <button type="submit" class="btn btn-link" onclick = "return confirm(\'Anda yakin ingin menghapus data ?\') ">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form></div>';
                })->rawColumns(['aksi', 'sync'])
                ->make();
        }
        

        return view('permissions.users.create', compact(['roles', 'users']));
    }

      public function store()
    {
        request()->validate([
            'user' => 'required',
            'roles' => 'array|required',
        ]);


        $user = User::where('id', request('user'))->first();

        $user->assignRole(request('roles'));

        return back()->with('status', "Pemberian Role Berhasil");

        
    }


       public function edit(User $user){

        //dibuat array mengikuti untuk mengirimkan data sebenernya sama saja seperti variabel namun lebih praktis
        return view('permissions.users.edit', [
            'user' => $user,
            'users' => User::orderBy('name')->get(),
            'roles' => Role::orderBy('name')->get()
            
        ]);


        
    }

    public function update(User $user){
        request()->validate([
            'user' => 'required',
            'roles' => 'array|required',
        ]);

        $user->syncRoles(request('roles'));

        return redirect()->route('user_create')->with('status', "Hak Akses Berhasil Diubah");

    }
}
