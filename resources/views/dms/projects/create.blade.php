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
                            Add Project</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('dms.projects.index') }}">Projects</a>
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
                            <form id="kt_subscriptions_export_form" class="form" method="POST" enctype="multipart/form-data"
                                action="{{ route('dms.projects.store') }}" >
                                @csrf



                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Project name</span>
                                    </label>
                                    <!--end::Label-->
                                    <input
                                        class="form-control form-control-solid {{ $errors->has('project_name') ? 'is-invalid' : '' }}"
                                        type="text" name="project_name" id="project_name"
                                        value="{{ old('project_name', '') }}" required>
                                </div>


                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="">Project Status</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="form-control form-control-solid select2 {{ $errors->has('project_status') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="project_status" id="country-dropdown">
                                        <option value="">Select status</option>
                                        @forelse (\App\Models\DMS\Project::PROJECT_STATUS as $item)
                                            <option value="{{$item}}" @selected(old('project_status') == $item )>{{ Str::ucfirst($item) }}</option>
                                        @empty

                                        @endforelse


                                    </select>
                                </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <input type="hidden" name="is_public" id="" value="2">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class=""><input type="checkbox" name="is_public" id="is_public" value="1" @checked(old('is_public') == 1)>
                                            &nbsp;&nbsp; Is Public</span>
                                    </label>

                                </div>

                                <!--Additional Info Start-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">Additional Info</label> <br />

                                @forelse (\App\Models\DMS\Project::ADDITIONAL_DETAILS as $key => $value)
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="">{{ $value['value'] }}</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="{{$value['type']}}"
                                            class="form-control form-control-solid  {{ $errors->has($key) ? 'is-invalid' : '' }}"
                                            placeholder="{{ $value['value'] }}" name="{{ $key }}"
                                            value="{{ old($key, '') }}" />
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
