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
                            Update Process</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.processes.index') }}">Processes</a>
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
                            <form id="kt_subscriptions_export_form" class="form" method="POST" enctype="multipart/form-data"
                                action="{{ route('admin.processes.update',$process->id) }}" >
                                @csrf
                                @method('PUT')
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Organisation</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="form-control form-control-solid select2 {{ $errors->has('org_id') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="org_id" id="country-dropdown">
                                        <option value="">Select Organisation</option>
                                        @forelse ($org as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $process->org_id == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Name</span>
                                    </label>
                                    <!--end::Label-->
                                    <input
                                        class="form-control form-control-solid {{ $errors->has('process_name') ? 'is-invalid' : '' }}"
                                        type="text" name="process_name" id="process_name"
                                        value="{{ old('process_name', $process->process_name) }}" required>
                                </div>



                                <div class="row mb-8">
                                    <div class="col-md-8">
                                        <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Total Duration</span>
                                    </label>
                                    <!--end::Label-->
                                    <input
                                        class="form-control form-control-solid {{ $errors->has('total_duration') ? 'is-invalid' : '' }}"
                                        type="number" name="total_duration" id="total_duration"
                                        value="{{ old('total_duration', $process->total_duration) }}" required >
                                    </div>
                                    <div class="col-md-4">
                                          <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Unit</span>
                                    </label>
                                    <!--end::Label-->
                                    <select name="unit" id="" class="form-control form-control-solid select2 {{ $errors->has('unit') ? 'is-invalid' : '' }}"  required>
                                        <option value="">Select unit</option>
                                        @forelse (\App\Models\Process\Process::DURATION_UNITS as $key => $value)
                                            <option value="{{ $key }}" @selected(old('unit',$process->unit) == $key)>{{ $value }}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                    </div>


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
                                        value="{{ old('valid_from', dbDateFormat($process->valid_from)) }}">
                                </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Valid To</span>
                                    </label>
                                    <!--end::Label-->
                                    <input
                                        class="form-control form-control-solid {{ $errors->has('valid_to') ? 'is-invalid' : '' }}"
                                        type="date" name="valid_to" id="valid_to" value="{{ old('valid_to', dbDateFormat($process->valid_to)) }}">
                                </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Priority</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="form-control form-control-solid select2 {{ $errors->has('process_priority') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="process_priority" id="country-dropdown">
                                        <option value="1" {{ $process->process_priority == 1 ? 'selected' : '' }} >High</option>
                                        <option value="2" {{ $process->process_priority == 2 ? 'selected' : '' }} >Medium</option>
                                        <option value="3" {{ $process->process_priority == 3 ? 'selected' : '' }} >Low</option>
                                    </select>
                                </div>

                                 <!--begin::Input group-->
                                 <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Attachment</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="file"
                                        class="form-control form-control-solid  {{ $errors->has('attachments') ? 'is-invalid' : '' }}"
                                        placeholder="" name="attachments[]" multiple />
                                        <div class="attachment-div">
                                            <ul class="list-group list-group-horizontal">
                                                @forelse ($process->media as $item)
                                                    <li class="list-group-item"><a href="{{ $item->original_url }}"
                                                            target="__blank" class="btn-link">{{ Str::limit($item->file_name, 10, '*****') }}</a>
                                                        &nbsp;&nbsp; <span onclick="deleteMedia({{ $item->id }},this)"><i
                                                                class="fa fa-times" style="color: red"></i></span></li>
                                                @empty
                                                @endforelse

                                            </ul>
                                        </div>
                                </div>
                                <!--end::Input group-->

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="">Description</span>
                                    </label>
                                    <!--end::Label-->
                                    <textarea class="form-control form-control-solid {{ $errors->has('process_description') ? 'is-invalid' : '' }}"
                                        name="process_description" id="process_description">{{ old('process_description', $process->process_description) }}</textarea>
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
                                    <option value="active" {{  ($process->status == 'active') ? 'selected' : ''  }}>Active</option>
                                    <option value="in-active" {{  ($process->status == 'in-active') ? 'selected' : ''  }}>In-active</option>
                                </select>
                                </div>

                                <!--Additional Info Start-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">Additional Info</label> <br />
                                {{-- @php
                                 dd(\App\Models\PaymentPlan::ADDITIONAL_DETAILS)
                             @endphp --}}
                                @forelse (\App\Models\Process\Process::ADDITIONAL_DETAILS as $key => $value)
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="">{{ $value['value'] }}</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" class="form-control form-control-solid  {{ $errors->has($key) ? 'is-invalid' : '' }}" placeholder="{{ $value['value'] }}" name="{{ $key }}" value="{{ old($key, collect($process->processDetails)->where('process_key_name',$key)->toArray()[$loop->index]['process_key_value'] ) }}" />
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
@section('scripts')
    <script>
        function deleteMedia(media_id, content) {
            const $parentLi = $(content).parents('.list-group-item');

            let url = '{{ route('admin.media.remove', ':media_id') }}';

            url = url.replace(':media_id', media_id);
            Swal.fire({
                title: '{{ trans('global.are_you_sure') }}',
                text: "{{ trans('global.are_you_sure_delete_msg') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ trans('global.ok') }}'
            }).then((result) => {

                $.ajax({
                method: "DELETE",
                url: url,
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {

                },
                success: function(response) {
                    if (response.status === 'success') {
                        // alert(response.message);
                        $parentLi.remove();
                    }



                }
            })
            })

        }

        function getUserByOrgId(org_id) {
            let url = '{{ route('admin.org.users', ':org_id') }}';

            url = url.replace(':org_id', org_id);

            $.ajax({
                method: "GET",
                url: url,
                cache: false,
                beforeSend: function() {

                },
                success: function(response) {
                    // console.log(response);
                    var option = "<option value=''>select Team User</option>";
                    $.each(response, function(index, value) {

                        option += "<option value='" + value.id + "'>" + value.name + "</option>";

                    });
                    $('#team_user_dropDown').html(option);

                }
            })
        }
    </script>
@endsection
