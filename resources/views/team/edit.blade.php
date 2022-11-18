@extends('layouts.admin')
@section('content')

    @if (Session::has('success'))
        <div class="alert alert-success">{{Session::get('success')}}</div>
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
                            Teams</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.team.index') }}">Teams</a>
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
                            <form id="" class="form" method="POST" action="{{ route('admin.team.update',$team->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="">Organisation</label>
                                        <select name="org_id" id="" class="form-control">
                                            @forelse ($org as $item)
                                                <option value="{{ $item->id }}" {{ ($item->org_id == $team->org_id)?'selected':'' }}>{{ $item->name }}</option>
                                            @empty
                                                <option value="">No Org</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Team Name</label>
                                        <input type="text" name="team_name" class="form-control"
                                            value="{{ $team->team_name }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="">Description</label>
                                        <textarea name="team_description" class="form-control">{{ $team->team_description }}</textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Remarks</label>
                                        <textarea name="team_remarks" class="form-control">{{ $team->team_remarks }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="">Valid From</label>
                                        <input type="date" name="valid_from" class="form-control" value="{{ $team->valid_from }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Valid To</label>
                                        <input type="date" name="valid_to" class="form-control" value="{{ $team->valid_to }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="">Team User</label>
                                        {{-- <select name="user[]" id="users" class="form-control">

                                </select> --}}
                                        <select id="example-getting-started" name="user_id[]" class="form-control"
                                            multiple="multiple">
                                            @forelse ($users as $item)
                                                <option value="{{ $item->id }}" {{ in_array($item->id,$teamuserId)?'selected':'' }}>{{ $item->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group col-md-12 text-center">
                                        <label for=""></label>
                                        <button type="submit" id="kt_modal_new_ticket_submit" class="btn btn-primary">
                                            <span class="indicator-label"> {{ trans('global.save') }}</span>
                                        </button>
                                    </div>
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
<script>
    $(document).ready(function() {
        $('#example-getting-started').multiselect();


    });
</script>
