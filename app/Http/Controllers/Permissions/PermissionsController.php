<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Permission::query();
            return DataTables::of($query)
                ->addColumn('aksi', function ($item) {
                    return '
                      <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <a href = "' . route('permission_edit', $item->id) . '"
                    class = "btn btn-link float-left">
                       <i class="bi bi-pencil-fill"></i></a>
                       
                     <form action="' . route('permission_delete', $item->id) . '" method="POST">
                                ' . method_field('delete') . csrf_field() . '
                              <button type="submit" class="btn btn-link" onclick = "return confirm(\'Anda yakin ingin menghapus data ?\') ">
                               <i class="bi bi-trash-fill"></i>
                            </button>
                            </form>
                        </div>
                    
                ';
                })->rawColumns(['aksi'])
                ->make();
        }

        return view('permissions.permissions.index');
    }
        

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.permissions.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $name = $request->name;
         $guard_name = $request->guard_name;

         if ($guard_name == null) {
             $guard_name = 'web';
         }
        
        Permission::create([
            'name' => $name,
            'guard_name' => $guard_name
        ]);
        return redirect()->route('permission_index')->with('status', 'Permission Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
          return view('permissions.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {      
        Permission::where('id', $permission->id)
            ->update([
                'name' => $request->name,
                'guard_name' => $request->guard_name
                
            ]);
        return redirect()->route('permission_index')->with('status', 'Data Permission Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        Permission::destroy($permission->id);
        return redirect()->route('permission_index')->with('status', 'Data Permission Berhasil Dihapus');
    }
}
