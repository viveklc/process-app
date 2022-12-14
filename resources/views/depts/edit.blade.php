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
                            Depts</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.depts.index') }}">Dept</a>
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
                            <form id="kt_subscriptions_export_form" class="form" method="POST" action="{{ route("admin.depts.update", ['dept' => $dept]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Org Name</span>
                                    </label>
                                    <!--end::Label-->
                                    <select class="form-select form-control form-select-solid select2 {{ $errors->has('org_id') ? 'is-invalid' : '' }}"  style="width: 100%;" name="org_id" id="org_id" required >
                                    @foreach ($orgs as $id => $orgName)
                                            <option value="{{ $id }}"
                                            {{ (old('org_id') ? old('org_id') : ($dept->org_id ?? '')) == $id ? 'selected' : '' }}>{{ $orgName }}
                                            </option>
                                     @endforeach
                                    </select>
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Name</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid  {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                        placeholder="Name" name="name"
                                        value="{{ old('name', $dept->name) }}"required />
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="">Attachment</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="file"
                                        class="form-control form-control-solid  {{ $errors->has('attachments') ? 'is-invalid' : '' }}"
                                        placeholder="" name="attachments[]" multiple />
                                        <div class="attachment-div">
                                            <ul class="list-group list-group-horizontal">
                                                @forelse ($dept->media as $item)
                                                    <li class="list-group-item"><a href="{{ $item->original_url }}"
                                                            target="__blank" class="btn-link">{{ $item->file_name }}</a>
                                                        &nbsp;&nbsp; <span onclick="deleteMedia({{ $item->id }},this)"><i
                                                                class="fa fa-times" style="color: red"></i></span></li>
                                                @empty
                                                @endforelse

                                            </ul>
                                        </div>
                                </div>
                                <!--end::Input group-->

                                 <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="">Description</span>
                                    </label>
                                    <!--end::Label-->
                                    <textarea class="form-control form-control-solid" placeholder="Description" name="description" cols="30" rows="5" >{{ old('description', $dept->description) }}</textarea>
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
