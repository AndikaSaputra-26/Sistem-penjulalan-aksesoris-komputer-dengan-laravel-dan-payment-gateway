<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user_show')->only('index');
        $this->middleware('permission:user_create')->only('create', 'store');
        $this->middleware('permission:user_update')->only('edit', 'update');
        $this->middleware('permission:user_delete')->only('delete');
    }


    public function index()
    {
        if (request()->ajax()) {
            $query = User::with('roles:id,name');
            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('roles', function ($row) {
                    return $row->roles->first()->name;
                })
                ->addColumn('action', 'user._action')
                ->toJson();
        }
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::all();
        return view('user.add', [
            'role' => $role
        ]);
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
                'name' => "required|string|max:50|unique:users,name",
                'email' => "required|email|unique:users,email",
                'password' => "required|min:6|confirmed",
                'role' => "required"
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'   => $request->name,
                'email'   => $request->email,
                'password'   => Hash::make($request->password),
            ]);
            $user->assignRole($request->role);
            Alert::toast('Data berhasil disimpan', 'success');
            return redirect()->route('user.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::toast('Data gagal disimpan', 'error');
            return redirect()->route('user.index');
        } finally {
            DB::commit();
        }
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
    public function edit(User $user)
    {
        return view('user.edit', [
            'user' => $user,
            'role' => Role::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => "required|string|max:50|unique:users,name, " . $user->id,
                'email' => "required|email|unique:users,email," . $user->id,
                'password' => "confirmed",
                'role' => "required"
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        DB::beginTransaction();
        try {
            $user = User::findOrFail($user->id);
            if ($request->password == "" || $request->password == null) {
                $user->update([
                    'name'   => $request->name,
                    'email'   => $request->email,
                ]);
            } else {
                $user->update([
                    'name'   => $request->name,
                    'email'   => $request->email,
                    'password'   => Hash::make($request->password),
                ]);
            }
            $user->syncRoles($request->role);
            Alert::toast('Data berhasil diupdate', 'success');
            return redirect()->route('user.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::toast('Data gagal diupdate', 'error');
            return redirect()->route('user.index');
        } finally {
            DB::commit();
        }
    }

    public function editProfile(Request $request, User $user)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => "required|string|max:50|unique:users,name, " . auth()->user()->id,
                'email' => "required|email|unique:users,email," . auth()->user()->id,
                'password' => "confirmed",
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $user = User::findOrFail(auth()->user()->id);
            if ($request->password == "" || $request->password == null) {
                $user->update([
                    'name'   => $request->name,
                    'email'   => $request->email,
                ]);
            } else {
                $user->update([
                    'name'   => $request->name,
                    'email'   => $request->email,
                    'password'   => Hash::make($request->password),
                ]);
            }
            Alert::toast('Data berhasil diupdate', 'success');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::toast('Data gagal diupdate', 'error');
            return redirect()->back();
        } finally {
            DB::commit();
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->removeRole($user->roles->first());
            $user->delete();
            Alert::toast('Data berhasil dihapus', 'success');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::toast('Data gagal dihapus', 'error');
        } finally {
            DB::commit();
            return redirect()->back();
        }
    }
}
