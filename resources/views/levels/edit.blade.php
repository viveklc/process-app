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
                            Levels</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.levels.index') }}">Level</a>
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
                            <form class="form" method="POST"
                                action="{{ route('admin.levels.update', ['level' => $level]) }}"
                                enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Course</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="form-select form-control form-select-solid {{ $errors->has('course_id') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="course_id" id="course_id" required>

                                        @foreach ($courses as $id => $courseName)
                                            <option value="{{ $id }}"
                                                {{ (old('course_id') ? old('course_id') : $level->course_id ?? '') == $id ? 'selected' : '' }}>
                                                {{ $courseName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Level Name</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid  {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                        placeholder="Level Name" name="name" value="{{ old('name', $level->name) }}"
                                        required />
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Short Description</span>
                                    </label>
                                    <!--end::Label-->
                                    <textarea class="form-control form-control-solid  {{ $errors->has('short_description') ? 'is-invalid' : '' }}"
                                        placeholder="Short Description" name="short_description" required cols="30" rows="5">{{ old('short_description', $level->short_description) }}</textarea>
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Long Description</span>
                                    </label>
                                    <!--end::Label-->
                                    <textarea class="form-control form-control-solid  {{ $errors->has('long_description') ? 'is-invalid' : '' }}"
                                        placeholder="Long Description" name="long_description" required cols="30" rows="5">{{ old('long_description', $level->long_description) }}</textarea>
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Tags</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid  {{ $errors->has('tags') ? 'is-invalid' : '' }}"
                                        placeholder="Tag Name" name="tags" value="{{ old('tags', $level->tags) }}" />
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
                                        class="form-control form-control-solid  {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                        placeholder="Image" name="image" />
                                    <br />
                                    @if ($level->getFirstMediaUrl('Level'))
                                        <a href="{{ $level->getFirstMediaUrl('Level') }}" target="_BLANK">
                                            <img src="{{ $level->getFirstMediaUrl('Level', 'thumb') }}" />
                                        </a>
                                    @endif
                                </div>
                                <!--end::Input group-->

                                <!--Additional Info Start-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">Additional Info</label> <br />
                                @forelse (\App\Models\Content\Level::ADDITIONAL_DETAILS as $key => $value)
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="">{{ $value['value'] }}</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text"
                                            class="form-control form-control-solid  {{ $errors->has($key) ? 'is-invalid' : '' }}"
                                            placeholder="{{ $value['value'] }}" name="{{ $key }}"
                                            value="{{ old($key, $additionalDetails[$loop->index] ?? '') }}" />
                                    </div>
                                @empty
                                    &nbsp;
                                @endforelse
                                <!--Additional Info End-->

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
