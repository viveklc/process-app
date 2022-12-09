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
                            Update Step</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.process.steps.index',$process->id) }}">Steps</a>
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
                                action="{{ route('admin.process.steps.update',['process'=>$process->id,'step'=>$step->id]) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="org_id" value="{{ $process->org_id }}">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Name</span>
                                    </label>
                                    <!--end::Label-->
                                    <input
                                        class="form-control form-control-solid {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                        type="text" name="name" id="name"
                                        value="{{ old('name', $step->name) }}" required>
                                </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Departments</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="form-control form-control-solid select2 {{ $errors->has('dept_id') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="dept_id" id="department_dropdown">
                                        <option value="">Select Department </option>
                                        @forelse ($depts as $item)
                                            <option value="{{$item->id}}" {{ old('dept_id',$item->id) == $step->dept_id ? 'selected' : '' }}>{{$item->name}}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Team</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="form-control form-control-solid select2 {{ $errors->has('team_id') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="team_id" id="team_dropdown" onchange="getProcessByTeamId(this.value)">
                                        <option value="">Select Team</option>
                                        @forelse ($teams as $item)
                                            <option value="{{$item->id}}" {{ old('team_id',$item->id) == $step->team_id ? 'selected' : '' }} >{{$item->name}}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                </div>


                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Sequence</span>
                                    </label>
                                    <!--end::Label-->
                                    <input
                                        class="form-control form-control-solid {{ $errors->has('sequence') ? 'is-invalid' : '' }}"
                                        type="number" name="sequence" id="sequence"
                                        value="{{ old('sequence', $step->sequence) }}" required>
                                </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="">Before Step</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="form-control step form-control-solid select2 {{ $errors->has('before_step_id') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="before_step_id" id="country-dropdown">
                                        <option value="">Select Before Step</option>
                                        @forelse ($process->steps as $item)
                                            <option value="{{$item->id}}" {{ old('before_step_id',$item->id) == $step->before_step_id ? 'selected' : '' }} >{{ $item->name }}</option>
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
                                        class="form-control step form-control-solid select2 {{ $errors->has('after_step_id') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="after_step_id" id="country-dropdown">
                                        <option value="">Select After Step</option>
                                        @forelse ($process->steps as $item)
                                            <option value="{{$item->id}}" {{ old('after_step_id',$item->id) == $step->after_step_id ? 'selected' : '' }} >{{ $item->name }}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                </div>


                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="">Total Duration</span>
                                    </label>
                                    <!--end::Label-->
                                    <input
                                        class="form-control form-control-solid {{ $errors->has('total_duration') ? 'is-invalid' : '' }}"
                                        type="text" name="total_duration" id="total_duration"
                                        value="{{ old('total_duration', $step->total_duration) }}" >
                                </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <input type="hidden" name="is_conditional" id="" value="2">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class=""><input type="checkbox" name="is_conditional" id="is_conditional" value="1" {{ $step->is_conditional == 1 ? 'checked' : '' }}>
                                            &nbsp;&nbsp; Is Conditional</span>
                                    </label>

                                </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <input type="hidden" name="is_substep" id="" value="2">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class=""><input type="checkbox" name="is_substep" id="is_substep" value="1" {{ $step->is_substep == 1 ? 'checked' : '' }} >
                                            &nbsp;&nbsp; Is Sub Step</span>
                                    </label>

                                </div>

                                <div class="d-flex flex-column mb-8 fv-row " id="substepdiv">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="">Sub Step</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="form-control step form-control-solid select2 {{ $errors->has('substep_of_step_id') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="substep_of_step_id" id="country-dropdown">
                                        @forelse ($process->steps as $item)
                                            <option value="{{$item->id}}" {{ old('substep_of_step_id',$item->id) == $step->substep_of_step_id ? 'selected' : '' }} >{{ $item->name }}</option>
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
                                        <span class="">Description</span>
                                    </label>
                                    <!--end::Label-->
                                    <textarea class="form-control form-control-solid {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                        name="description" id="description">{{ old('description', $step->description) }}</textarea>
                                </div>

                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="">Status</span>
                                    </label>
                                    <!--end::Label-->
                                    <select
                                        class="form-control form-control-solid select2 {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                        style="width: 100%;" name="status" id="country-dropdown">
                                        <option value="active" {{ old('status',$step->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="in-active" {{ old('status',$step->status) == 'in-active' ? 'selected' : '' }}>In-active</option>
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


{{--  --}}


    <!--end:::Main-->
@endsection
@section('scripts')
{{--

    <script>

$(document).ready(function(){
    $("#substepdiv").hide();

    $("#is_substep").click(function () {
            if ($(this).is(":checked")) {
                // $("#substepdiv").show();
                // alert('checked');
                // $("#AddPassport").hide();
            } else {
                $("#substepdiv").hide();
                // $("#AddPassport").show();
            }
        });
})

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
</script>
--}}
@endsection
