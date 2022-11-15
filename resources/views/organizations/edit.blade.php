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
                        Organizations</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.organizations.index') }}">Organization</a>
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
                        <form id="kt_subscriptions_export_form" class="form" method="POST" action="{{ route("admin.organizations.update", ['organization' => $organization]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Name</span>
                                </label>
                                <!--end::Label-->
                                <input class="form-control form-control-solid {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $organization->name) }}">
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Description</span>
                                </label>
                                <!--end::Label-->
                                <textarea class="form-control form-control-solid {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $organization->description) }}</textarea>
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="">Link</span>
                                </label>
                                <!--end::Label-->
                                <input class="form-control form-control-solid {{ $errors->has('link') ? 'is-invalid' : '' }}" type="text" name="link" id="link" value="{{ old('link', $organization->link) }}">
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Image URL</span>
                                </label>
                                <!--end::Label-->
                                <input class="form-control form-control-solid {{ $errors->has('organization_image_url') ? 'is-invalid' : '' }}" type="file" name="organization_image_url" id="organization_image_url" accept="image/*">
                                <br />
                                @if($organization->getFirstMediaUrl('Organization'))
                                <a href="{{ $organization->getFirstMediaUrl('Organization') }}" target="_BLANK">
                                    <img src="{{ $organization->getFirstMediaUrl('Organization', 'thumb') }}" />
                                </a>
                                @endif
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="">Countries</span>
                                </label>
                                <!--end::Label-->
                                <select class="form-control form-control-solid select2 {{ $errors->has('country_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="country_id" id="country-dropdown">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ $organization->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="">States</span>
                                </label>
                                <!--end::Label-->
                                <select class="form-control form-control-solid select2 {{ $errors->has('state_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="state_id" id="state-dropdown">
                                    <option value="">Select Country</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}" {{ $organization->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="">Cities</span>
                                </label>
                                <!--end::Label-->
                                <select class="form-control form-control-solid select2 {{ $errors->has('city_id') ? 'is-invalid' : '' }}" style="width: 100%;" name="city_id" id="city-dropdown">
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ $organization->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button type="submit" id="kt_modal_new_ticket_submit" class="btn btn-primary">
                                    <span class="indicator-label"> {{ trans('global.update') }}</span>
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
