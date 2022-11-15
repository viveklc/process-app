<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" --}}
{{-- integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
      </script> --}}
<script>
    var hostUrl = "";
</script>
<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('js/scripts.bundle.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{ asset('js/custom/apps/subscriptions/list/export.js') }}"></script>
<script src="{{ asset('js/custom/apps/subscriptions/list/list.js') }}"></script>
<script src="{{ asset('js/custom/widgets.js') }}"></script>
<script src="{{ asset('js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('js/custom/modals/create-app.js') }}"></script>
<script src="{{ asset('js/custom/modals/upgrade-plan.js') }}"></script>
<!--end::Page Custom Javascript-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
    integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js"
    integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
 <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script> --}}
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function() {
        let copyButtonTrans = '{{ trans('global.grid.copy') }}'
        let csvButtonTrans = '{{ trans('global.grid.csv') }}'
        let excelButtonTrans = '{{ trans('global.grid.excel') }}'
        let pdfButtonTrans = '{{ trans('global.grid.pdf') }}'
        let printButtonTrans = '{{ trans('global.grid.print') }}'
        let colvisButtonTrans = '{{ trans('global.grid.colvis') }}'
        let selectAllButtonTrans = '{{ trans('global.select_all') }}'
        let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

        let languages = {
            'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
        };

        $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {
            className: 'btn'
        })

        $.extend(true, $.fn.dataTable.defaults, {
            /* language: {
                url: languages['{{ app()->getLocale() }}'],
            }, */
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }, {
                orderable: false,
                searchable: false,
                targets: -1
            }],
            select: {
                style: 'multi+shift',
                selector: 'td:first-child'
            },
            order: [],
            scrollX: true,
            pageLength: 100,
            dom: 'lBfrtip<"actions">',
            buttons: [{
                    extend: 'selectAll',
                    className: 'btn btn-sm btn-primary mr-5',
                    text: selectAllButtonTrans,
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(.notexport)'
                    },
                    action: function(e, dt) {
                        e.preventDefault()
                        dt.rows().deselect();
                        dt.rows({
                            search: 'applied'
                        }).select();
                    }
                },
                {
                    extend: 'selectNone',
                    className: 'btn btn-sm btn-primary btn-non-select',
                    text: selectNoneButtonTrans,
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(.notexport)'
                    }
                },
                {
                    extend: 'copy',
                    className: 'btn btn-sm btn-default',
                    text: copyButtonTrans,
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(.notexport)'
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn btn-sm btn-default',
                    text: csvButtonTrans,
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(.notexport)'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn btn-sm btn-default',
                    text: excelButtonTrans,
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(.notexport)'
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-sm btn-default',
                    text: pdfButtonTrans,
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(.notexport)'
                    }
                },
                {
                    extend: 'print',
                    className: 'btn btn-sm btn-default',
                    text: printButtonTrans,
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(.notexport)'
                    }
                },
                {
                    extend: 'colvis',
                    className: 'btn btn-sm btn-default',
                    text: colvisButtonTrans,
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(.notexport)'
                    }
                }
            ]
        });

        $.fn.dataTable.ext.classes.sPageButton = '';
    });
</script>
<script>
    function deleteGridRecord(frmId) {
        Swal.fire({
            title: '{{ trans('global.are_you_sure') }}',
            text: "{{ trans('global.are_you_sure_delete_msg') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{ trans('global.ok') }}'
        }).then((result) => {

            if (result.isConfirmed) {
                $("#" + frmId).submit();
            }
        })
    }

    function toggleGridOptions() {
        $('.dt-buttons').slideToggle();
        $('.dataTables_length').slideToggle();
    }

    /*Country Dropdown Change Event*/

    $('#country-dropdown').on('change', function () {
        var idCountry = this.value;
        $("#state-dropdown").html('');
        $.ajax({
            url: "{{route('admin.states')}}",
            type: "POST",
            data: {
                country_id: idCountry,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                $('#state-dropdown').html('<option value="">Select State</option>');
                $.each(result.states, function (key, value) {
                    $("#state-dropdown").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
                $('#city-dropdown').html('<option value="">Select City</option>');
            }
        });
    });

    /* State Dropdown Change Event */

    $('#state-dropdown').on('change', function () {
        var idState = this.value;
        $("#city-dropdown").html('');
        $.ajax({
            url: "{{route('admin.cities')}}",
            type: "POST",
            data: {
                state_id: idState,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (res) {
                $('#city-dropdown').html('<option value="">Select City</option>');
                $.each(res.cities, function (key, value) {
                    $("#city-dropdown").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    });
</script>

<script>
    // instance, using default configurations.
    CKEDITOR.replace( 'long_description', {
        toolbar: [
            [ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ],
            [ 'FontSize', 'TextColor' ]
        ]
    });
</script>
@include('sweetalert::alert')
