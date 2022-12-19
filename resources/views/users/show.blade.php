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
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Users
                        </h1>
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
                            {{-- <h3>Basic Information</h3> --}}
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>
                                            Name
                                        </th>
                                        <td>
                                            {{ $user->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Organisation
                                        </th>
                                        <td>
                                            {{ $user->org->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Username
                                        </th>
                                        <td>
                                            {{ $user->username }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Email
                                        </th>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Mobile
                                        </th>
                                        <td>
                                            {{ $user->phone ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Role
                                        </th>
                                        <td>
                                            {{ $user->role->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Is Organisatin Admin
                                        </th>
                                        <td>
                                            {{ $user->is_org_admin == 1 ? 'Yes' : 'No' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Collegues
                                        </th>
                                        <td>
                                            @php
                                                $collegues = collect($user->collegues)
                                                    ->pluck('name')
                                                    ->toArray();
                                            @endphp
                                            {{ implode(",",$collegues) ?? '' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Reports To
                                        </th>
                                        <td>
                                            @php
                                                $reportToUsers = collect($user->reportToUsers)
                                                    ->pluck('name')
                                                    ->toArray();
                                            @endphp
                                            {{ implode(",",$reportToUsers) ?? '' }}
                                        </td>
                                    </tr>


                                </tbody>

                            </table>

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
