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
                       Document Tags</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('dms.document-tags.index') }}">Document Tag</a>
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
                        <form id="" class="form" method="POST" action="{{ route("dms.document-tags.store") }}" enctype="multipart/form-data">
                            @csrf

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Tag Name</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid  {{ $errors->has('document_tag_name') ? 'is-invalid' : '' }}" placeholder="Tag Name" name="document_tag_name" value="{{ old('document_tag_name', '') }}" required />
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Tag Type</span>
                                </label>
                                <!--end::Label-->
                                <select class="form-select form-control form-select-solid select2 {{ $errors->has('document_tag_type') ? 'is-invalid' : '' }}"  style="width: 100%;" name="document_tag_type" id="document_tag_type" required >
                                @foreach($tagTypes as $id => $tagType)
                                    <option value="{{ $id }}" {{ old('document_tag_type') == $id ? 'selected' : '' }}>{{ $tagType }}</option>
                                @endforeach
                                </select>
                            </div>
                            <!--end::Input group-->

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
