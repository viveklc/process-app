<?php

namespace App\Http\Controllers\Plan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plan\MassDestroyPlanRequest;
use App\Http\Requests\Plan\StorePlanRequest;
use App\Http\Requests\Plan\UpdatePlanRequest;
use App\Models\PaymentPlan;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('read-plans'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');

        $plans = PaymentPlan::query()
            ->select('id', 'plan_name', 'plan_price', 'valid_from', 'valid_to', 'status')
            ->when($inputSearchString, function ($query) use ($inputSearchString) {
                $query->where(function ($query) use ($inputSearchString) {
                    $query->orWhere('plan_name', 'LIKE', '%' . $inputSearchString . '%');
                    $query->orWhere('plan_price', 'LIKE', '%' . $inputSearchString . '%');
                });
            })
            ->isActive()
            ->orderBy('id', 'DESC')
            ->paginate(config('app-config.per_page'));

        return view('plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('create-plan'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlanRequest $request)
    {
        abort_if(!auth()->user()->can('create-plan'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plan = PaymentPlan::create($request->safe()->only('plan_name', 'plan_description', 'plan_features', 'plan_price', 'valid_from', 'valid_to', 'status'));
        $plan_details = [];
        $input = $request->validated();

        foreach (PaymentPlan::ADDITIONAL_DETAILS as $key => $value) {
            array_push($plan_details, ['plan_key_name' => $key, 'plan_key_type' => $value['type'], 'plan_key_value' => $input[$key]]);
        }

        $plan->planDetails()->createMany($plan_details);

        return back()->with('success', 'Plan added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentPlan $plan)
    {
        abort_if(!auth()->user()->can('show-plan'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plan->load('planDetails');

        return view('plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentPlan $plan)
    {
        abort_if(!auth()->user()->can('update-plan'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plan->load('planDetails');

        return view('plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlanRequest $request, PaymentPlan $plan)
    {
        abort_if(!auth()->user()->can('update-plan'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plan->update($request->safe()->only('plan_name', 'plan_description', 'plan_features', 'plan_price', 'valid_from', 'valid_to', 'status'));
        $input = $request->validated();
        $plan_details = [];
        foreach (PaymentPlan::ADDITIONAL_DETAILS as $key => $value) {
            array_push($plan_details, ['plan_key_name' => $key, 'plan_key_type' => $value['type'], 'plan_key_value' => $input[$key]]);
        }
        $plan->planDetails()->delete();
        $plan->planDetails()->createMany($plan_details);

        return back()->with('success', 'Plan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentPlan $plan)
    {
        abort_if(!auth()->user()->can('delete-plan'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plan->update([
            'is_active' => 3
        ]);

        return back()->with('success', 'Team deleted successfully');
    }

    public function massDestroy(MassDestroyPlanRequest $request)
    {
        PaymentPlan::whereIn('id', $request->input('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->user()->id,
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
