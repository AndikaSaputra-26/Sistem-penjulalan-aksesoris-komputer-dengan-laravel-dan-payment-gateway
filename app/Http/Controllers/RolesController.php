<?php

namespace App\Http\Controllers;

// use App\Models\Roles;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role_show')->only('index');
        $this->middleware('permission:role_create')->only('create', 'store');
        $this->middleware('permission:role_update')->only('edit', 'update');
        $this->middleware('permission:role_delete')->only('delete');
        $this->middleware('permission:role_detail')->only('show');
    }



    public function index()
    {
        if (request()->ajax()) {
            $query = Role::query();
            return Datatables::of($query )
                ->addIndexColumn()
                ->addColumn('action', 'roles._action')
                ->toJson();
        }

        return view('roles.index');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => "required|string|max:50|unique:roles,name",
                'permissions' => "required"
            ],
            [],
            $this->attribute()
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            // add role
            $role = Role::create(['name' => $request->name]);
            // kemudian kasih akses permission
            $role->givePermissionTo($request->permissions);
            Alert::toast('Data berhasil disimpan', 'success');
            return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
            Alert::toast('Data gagal disimpan', 'error');
            return redirect()->back()->withInput($request->all());
        } finally {
            DB::commit();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('roles.detail', [
            'role' => $role,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $data = $role->permissions()->pluck('name')->toArray();
        return view('roles.edit', [
            'role' => $role,
            'permissionChecked' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => "required|string|max:50|unique:roles,name," . $role->id,
                'permissions' => "required"
            ],
            [],
            $this->attribute()
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        DB::beginTransaction();
        try {
            // add role
            $role->name = $request->name;
            // kemudian kasih akses permission
            $role->syncPermissions($request->permissions);
            $role->save();
            Alert::toast('Data berhasil diupdate', 'success');
            return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
            Alert::toast('Data gagal diupdate', 'error');
            return redirect()->back()->withInput($request->all());
        } finally {
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {

        if (User::role($role->name)->count()) {
            Alert::toast('Data gagal dihapus, data sudah berelasi', 'error');
            return redirect()->route('roles.index');
        }

        DB::beginTransaction();
        try {
            // hapus permission
            $role->revokePermissionTo($role->permissions()->pluck('name')->toArray());
            $role->delete();
            Alert::toast('Data berhasil dihapus', 'success');
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
            Alert::toast('Data gagal dihapus', 'error');
        } finally {
            DB::commit();
        }
        return redirect()->route('roles.index');
    }

    private function attribute()
    {
        return [
            'name' => 'Nama Role',
            'permissions' => 'Permission',

        ];
    }
}
