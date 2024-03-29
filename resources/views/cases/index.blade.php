@extends('../layouts.master')
@section('title')
    IMS - Attributes
@endsection
@section('page_title')
    Attribute Manager
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
@endsection
@section('content')
    <div class="main-content">
        <div class="panel">
            <div class="panel-heading border">
                <ol class="breadcrumb mb0 no-padding">
                    <li>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="active">Cases</li>
                </ol>
            </div>
            <div class="panel-body">
                <div class="container-fluid">
                    <a href="{{ url('admin/cases/create') }}" class="btn btn-info mb15 ml15"
                       style="float: right; margin-bottom: 20px;"><i class="fa fa-plus"></i> Create new</a>
                </div>
                <table class="table table-bordered bordered table-striped table-condensed datatable" id="cases">
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @endsection
        @push('jsfiles')
            <script type="text/javascript">
                $(document).ready(function () {
                    oTable = $('.datatable').dataTable({
                        processing: true,
                        serverSide: true,
                        buttons: [],
                        "dom": '<"top"l>rt<"bottom"ip><"clear">',
                        ajax: {
                            url: "{{ url('/api/cases/serverside') }}",
                            data: function (d) {
                                d.channel = $('#channel_id').val();
                                d.group = $('#group').val();

                            }
                        },
                        dataSrc: "data.data",
                        pageLength: 20,
                        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
                        //order: [[8, 'desc']],
                        columns: [
                            {
                                title: '#', data: 'DT_RowIndex', name: 'DT_RowIndex', width: "2%",
                                "searchable": false,
                                "orderable": false
                            },
                            {
                                title: 'Case Number',
                                data: 'case_number',
                                name: 'case_number',
                                width: "7%",
                                render: function (data, type, full, meta) {
                                    if (full['case_number'] == null) {
                                        return "N/A";
                                    }
                                    else {
                                        return $.camelCase(full['case_number']);
                                    }
                                },
                                "searchable": true,
                                "orderable": true
                            },
                            {
                                title: 'Client Name',
                                data: 'client.name',
                                name: 'client.name',
                                width: "7%",
                                render: function (data, type, full, meta) {
                                    if (full['client'] == null) {
                                        return "N/A";
                                    }
                                    else {
                                        return $.camelCase(full['client'].name);
                                    }
                                },
                                "searchable": true,
                                "orderable": true
                            },
                            {
                                title: 'Opponent Name',
                                data: 'opponent_name',
                                name: 'opponent_name',
                                width: "7%",
                                render: function (data, type, full, meta) {
                                    if (full['opponent_name'] == null) {
                                        return "N/A";
                                    }
                                    else {
                                        return $.camelCase(full['opponent_name']);
                                    }
                                },
                                "searchable": true,
                                "orderable": true
                            },
                            {
                                title: 'Date Of Filing',
                                data: 'date_of_filing',
                                name: 'date_of_filing',
                                width: "7%",
                                render: function (data, type, full, meta) {
                                    if (full['date_of_filing'] == null) {
                                        return "N/A";
                                    }
                                    else {
                                        return moment(full['date_of_filing']).format('DD-MM-YYYY');
                                    }
                                },
                                "searchable": true,
                                "orderable": true
                            },
                            {
                                title: 'Court',
                                data: 'court',
                                name: 'court',
                                width: "6%",
                                render: function (data, type, full, meta) {
                                    if (full['court'] == null) {
                                        return "N/A";
                                    }
                                    else {
                                        return $.camelCase(full['court']);
                                    }
                                },
                                "searchable": true,
                                "orderable": true
                            },
                            {
                                title: 'Stage',
                                data: 'stage',
                                name: 'stage',
                                width: "10%",
                                render: function (data, type, full, meta) {
                                    if (full['stage'] == null) {
                                        return "N/A";
                                    }
                                    else {
                                        var stage = full['stage'].toLowerCase();
                                        var stag = stage.split(' ').join('_');
                                        return '<span class="' + stag + '">' + full['stage'] + '</span>';
                                    }
                                },
                                "searchable": true,
                                "orderable": true
                            },
                            {
                                title: 'Action',
                                data: '',
                                name: '',
                                width: "7%",
                                render: function (data, type, full, meta) {

                                    var url = "{{url('admin/cases/view')}}/" + full['id'];
                                    var urlEdit = "{{url('admin/cases/update')}}/" + full['id'];
                                    return '<a href="' + url + '"><i class="fa fa-eye" title="View case"></i></a> ' +
                                        ' <a href="' + urlEdit + '"><i class="fa fa-pencil" title="Edit case"></i></a>' +
                                        ' <a href="javascript:;"><i class="fa fa-trash swal-warning-cancel" data-id="' + full['id'] + '" title="Delete attribute"></i></a>'

                                },
                                "searchable": false,
                                "orderable": false
                            }
                        ],
                        "initComplete": function () {
                            var r = $('#cases tfoot tr');
                            $('#cases thead').append(r);
                            this.api().columns().every(function (i) {
                                var column = this;
                                if (i == 6) {
                                    var select = $('<select><option value="..."> Select All</option><option value="true">Accepted</option><option value="false">Rejected</option></select>')
                                        .appendTo($(column.footer()).empty())
                                        .on('change', function () {
                                            var val = $(this).val();

                                            column.search(val, true, false)
                                                .draw(true);
                                        });

                                    column.data().unique().sort().each(function (d, j) {
                                        select.append('<option value="' + d + '">' + d + '</option>')
                                    });
                                }

                            });
                        }
                    });
                    $('#search-form').on('submit', function (e) {
                        oTable.dataTable().fnDraw();
                        e.preventDefault();
                    });
                    $('.datatable tfoot th').each(function () {
                        var title = $(this).text();
                        var input = document.createElement("input");
                        input.style.width = "100%";
                        $(this).html(input);

                    });
                    $('.dataTable').on('click', 'tbody tr td:not(:last-child)', function () {
                        console.log('API row values : ', table.row(this).data().id);
                        var url = '<?php echo url('admin/cases/view') . '/' ?>' + table.row(this).data().id;
                        window.open(url, '_blank');
                        // window.location.target = "http://google.com";
                    });
                    // DataTable
                    var table = $('.datatable').DataTable();

                    // Apply the search
                    table.columns().every(function () {
                        var that = this;

                        $('input', this.footer()).on('keyup change clear', function () {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });
                    $('.datatable').on('draw.dt', function () {
                        current_material_list = {};
                        var temp_ajax_src = oTable.fnGetData();
                        for (i in temp_ajax_src) {
                            if (temp_ajax_src[i].request && temp_ajax_src[i].request.confirmations.length > 0) {
                                for (j in temp_ajax_src[i].request.receipts) {
                                    temp_ajax_src[i].request.receipts[j]['url'] = temp_ajax_src[i].request.receipts[j].filename.replace('public', '/storage');
                                }
                                for (j in temp_ajax_src[i].request.confirmations) {
                                    temp_ajax_src[i].request.confirmations[j]['url'] = temp_ajax_src[i].request.confirmations[j].filename.replace('public', '/storage');
                                }
                            }
                            current_material_list[temp_ajax_src[i].id] = temp_ajax_src[i];
                        }
                    });

                    $(' body ').on('click', '.swal-warning-cancel', function () {
                        var id = $(this).attr('data-id');

                        swal({
                                title: "Are you sure?",
                                text: "You want to delete this case",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "Yes, delete it!",
                                cancelButtonText: "No, cancel!",
                                closeOnConfirm: false,
                                closeOnCancel: false
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: '{{ url('admin/cases/delete') }}',
                                        data: {id: id},
                                        type: 'post',
                                        success: function (res) {
                                            if (res.token == 1) {
                                                oTable.dataTable().fnDraw();
                                                swal({
                                                    title: 'Deleted!',
                                                    text: 'Case deleted successfully!',
                                                    type: 'success',
                                                    timer: 2000,
                                                    showCancelButton: false,
                                                    showConfirmButton: false
                                                }).catch(swal.noop);
                                            }

                                        },
                                        error: function (res) {
                                            var res = JSON.parse(res);
                                            toastr.error(res.message);
                                        }
                                    });
                                } else {
                                    swal("Cancelled", "Operation cancelled", "error");
                                }
                            });
                    });

                });
            </script>
    @endpush



