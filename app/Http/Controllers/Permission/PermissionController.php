<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inputSearchString = $request->input('s', '');

        $permissions = Permission::query()
            ->select('id', 'name')
            ->when($inputSearchString, function($query) use ($inputSearchString){
                $query->where('name','LIKE','%'.$inputSearchString.'%');
            })
            ->orderBy('name')
            ->paginate(config('app-config.datatable_default_row_count'));

        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        try {
           $permission = Permission::create($request->validated());
           $role = Role::where('name','admin')->first();
           $permission->assignRole($role);

           toast(__('global.crud_actions', ['module' => 'Permission', 'action' => 'created']), 'success');
            return redirect()->route('admin.permissions.index');
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
    public function show(Permission $permission)
    {
        $permission->load('roles')->orderBy('name');

        return view('permissions.show',compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        try {
            $permission->update($request->validated());

            toast(__('global.crud_actions', ['module' => 'Permission', 'action' => 'updated']), 'success');
            return redirect()->route('admin.permissions.index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
