<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDeptUserRequest;
use App\Http\Requests\StoreDeptUserRequest;
use App\Models\Dept;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeptUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Dept $dept)
    {
        abort_if(!auth()->user()->can('read-department-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');

        $id = $dept->id;
        $deptUsers = $dept->deptUsers()
            ->when($inputSearchString, function ($query) use ($inputSearchString) {
                $query->where(function ($query) use ($inputSearchString) {
                    $query->orWhere('name', 'LIKE', '%' . $inputSearchString . '%');
                    $query->orWhere('email', 'LIKE', '%' . $inputSearchString . '%');
                    $query->orWhere('phone', 'LIKE', '%' . $inputSearchString . '%');
                });
            })
            ->paginate(config('app-config.per_page'));

        return view('depts.dept-users.index', compact('deptUsers', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Dept $dept)
    {
        abort_if(!auth()->user()->can('create-department-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = $dept->id;
        $addTouser = User::whereNotIn('id', collect($dept->deptUsers)->pluck('id')->toArray())
            ->select('id', 'name')
            ->get();

        return view('depts.dept-users.add', compact('addTouser', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeptUserRequest $request, Dept $dept)
    {
        abort_if(!auth()->user()->can('create-department-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dept->deptUsers()->attach($request->user_id);

        return redirect()->route('admin.depts.dept-users.index', $dept->id)->with('success', 'User added to Department');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dept $dept, $user_id)
    {
        abort_if(!auth()->user()->can('delete-department-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dept->deptUsers()->detach($user_id);

        return back()->with('success', 'User deleted successfully');
    }

    public function massDestroy(MassDestroyDeptUserRequest $request)
    {
        abort_if(!auth()->user()->can('delete-department-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team = Dept::find($request->dept_id);
        $team->deptUsers()->detach($request->ids);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
