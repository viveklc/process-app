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
                            Teams</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.classes.index') }}">Teams</a>
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
                        <a href="{{ route('admin.teams.create') }}"
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
                                            <th width="10">#</th>
                                            <th>Team Name</th>
                                            <th>Organisation</th>
                                            <th>Valid From</th>
                                            <th>Valid To</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($teams as $i=>$item)
                                        <tr>
                                            <td></td>
                                            <td>{{$item->team_name}}</td>
                                            <td>{{ $item->org_name }}</td>
                                            <td>{{ $item->valid_from }}</td>
                                            <td>{{ $item->valid_to }}</td>
                                            <td>
                                                <a href="{{ route('admin.team.user.index',$item->id) }}" title="Team Users" class="btn-link"><i
                                                        class="fa fa-users"></i></a>&nbsp;&nbsp;
                                                <a href="{{ route('admin.team.edit',$item->id) }}" title="Edit Team" class="btn-link"><i
                                                        class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                                <a href="#" title="View Team" class="btn-link"><i
                                                        class="fa fa-eye"></i></a>&nbsp;&nbsp;
                                                <a href="#" title="Delete Team" class="btn-link"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr align="center">
                                                <td>No Team Found</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>

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
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            @can('delete-country')
                let deleteButtonTrans = '{{ trans('global.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.subjects.massDestroy') }}",
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
                    @if ($teams->count())
                        info: '{{ trans('global.grid_pagination_count_status', [
                            'firstItem' => $teams->firstItem(),
                            'lastItem' => $teams->lastItem(),
                            'total' => $teams->total(),
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

                    window.location.href = '{{ route('admin.subjects.index') }}' + generateQueryString(
                        requestParameters);
                } else {
                    table.search(this.value).draw();
                }
            });
        })
    </script>
@endsection
