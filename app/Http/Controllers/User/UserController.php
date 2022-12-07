<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\MassDestroyUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Org;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('read-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');

        $users = User::query()
            ->when($inputSearchString, function ($query) use ($inputSearchString) {
                $query->where(function ($query) use ($inputSearchString) {
                    $query->orWhere('name', 'LIKE', '%' . $inputSearchString . '%');
                    $query->orWhere('username', 'LIKE', '%' . $inputSearchString . '%');
                    $query->orWhere('email', 'LIKE', '%' . $inputSearchString . '%');
                    $query->orWhere('phone', 'LIKE', '%' . $inputSearchString . '%');
                    $query->whereHas('org', function (Builder $builder) use ($inputSearchString) {
                        $builder->where('name', 'LIKE', '%' . $inputSearchString . '%');
                    });
                    $query->whereHas('role', function (Builder $builder) use ($inputSearchString) {
                        $builder->where('name', 'LIKE', '%' . $inputSearchString . '%');
                    });
                });
            })
            ->isActive()
            ->with('org:id,name')
            ->with('role:id,name')
            ->orderBy('name')
            ->paginate(config('app-config.per_page'));

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('create-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $org = Org::query()
            ->select('id', 'name')
            ->isActive()
            ->orderBy('id', 'DESC')
            ->get();

        $role = Role::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('users.create', compact('org', 'role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        abort_if(!auth()->user()->can('create-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validated = $request->merge(['is_org_admin' => isset($request->is_org_admin) ? 1 : 2, 'password' => Hash::make($request->password)]);
        $user = User::create($validated->except('is_colleague_of_user_id', 'reports_to_user_id'));
        $user->reportToUsers()->attach(
            $request->reports_to_user_id,
            ['valid_from' => Carbon::today(), 'valid_to' => Carbon::now()->addYear(10), 'createdby_userid' => auth()->user()->id]
        );
        $user->collegues()->attach(
            $request->is_colleague_of_user_id,
            ['valid_from' => Carbon::today(), 'valid_to' => Carbon::now()->addYear(10), 'createdby_userid' => auth()->user()->id]
        );

        return back()->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        abort_if(!auth()->user()->can('show-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('reportToUsers');
        $user->load('collegues');
        $user->load('org:id,name');
        $user->load('role:id,name');
        // dd($user);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        abort_if(!auth()->user()->can('update-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $org = Org::query()
            ->select('id', 'name')
            ->isActive()
            ->orderBy('id', 'DESC')
            ->get();

        $role = Role::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $users = User::query()
            ->select('id', 'name')
            ->where('org_id', $user->org_id)
            ->isActive()
            ->orderBy('name')
            ->get();

        $colleguesId = collect($user->collegues)->pluck('id')->toArray();
        $reportToUsersId = collect($user->reportToUsers)->pluck('id')->toArray();

        return view('users.edit', compact('user', 'org', 'role', 'colleguesId', 'reportToUsersId', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        abort_if(!auth()->user()->can('update-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validated = $request->merge(['is_org_admin' => isset($request->is_org_admin) ? 1 : 2, 'password' => Hash::make($request->password)]);
        $user->update($validated->except('is_colleague_of_user_id', 'reports_to_user_id'));
        $user->reportToUsers()->sync(
            $request->reports_to_user_id,
            ['valid_from' => Carbon::today(), 'valid_to' => Carbon::now()->addYear(10), 'createdby_userid' => auth()->user()->id]
        );
        $user->collegues()->sync(
            $request->is_colleague_of_user_id,
            ['valid_from' => Carbon::today(), 'valid_to' => Carbon::now()->addYear(10), 'createdby_userid' => auth()->user()->id]
        );

        return back()->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        abort_if(!auth()->user()->can('delete-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->update([
            'is_active' => 3
        ]);

        return back()->with('success', 'User deleted successfully');
    }

    /**
     *
     */

    public function massDestroy(MassDestroyUserRequest $request)
    {
        abort_if(!auth()->user()->can('delete-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        User::whereIn('id', $request->input('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->user()->id,
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }


}
