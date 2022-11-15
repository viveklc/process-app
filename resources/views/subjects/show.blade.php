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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Departments</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                   <!--begin::Item-->
                   <li class="breadcrumb-item text-muted">
                      <a href="{{ route('admin.subjects.index') }}">Subject</a>
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
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    Name
                                </th>
                                <td>
                                    {{ $subject->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                   Short Description
                                </th>
                                <td>
                                    {!! $subject->short_description ?? '' !!}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Long Description
                                </th>
                                <td>
                                    {!! $subject->long_description ?? '' !!}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Course
                                </th>
                                <td>
                                    @isset($subject->course)
                                        {{ $subject->course->name ?? '' }}
                                    @endisset
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Level
                                </th>
                                <td>
                                    @isset($subject->level)
                                        {{ $subject->level->name ?? '' }}
                                    @endisset
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Tags
                                </th>
                                <td>
                                    @isset($subject->tags)
                                        {{ $subject->tag_data ?? '' }}
                                    @endisset
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Image URL
                                </th>
                                <td>
                                    @if($subject->getFirstMediaUrl('Subject'))
                                        <a href="{{ $subject->getFirstMediaUrl('Subject') }}" target="_BLANK">
                                            <img src="{{ $subject->getFirstMediaUrl('Subject', 'thumb') }}" />
                                        </a>
                                    @endif
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
