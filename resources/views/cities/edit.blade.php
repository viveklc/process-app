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
                            Cities</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.cities.index') }}">City</a>
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
                            <form method="POST" action="{{ route("admin.cities.update", ['city' => $city]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Country</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="select2 form-select form-control form-select-solid {{ $errors->has('country_id') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="country_id" id="country_id" required>
                                        @foreach($countries as $id => $countryName)
                                            <option value="{{ $id }}"  {{ (old('country_id') ? old('country_id') : ($city->country_id ?? '')) == $id ? 'selected' : '' }}>{{ $countryName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">State</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="select2 form-select form-control form-select-solid {{ $errors->has('country_id') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="state_id" id="state_id" required>
                                        @foreach($states as $id => $stateName)
                                            <option value="{{ $id }}"  {{ (old('country_id') ? old('country_id') : ($city->state_id ?? '')) == $id ? 'selected' : '' }}>{{ $stateName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">City Name</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid  {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                        placeholder="City Name" name="name" value="{{ old('name', $city->name) }}" required />
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
                                        @if($city->getFirstMediaUrl('City'))
                                        <a href="{{ $city->getFirstMediaUrl('City') }}" target="_BLANK">
                                            <img src="{{ $city->getFirstMediaUrl('City', 'thumb') }}" />
                                        </a>
                                        @endif
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
@section('scripts')
    @parent
    <script>
        $('#country_id').change(function() {
            const country_id = $(this).val();
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.cities.getstates') }}",
                data: {
                    country_id: country_id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    var items = "";
                    if(data.length > 0) {
                        items += "<option value=''>Please select</option>";
                        $.each(data, function(i, item) {
                            items += "<option value='" + item.id + "'>" + (item.text) + "</option>";
                        });
                        $("#state_id").html(items);
                        $('#state_id').select2();
                    }
                    else {
                        items += "<option value=''>Please select</option>";
                        $("#state_id").html(items);
                        $('#state_id').select2();
                    }
                }
            });
        })
    </script>
@endsection
