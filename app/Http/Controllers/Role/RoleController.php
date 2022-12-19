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
            ->orderBy('name')
            ->paginate(config('app-config.datatable_default_row_count'))
            ->withQueryString();

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

            toast(__('global.crud_actions', ['module' => 'Role', 'action' => 'created']), 'success');
            return redirect()->route('admin.roles.index');
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
    public function show(Role $role)
    {
        $role->load('permissions')
        ->orderBy('name')
        ->orderBy('id')
        ->get();

        return view('roles.show',compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::query()
        ->orderBy('name')
        ->get();

        $role->load('permissions');

        return view('roles.edit', compact('role','permissions'));
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

            toast(__('global.crud_actions', ['module' => 'Role', 'action' => 'updated']), 'success');
            return redirect()->route('admin.roles.index');
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }


}
