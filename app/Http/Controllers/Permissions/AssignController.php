<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;


class AssignController extends Controller
{
     public function create()
    {
        $role = Role::get();
        $permission = Permission::get();

       

        if (request()->ajax()) {
            $query = Role::query();
            return DataTables::of($query)
                ->addColumn('aksi', function($item){
                    return '
                    '.implode(', ', $item->getPermissionNames()->toArray()).'
                    ';
                })->addColumn('sync', function ($item) {
                    return '
                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    
                    <a href = "' . route('assign_edit', $item->id) . '"
                    class = "btn btn-link float-left">
                        <i class="bi bi-pencil-fill"></i> </a>
                     <form action="' . route('assign_delete', $item->id) . '" method="POST">
                                ' . method_field('assign_delete') . csrf_field() . '
                                <button type="submit" class="btn btn-link" onclick = "return confirm(\'Anda yakin ingin menghapus data ?\') ">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form></div>';
                })->rawColumns(['aksi', 'sync'])
                ->make();
        }
        

        return view('permissions.assigns.create', compact('role', 'permission'));
    }


     public function store()
    {
        request()->validate([
            'name' => 'required',
            'permission' => 'array|required',
        ]);

        $role = Role::find(request('name'));
        $role->givePermissionTo(request('permission'));

        return back()->with('status', "Pemberian Hak Akses Berhasil");

        
    }

    public function edit(Role $role){

        //dibuat array mengikuti untuk mengirimkan data sebenernya sama saja seperti variabel namun lebih praktis
        return view('permissions.assigns.edit', [
            'role' => $role,
            'roles' => Role::get(),
            'permissions' => Permission::get()
            
        ]);
    }

    public function update(Role $role){
        request()->validate([
            'name' => 'required',
            'permission' => 'array|required',
        ]);

        $role->syncPermissions(request('permission'));

        return redirect()->route('assign_create')->with('status', "Hak Akses Berhasil Diubah");
    }

}