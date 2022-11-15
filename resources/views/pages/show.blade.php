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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Pages</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                   <!--begin::Item-->
                   <li class="breadcrumb-item text-muted">
                    @if(request()->get('chapter_id'))
                        <a href="{{ route('admin.pages.index', ['chapter_id' => request()->get('chapter_id')]) }}">Page</a>
                    @else
                        <a href="{{ route('admin.pages.index') }}">Page</a>
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
                                    Chapter Name
                                </th>
                                <td>
                                    {{ $page->chapter->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Page Type
                                </th>
                                <td>
                                    {{ config('lms-config.page.page_type.'.$page->page_type) ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Page Content
                                </th>
                                <td>
                                    {{ $page->page_content ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Page Content URL
                                </th>
                                <td>
                                    {{ $page->page_content_url ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Page Sequence
                                </th>
                                <td>
                                    {{ $page->page_sequence ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Is First
                                </th>
                                <td>
                                    {{ $page->is_first ?? 'no' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Is Last
                                </th>
                                <td>
                                    {{ $page->is_last ?? 'no' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Is  Composite
                                </th>
                                <td>
                                    {{ $page->is_composite ?? 'no' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Book Name
                                </th>
                                <td>
                                    {{ $page->chapter->book->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Is Conditional
                                </th>
                                <td>
                                    {{ $page->is_conditional ?? 'no' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Tags
                                </th>
                                <td>
                                    {{ $page->tags ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Status
                                </th>
                                <td>
                                    {{ config('lms-config.page.page_status.'.$page->status) ?? '' }}
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
