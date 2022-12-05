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
                            Process Instances</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.processes.process-instance.index',$process->id) }}">Process Instances</a>
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
                            <form id="kt_subscriptions_export_form" class="form" method="POST"
                            action="{{ route('admin.processes.process-instance.store',$process->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Instance Name</span>
                                </label>
                                <!--end::Label-->
                                <input
                                    class="form-control form-control-solid {{ $errors->has('process_instance_name') ? 'is-invalid' : '' }}"
                                    type="text" name="process_instance_name" id="process_instance_name"
                                    value="{{ old('process_instance_name', $process->process_name) }}" required>
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Assigned To Team</span>
                                </label>
                                <!--end::Label-->
                                <select
                                    class="form-control form-control-solid select2 {{ $errors->has('team_id') ? 'is-invalid' : '' }}"
                                    style="width: 100%;" name="team_id" id="country-dropdown" >
                                    <option value="">--select team --</option>
                                    @forelse ($team as $item)
                                        <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Assigned To User</span>
                                </label>
                                <!--end::Label-->
                                <select
                                    class="form-control form-control-solid select2 {{ $errors->has('assigned_to_user_id') ? 'is-invalid' : '' }}"
                                    style="width: 100%;" name="assigned_to_user_id" id="country-dropdown" >
                                    <option value="">--select user --</option>
                                    @forelse ($users as $item)
                                        <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Start Date</span>
                                </label>
                                <!--end::Label-->
                                <input
                                    class="form-control form-control-solid {{ $errors->has('start_date') ? 'is-invalid' : '' }}"
                                    type="datetime-local" name="start_date" id="start_date"
                                    value="{{ old('start_date', '') }}" onchange="setDueDate(this.value)">
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Due Date</span>
                                </label>
                                <!--end::Label-->
                                <input
                                    class="form-control form-control-solid {{ $errors->has('due_date') ? 'is-invalid' : '' }}"
                                    type="datetime-local" name="due_date" id="due_date" value="{{ old('due_date', '') }}">
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
    function setDueDate(start_date){
        let date = new Date(start_date);
        date.setSeconds(date.getSeconds() + "{{ $process->total_duration }}")
        $("#due_date").val(date.toISOString().slice(0,16))
    }
</script>
@endsection
