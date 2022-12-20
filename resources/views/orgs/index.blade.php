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
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Organisations</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.orgs.index') }}">Organisations</a>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">List</li>
                            <!--end::Item-->
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page title-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <!--begin::Secondary button-->
                        <!--end::Secondary button-->
                        <!--begin::Primary button-->
                        <a href="{{ route('admin.orgs.create') }}"
                            class="btn btn-sm fw-bold btn-primary">{{ trans('global.add') }}</a>
                        <!--end::Primary button-->
                    </div>
                    <!--end::Actions-->
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
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-6"
                            style="display: flex;
                                flex-wrap: wrap;
                                justify-content: end;
                                margin: 0;">
                            <!--begin::Card title-->
                            <div class="">
                                <input type="text" class="form-control form-control-sm"
                                    style="float: right; width: 300px;" name="dataTableSearch" id="dataTableSearch"
                                    value="{{ request()->input('s') }}" placeholder="Type and search in table" />
                                <a href="javascript:;" id="dtToggleActionBtns"
                                    style="float: right; margin-right: 20px; margin-top: 5px;"
                                    onclick="toggleGridOptions()"><i class="fa-fw nav-icon fas fa-cogs"></i></a>
                            </div>
                            <!--begin::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table-->
                            <div class="table-responsive">
                                <table class="table table-bordered datatable datatable-Cities">
                                    <thead>
                                        <tr>
                                            <th width="10">
                                            </th>
                                            <th>
                                                Name
                                            </th>
                                            <th>
                                                Plan Type
                                            </th>
                                            <th>
                                                Address
                                            </th>

                                            <th style="text-align: center">
                                                Is Premium
                                            </th>
                                            <th class="notexport">
                                                &nbsp;
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($orgs as $org)
                                        <tr data-entry-id="{{ $org->id }}">
                                            <td>
                                            </td>
                                            <td>
                                                {{ $org->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $org->plan->plan_name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $org->address ?? '' }}
                                            </td>

                                            <td style="text-align: center">
                                                {{ ($org->is_premium == 1 ? 'Yes':'No') ?? '' }}
                                            </td>
                                    <!--begin::Action=-->
                                    <td class="text-end">
                                        <a href="#" class="btn  btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon--></a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="{{ route('admin.orgs.edit', $org->id) }}" class="menu-link px-3">                                {{ trans('global.edit') }}
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="{{ route('admin.orgs.show', $org->id) }}" class="menu-link px-3">                                {{ trans('global.view') }}</a>
                                            </div>
                                            <!--end::Menu item-->

                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <form action="{{ route('admin.orgs.destroy', $org->id) }}" method="POST" id="frmDeleteCountry-{{ $org->id }}" style="display: inline-block; width: 100%;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <a href="#"  class="menu-link px-3" onclick="deleteGridRecord('frmDeleteCountry-{{ $org->id }}')">
                                                {{ trans('global.delete') }}
                                                </a>
                                            </form>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                    <!--end::Action=-->
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                                @if ($orgs->count())
                                    {{ $orgs->links() }}
                                @endif
                            </div>
                            <!--end::Table-->
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
    @parent
    <script>
        var table;
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

            @can('delete-org')
                let deleteButtonTrans = '{{ trans('global.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.orgs.massDestroy') }}",
                    className: 'btn btn-sm btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            Swal.fire(
                                '{{ trans('global.message') }}!',
                                '{{ trans('global.grid.no_item_selected') }}',
                            )
                            return
                        }

                        Swal.fire({
                            title: '{{ trans('global.are_you_sure') }}',
                            text: '{{ trans('global.are_you_sure_delete_msg') }}',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                        headers: {
                                            'x-csrf-token': _token
                                        },
                                        method: 'POST',
                                        url: config.url,
                                        data: {
                                            ids: ids,
                                            _method: 'DELETE'
                                        }
                                    })
                                    .done(function() {
                                        Swal.fire(
                                            '{{ trans('global.delete') }}!',
                                            '{{ trans('global.success') }}'
                                        );

                                        location.reload()
                                    })
                            }
                        })
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                paging: false,
                language: {
                    infoEmpty: "{{ trans('global.grid_no_data') }}",
                    @if ($orgs->count())
                        info: '{{ trans('global.grid_pagination_count_status', [
                            'firstItem' => $orgs->firstItem(),
                            'lastItem' => $orgs->lastItem(),
                            'total' => $orgs->total(),
                        ]) }}',
                    @endif
                },
            });

            table = $('.datatable-Cities:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });

            // datatable search functionality
            $('#dtToggleActionBtns').tooltip({
                'trigger': 'hover',
                'title': '{{ trans('global.grid.toggle_action_buttons_tooltip') }}'
            });
            $('#dataTableSearch').tooltip({
                'trigger': 'focus',
                'title': '{{ trans('global.grid.search_tooltip') }}'
            });

            $('#dataTableSearch').on('keyup', function(e) {
                if (e.which == 13) { // if user press enter in search text input
                    let requestParameters = [];

                    let searchText = $('#dataTableSearch').val();
                    if ($.trim(searchText) != '') {
                        requestParameters.push('s=' + $.trim(searchText));
                    }

                    window.location.href = '{{ route('admin.orgs.index') }}' + generateQueryString(
                        requestParameters);
                } else {
                    table.search(this.value).draw();
                }
            });
        })
    </script>
@endsection
