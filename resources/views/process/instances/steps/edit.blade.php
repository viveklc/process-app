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
                            Update Step Instance</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.process-instance.step-instance.index',$processInstanceId) }}">Step Instances</a>
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
                                action="{{ route('admin.process-instance.step-instance.update',['process_instance'=>$processInstanceId,'step_instance'=>$stepInstance->id]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Name</span>
                                    </label>
                                    <!--end::Label-->
                                    <input
                                        class="form-control form-control-solid {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                        type="text" name="name" id="name"
                                        value="{{ old('name', $stepInstance->name) }}" required>
                                </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="">Sequence</span>
                                    </label>
                                    <!--end::Label-->
                                    <input
                                        class="form-control form-control-solid {{ $errors->has('total_duration') ? 'is-invalid' : '' }}"
                                        type="number" name="sequence" id="sequence"
                                        value="{{ old('sequence',$stepInstance->sequence) }}" >
                                </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="">Before Step</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="form-control form-control-solid select2 step {{ $errors->has('before_step_instance_id') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="before_step_instance_id" id="country-dropdown">
                                        <option value="">-- select step --</option>
                                        @forelse ($processSteps as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('before_step_instance_id',$stepInstance->before_step_instance_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="">After Step</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="form-control form-control-solid select2 step {{ $errors->has('after_step_instance_id') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="after_step_instance_id" id="country-dropdown">
                                        <option value="">-- select step --</option>
                                        @forelse ($processSteps as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('after_step_instance_id',$stepInstance->after_step_instance_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                {{-- <div class="d-flex flex-column mb-8 fv-row">
                                    <input type="hidden" name="is_conditional" id="" value="2">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class=""><input type="checkbox" name="is_conditional" id="is_conditional" value="1" {{ $stepInstance->is_conditional == 1 ? 'checked' : '' }}  >
                                            &nbsp;&nbsp; Is Conditional</span>
                                    </label>

                                </div> --}}

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <input type="hidden" name="is_substep" id="" value="2">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class=""><input type="checkbox" name="is_substep" id="is_substep" value="1" {{ $stepInstance->is_substep == 1 ? 'checked' : '' }} >
                                            &nbsp;&nbsp; Is Sub Step</span>
                                    </label>

                                </div>

                                <div class="d-flex flex-column mb-8 fv-row substepdiv">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="">Sub Step</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="form-control form-control-solid select2 step {{ $errors->has('substep_of_step_id') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="substep_of_step_id" id="country-dropdown">
                                        <option value="">-- select step --</option>
                                        @forelse ($processSteps as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('substep_of_step_id',$stepInstance->substep_of_step_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>


                                 <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="">Attachment</span>
                                </label>
                                <!--end::Label-->
                                <input type="file"
                                    class="form-control form-control-solid  {{ $errors->has('attachments') ? 'is-invalid' : '' }}"
                                    placeholder="Attachment" name="attachments[]" multiple  />
                            </div>
                            <!--end::Input group-->

                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="">Planned Start Date</span>
                                </label>
                                <!--end::Label-->
                                <input
                                    class="form-control form-control-solid {{ $errors->has('planned_start_on') ? 'is-invalid' : '' }}"
                                    type="date" name="planned_start_on" id="planned_start_on"
                                    value="{{ old('planned_start_on', dbDateFormat($stepInstance->planned_start_on)) }}" >
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="">Planned Finish Date</span>
                                </label>
                                <!--end::Label-->
                                <input
                                    class="form-control form-control-solid {{ $errors->has('planned_finish_on') ? 'is-invalid' : '' }}"
                                    type="date" name="planned_finish_on" id="planned_finish_on"
                                    value="{{ old('planned_finish_on', dbDateFormat($stepInstance->planned_finish_on))  }}" >
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="">Actual Start Date</span>
                                </label>
                                <!--end::Label-->
                                <input
                                    class="form-control form-control-solid {{ $errors->has('actual_start_on') ? 'is-invalid' : '' }}"
                                    type="date" name="actual_start_on" id="actual_start_on"
                                    value="{{ old('actual_start_on', dbDateFormat($stepInstance->actual_start_on) ) }}" >
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="">Actual Finish Date</span>
                                </label>
                                <!--end::Label-->
                                <input
                                    class="form-control form-control-solid {{ $errors->has('actual_finish_on') ? 'is-invalid' : '' }}"
                                    type="date" name="actual_finish_on" id="actual_finish_on"
                                    value="{{ old('actual_finish_on', dbDateFormat($stepInstance->actual_finish_on) ) }}" >
                            </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="">Description</span>
                                    </label>
                                    <!--end::Label-->
                                    <textarea class="form-control form-control-solid {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                        name="description" id="description">{{ old('description', $stepInstance->description) }}</textarea>
                                </div>

                                {{-- <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="">Status</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="form-control form-control-solid select2 {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="status" id="country-dropdown">
                                        <option value="active" {{ $stepInstance->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="in-active" {{ $stepInstance->status == 'in-active' ? 'selected' : '' }} >In-active</option>
                                    </select>
                                </div> --}}



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
{{-- <script>

    function mountDropDown(org_id){
        getDeptsByOrgId(org_id)
        getTeamsByOrgId(org_id)
    }
    function getDeptsByOrgId(org_id){
            let url = '{{ route('admin.org.depts',':org_id') }}';

            url = url.replace(':org_id',org_id);

            $.ajax({
                method : "GET",
                url : url,
                cache : false,
                beforeSend : function(){

                },
                success : function(response){
                    // console.log(response);
                    var option = "<option value=''>select Departments</option>";
                    $.each(response, function(index,value){

                        option += "<option value='"+value.id+"'>"+value.name+"</option>";

                    });
                    $('#department_dropdown').html(option);

                }
            })
    }

    function getTeamsByOrgId(org_id){
        let url = '{{ route('admin.org.teams',':org_id') }}';

            url = url.replace(':org_id',org_id);

            $.ajax({
                method : "GET",
                url : url,
                cache : false,
                beforeSend : function(){

                },
                success : function(response){
                    // console.log(response);
                    var option = "<option value=''>select Team</option>";
                    $.each(response, function(index,value){

                        option += "<option value='"+value.id+"'>"+value.name+"</option>";

                    });
                    $('#team_dropdown').html(option);

                }
            })
    }

    function getProcessByTeamId(team_id){
        let url = '{{ route('admin.team.process',':team_id') }}';

            url = url.replace(':team_id',team_id);

            $.ajax({
                method : "GET",
                url : url,
                cache : false,
                beforeSend : function(){

                },
                success : function(response){
                    var option = "<option value=''>select process</option>";
                    $.each(response.team_process, function(index,value){

                        option += "<option value='"+value.id+"'>"+value.process_name+"</option>";

                    });
                    $('#process_dropdown').html(option);

                }
            })
    }

    function fetchSteps(process_id){
        let url = '{{ route('admin.process.step',':process_id') }}';

            url = url.replace(':process_id',process_id);

            $.ajax({
                method : "GET",
                url : url,
                cache : false,
                beforeSend : function(){

                },
                success : function(response){
                    var option = "<option value=''>select Step</option>";
                    $.each(response, function(index,value){

                        option += "<option value='"+value.id+"'>"+value.name+"</option>";

                    });
                    $('.step').html(option);

                }
            })
    }
</script> --}}
@endsection
