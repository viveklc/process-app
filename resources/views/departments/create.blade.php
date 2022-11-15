@extends('layouts.admin')
@section('content')
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
                        Departments</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.departments.index') }}">Department</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Add</li>
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
                        <form id="" class="form" method="POST" action="{{ route("admin.departments.store") }}" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Organization</span>
                                </label>
                                <!--end::Label-->
                                <select class="form-select form-control form-select-solid {{ $errors->has('organization_id') ? 'is-invalid' : '' }}"  style="width: 100%;" name="organization_id" id="course_id" required >

                                    @foreach($organizations as $id => $organizationName)
                                        <option value="{{ $id }}" {{ old('course_id') == $id ? 'selected' : '' }}>{{ $organizationName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Department Name</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid  {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Department Name" name="name" value="{{ old('name', '') }}" required />
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Description</span>
                                </label>
                                <!--end::Label-->
                                <textarea class="form-control form-control-solid  {{ $errors->has('description') ? 'is-invalid' : '' }}" placeholder="Description" name="description"  required cols="30" rows="5">{{ old('description', '') }}</textarea>
                            </div>
                            <!--end::Input group-->

                            <!--Additional Info Start-->
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">Additional Info</label> <br/>
                            @forelse ( \App\Models\Admin\Department::ADDITIONAL_DETAILS as $key => $value)
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="">{{ $value['value'] }}</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid  {{ $errors->has($key) ? 'is-invalid' : '' }}" placeholder="{{ $value['value'] }}" name="{{ $key }}" value="{{ old($key, '') }}" />
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
