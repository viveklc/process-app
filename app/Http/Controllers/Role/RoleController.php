<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\MassDestroyRoleRequest;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inputSearchString = $request->input('s', '');

        $roles = Role::query()
            ->select('id', 'name')
            ->when($inputSearchString, function ($query) use ($inputSearchString) {
                $query->where('name', 'LIKE', '%' . $inputSearchString . '%');
            })
            ->orderBy('id', 'DESC')
            ->paginate(config('app-config.per_page'));

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        try {
            $role = Role::create($request->safe()->except('permission_name'));
            $role->givePermissionTo($request->permission_name);

            return back()->with('success', 'Role created successfully');
        } catch (Exception $e) {
            return $e->getMessage();
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
    public function edit(Role $role)
    {
        $role->load('permissions');

        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            $role->update($request->only('name'));
            $role->syncPermissions($request->permission_name);

            return back()->with('success', 'Role updated successfully');
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }


}
