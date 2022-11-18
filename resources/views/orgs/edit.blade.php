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
                            Orgs</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.countries.index') }}">Org</a>
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
                            <form id="kt_subscriptions_export_form" class="form" method="POST" action="{{ route("admin.orgs.update", ['org' => $org]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Name</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid  {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                        placeholder="Name" name="name" value="{{ old('name', $org->name) }}"
                                        required />
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Plan Type</span>
                                        </label>
                                        <!--end::Label-->
                                        <select class="form-select form-control form-select-solid select2 {{ $errors->has('plan_id') ? 'is-invalid' : '' }}"  style="width: 100%;" name="plan_id"  required >
                                            <option value="" >Please Select</option>
                                        </select>
                                    </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Address</span>
                                        </label>
                                        <!--end::Label-->
                                        <textarea class="form-control form-control-solid  {{ $errors->has('address') ? 'is-invalid' : '' }}" placeholder="Address" name="address"  required cols="30" rows="5" >{{ old('address', $org->address) }}</textarea>
                                    </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Image</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="file"
                                        class="form-control form-control-solid  {{ $errors->has('image_url') ? 'is-invalid' : '' }}"
                                        placeholder="Image" name="image_url"  />
                                        <br />
                                    @if($org->getFirstMediaUrl('Org'))
                                        <a href="{{ $org->getFirstMediaUrl('Org') }}" target="_BLANK">
                                            <img src="{{ $org->getFirstMediaUrl('Org', 'thumb') }}" />
                                        </a>
                                    @endif
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                 <div class="d-flex flex-column mb-8 fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Premium</span>
                                        </label>
                                        <!--end::Label-->
                                        <select class="form-select form-control form-select-solid select2 {{ $errors->has('is_premium') ? 'is-invalid' : '' }}"  style="width: 100%;" name="is_premium"  required >
                                            <option value="" >Please Select</option>
                                            <option value="1" {{$org->is_premium===1?'selected':''}}>Yes</option>
                                            <option value="2" {{$org->is_premium===2?'selected':''}}>No</option>
                                        </select>
                                    </div>
                                <!--end::Input group-->

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
