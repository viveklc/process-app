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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Chapters</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                   <!--begin::Item-->
                   <li class="breadcrumb-item text-muted">
                        @if(request()->get('book_id'))
                            <a href="{{ route('admin.chapters.index', ['book_id' => request()->get('book_id')]) }}">Chapter</a>
                        @else
                            <a href="{{ route('admin.chapters.index') }}">Chapter</a>
                        @endif
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
                                    {{ $chapter->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Short Descrition
                                </th>
                                <td>
                                    {{ $chapter->short_description ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Long Descrition
                                </th>
                                <td>
                                    {{ $chapter->long_description ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Image
                                </th>
                                <td>
                                    @if($chapter->getFirstMediaUrl('Chapter'))
                                    <a href="{{ $chapter->getFirstMediaUrl('Chapter') }}" target="_BLANK">
                                        <img src="{{ $chapter->getFirstMediaUrl('Chapter', 'thumb') }}" />
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Course Name
                                </th>
                                <td>
                                    {{ $chapter->course->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                   Level Name
                                </th>
                                <td>
                                    {{ $chapter->level->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Subject Name
                                </th>
                                <td>
                                    {{ $chapter->subject->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Book Name
                                </th>
                                <td>
                                    {{ $chapter->book->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Sequence
                                </th>
                                <td>
                                    {{ $chapter->sequence ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Tags
                                </th>
                                <td>
                                    {{ $chapter->tags ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Status
                                </th>
                                <td>
                                    {{ config('lms-config.chapter.chapter_status.' . $chapter->status) ?? '' }}
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
