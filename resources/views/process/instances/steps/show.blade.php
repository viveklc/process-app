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
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Step Instances
                        </h1>
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
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.processes.process-instance.index',$processInstance->process_id) }}">Process Instances</a>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.process-instance.step-instance.index',$processInstance->id) }}">Step Instances</a>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">Show</li>
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
                        <div class="card-body pt-10">
                            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Basic Information</h1>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>
                                            Step instance name
                                        </th>
                                        <td>
                                            {{ $stepInstance->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Description
                                        </th>
                                        <td>
                                            {{ $stepInstance->description ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Organization
                                        </th>
                                        <td>
                                            {{ $stepInstance->org->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Department
                                        </th>
                                        <td>
                                            {{ $stepInstance->dept->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Team
                                        </th>
                                        <td>
                                            {{ $stepInstance->team->team_name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Process
                                        </th>
                                        <td>
                                            {{ $stepInstance->process->process_name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Sequence
                                        </th>
                                        <td>
                                            {{ $stepInstance->sequence }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Total Duration
                                        </th>
                                        <td>
                                            {{ $stepInstance->planned_total_duration ?? ''}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Before Step
                                        </th>
                                        <td>
                                            {{ $stepInstance->beforeStep->name ?? '' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            After Step
                                        </th>
                                        <td>
                                            {{ $stepInstance->afterStep->name ?? ''}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Planned Start On
                                        </th>
                                        <td>
                                            {{ appDateFormat($stepInstance->planned_start_on) ?? ''}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Planned Finish On
                                        </th>
                                        <td>
                                            {{ appDateFormat($stepInstance->planned_finish_on) ?? ''}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Actual Start On
                                        </th>
                                        <td>
                                            {{ appDateFormat($stepInstance->actual_start_on) ?? ''}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Actual Finish On
                                        </th>
                                        <td>
                                            {{ appDateFormat($stepInstance->actual_finish_on) ?? ''}}
                                        </td>
                                    </tr>

                                </tbody>

                            </table>
                            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Attachments : </h1>
                            <ul class="list-group">

                                @forelse ($stepInstance->media as $item)
                                <li class="list-group-item"> <a href="{{ $item->original_url }}"
                                    target="__blank">{{ $item->original_url }}</a> </li>
                                @empty
                                   <li class="list-group-item">No attachment found</li>
                                @endforelse



                            </ul>
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
