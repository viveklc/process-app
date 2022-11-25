@extends('layouts.admin')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">

                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <!--begin::Title-->
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Update Plan</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.plans.index') }}">Plans</a>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">Update</li>
                            <!--end::Item-->
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page title-->
                </div>
                <!--end::Toolbar container-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body pt-7">
                            <form id="kt_subscriptions_export_form" class="form" method="POST"
                            action="{{ route('admin.plans.update',$plan->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Name</span>
                                </label>
                                <!--end::Label-->
                                <input
                                    class="form-control form-control-solid {{ $errors->has('plan_name') ? 'is-invalid' : '' }}"
                                    type="text" name="plan_name" id="plan_name" value="{{ old('plan_name', $plan->plan_name) }}" required>
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Price</span>
                                </label>
                                <!--end::Label-->
                                <input
                                    class="form-control form-control-solid {{ $errors->has('plan_price') ? 'is-invalid' : '' }}"
                                    type="text" name="plan_price" id="plan_price" value="{{ old('plan_price', $plan->plan_price) }}" required>
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Valid From</span>
                                </label>
                                <!--end::Label-->
                                <input
                                    class="form-control form-control-solid {{ $errors->has('valid_from') ? 'is-invalid' : '' }}"
                                    type="date" name="valid_from" id="valid_from"
                                    value="{{ old('valid_from', dbDateFormat($plan->valid_from) ) }}">
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Valid To</span>
                                </label>
                                <!--end::Label-->
                                <input
                                    class="form-control form-control-solid {{ $errors->has('valid_to') ? 'is-invalid' : '' }}"
                                    type="date" name="valid_to" id="valid_to" value="{{ old('valid_to', dbDateFormat($plan->valid_to) ) }}">
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="">Description</span>
                                </label>
                                <!--end::Label-->
                                <textarea class="form-control form-control-solid {{ $errors->has('plan_description') ? 'is-invalid' : '' }}"
                                    name="plan_description" id="plan_description">{{ old('plan_description', $plan->plan_description) }}</textarea>
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="">Features</span>
                                </label>
                                <!--end::Label-->
                                <textarea class="form-control form-control-solid {{ $errors->has('plan_features') ? 'is-invalid' : '' }}"
                                    name="plan_features" id="plan_features">{{ old('plan_features', $plan->plan_features) }}</textarea>
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="">Status</span>
                                </label>
                                <!--end::Label-->
                                <select
                                    class="form-control form-control-solid {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                    style="width: 100%;" name="status" id="country-dropdown">
                                    <option value="active" {{  ($plan->status == 'active') ? 'selected' : ''  }}>Active</option>
                                    <option value="in-active" {{  ($plan->status == 'in-active') ? 'selected' : ''  }}>In-active</option>
                                </select>
                            </div>

                             <!--Additional Info Start-->
                             <label class="d-flex align-items-center fs-6 fw-bold mb-2">Additional Info</label> <br/>
                             {{-- @php
                                 dd(\App\Models\PaymentPlan::ADDITIONAL_DETAILS)
                             @endphp --}}
                             @forelse ( \App\Models\PaymentPlan::ADDITIONAL_DETAILS as $key => $value)

                             <div class="d-flex flex-column mb-8 fv-row">
                                 <!--begin::Label-->
                                 <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                 <span class="">{{ $value['value'] }}</span>
                                 </label>
                                 <!--end::Label-->
                                 <input type="text" class="form-control form-control-solid  {{ $errors->has($key) ? 'is-invalid' : '' }}" placeholder="{{ $value['value'] }}" name="{{ $key }}" value="{{ old($key, collect($plan->planDetails)->where('plan_key_name',$key)->toArray()[$loop->index]['plan_key_value'] ) }}" />
                             </div>
                             @empty
                                 &nbsp;
                             @endforelse
                             <!--Additional Info End-->

                            <div>
                                <button type="submit" id="kt_modal_new_ticket_submit" class="btn btn-primary">
                                    <span class="indicator-label"> {{ trans('global.save') }}</span>
                                </button>
                            </div>
                        </form>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->
    </div>





    <!--end:::Main-->
@endsection

