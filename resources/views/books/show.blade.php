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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Books</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                   <!--begin::Item-->
                   <li class="breadcrumb-item text-muted">
                        @if(request()->get('subject_id'))
                            <a href="{{ route('admin.books.index', ['subject_id' => request()->get('subject_id')]) }}">Book</a>
                        @else
                            <a href="{{ route('admin.books.index') }}">Book</a>
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
                                    {{ $book->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Short Descrition
                                </th>
                                <td>
                                    {{ $book->short_description ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Long Descrition
                                </th>
                                <td>
                                    {{ $book->long_description ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Front Cover Image
                                </th>
                                <td>
                                    @if($book->getFirstMediaUrl('BookFrontCover'))
                                    <a href="{{ $book->getFirstMediaUrl('BookFrontCover') }}" target="_BLANK">
                                        <img src="{{ $book->getFirstMediaUrl('BookFrontCover', 'thumb') }}" />
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Back Cover Image
                                </th>
                                <td>
                                    @if($book->getFirstMediaUrl('BookBackCover'))
                                    <a href="{{ $book->getFirstMediaUrl('BookBackCover') }}" target="_BLANK">
                                        <img src="{{ $book->getFirstMediaUrl('BookBackCover', 'thumb') }}" />
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Course Name
                                </th>
                                <td>
                                    {{ $book->course->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                   Level Name
                                </th>
                                <td>
                                    {{ $book->level->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Subject Name
                                </th>
                                <td>
                                    {{ $book->subject->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Tags
                                </th>
                                <td>
                                    {{ $book->tags ?? '' }}
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
