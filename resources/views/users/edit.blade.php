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
                            Update User</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.users.index') }}">Users</a>
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
                                action="{{ route('admin.users.update',$user->id) }}" enctype="multipart/form-data">
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
                                        style="width: 100%;" name="org_id" id="country-dropdown" onchange="fetchUsers(this.value)">
                                        <option value="">Select Organisation</option>
                                        @forelse ($org as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('org_id',$user->org_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}
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
                                        class="form-control form-control-solid {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                        type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                                </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Username</span>
                                    </label>
                                    <!--end::Label-->
                                    <input
                                        class="form-control form-control-solid {{ $errors->has('username') ? 'is-invalid' : '' }}"
                                        type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                                        required>
                                </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Email</span>
                                    </label>
                                    <!--end::Label-->
                                    <input
                                        class="form-control form-control-solid {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                        type="text" name="email" id="email" value="{{ old('email', $user->email) }}"
                                        required>
                                </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Mobile</span>
                                    </label>
                                    <!--end::Label-->
                                    <input
                                        class="form-control form-control-solid {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                        type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                                        required>
                                </div>
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Role</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="form-control form-control-solid select2 {{ $errors->has('role_id') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="role_id" id="country-dropdown">
                                        <option value="">Select Role</option>
                                        @forelse ($role as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('role_id', $user->role_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class=""><input type="checkbox" name="is_org_admin" id="" {{ old('is_org_admin',$user->is_org_admin) == 1 ? 'checked':'' }}>
                                            &nbsp;&nbsp; Is Organisation admin</span>
                                    </label>

                                </div>


                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="">Collegues</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="form-control form-control-solid select2 {{ $errors->has('is_colleague_of_user_id') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="is_colleague_of_user_id[]" id="is_collegue" multiple>
                                        @forelse ($users as $item)
                                            <option value="{{ $item->id }}"  {{ in_array($item->id,$colleguesId) ? 'selected' : '' }} >{{ $item->name }}</option>
                                        @empty

                                        @endforelse

                                    </select>
                                </div>


                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="">Reports To</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="form-control form-control-solid select2 {{ $errors->has('reports_to_user_id') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="reports_to_user_id[]" id="reports_to_user_id" multiple>
                                        @forelse ($users as $item)
                                            <option value="{{ $item->id }}"  {{ in_array($item->id,$reportToUsersId) ? 'selected' : '' }} >{{ $item->name }}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                </div>

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
        // $(document).ready(function(){
        //     fetchUsers({{ $user->org_id }});
        // });

        function fetchUsers(org_id){
            let url = '{{ route('admin.org.users',':org_id') }}';

            url = url.replace(':org_id',org_id);

            $.ajax({
                method : "GET",
                url : url,
                cache : false,
                beforeSend : function(){

                },
                success : function(response){
                    var option1 = "";
                    var option2 = "";
                    $.each(response, function(index,value){

                        option1 += "<option value='"+value.id+"' >"+value.name+"</option>";
                        option2 += "<option value='"+value.id+"' >"+value.name+"</option>";

                    });
                    $('#is_collegue').html(option1);
                    $("#reports_to_user_id").html(option2);
                }
            })
        }
    </script>

@endsection
