@extends('../layouts.master')
@section('title')
    CMS - Search
@endsection
@section('page_title')
    Search Case Entry
@endsection
@section('style')
    <style type="text/css">
        td > a {
            margin-left: 10px;
            margin-right: 10px;
        }
        .control-label b{
            font-size:18px;
        }

        .rw-class {
            margin-bottom: 5px;
            padding-bottom: 30px;
        }
        .align-center{
            text-align: center;
        }

        .attach-box {
            margin-right: 15px;
            display: block;
            padding: 35px;
            -webkit-box-shadow: 0.5px -0.5px 5.5px 0.5px rgba(0, 0, 0, 0.075);
            -moz-box-shadow: 0.5px -0.5px 5.5px 0.5px rgba(0, 0, 0, 0.075);
            box-shadow: 0.5px -0.5px 5.5px 0.5px rgba(0, 0, 0, 0.075);
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .attach-box img {
            width: 140px;
            margin: auto;
            display: block;
        }

        .attach-box-action a {
            margin-right: 60px;
            text-align: center;
        }

        .attach-box-action {
            margin-top: 30px;
        }

        .dt-buttons {
            position: absolute !important;
            float: none !important;
            top: -70px !important;
            left: 85% !important;
        }

        .buttons-csv {
            background-image: -webkit-linear-gradient(top, #1f99cc 0%, #1f99cc 100%) !important;
            color: white !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            border-radius: 30px !important;
        }
    </style>
@endsection
@section('content')
    <div class="main-content">
        <div class="panel">
            <div class="panel-heading border">
                <ol class="breadcrumb mb0 no-padding">
                    <li>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/search/entry') }}">Search Case Entry</a>
                    </li>
                </ol>
            </div>
            <div class="panel-body">
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                            <label class="control-label" for="date"><b>Enter date to get causelist</b></label>
                            <input id="date" type="text" class="form-control" name="date">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12 mt30">
                            <a href="javascript:void(0);" class="btn btn-primary btn-round"
                               id="search_button">Search</a>
                        </div>
                    </div>
                </div>
                <div class="search-result " id="search_result">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-uppercase page-header">Search Results</h4>
                        </div>

                        <div class="col-md-12">
                            <table class="table table-bordered bordered table-striped table-condensed datatable"
                                   id="search-result">
                                <tfoot>
                                <tr>
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
                </div>
                <div class="hide col-lg-12 col-md-12 col-sm-12 col-sm-12 align-center " id="nextcases">
                    <h3>No cases for tomorrow</h3>
                </div>
            </div>
        </div>
        @endsection
        @push('jsfiles')
            <script type="text/javascript"
                    src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
            <script type="text/javascript"
                    src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function () {
                    // $(".panel-body").css('height', window.innerHeight);
                    var next_date;
                    if ($("#date").val() == "") {
                        next_date = new Date();
                        var dd = String(next_date.getDate()).padStart(2, '0');
                        var mm = String(next_date.getMonth() + 1).padStart(2, '0'); //January is 0!
                        var yyyy = next_date.getFullYear();

                        next_date = dd + '-' + mm + '-' + yyyy;
                    } else {
                        next_date = $("#date").val();
                    }
                    oTable = $('.datatable').dataTable({
                        processing: true,
                        serverSide: true,
                        searching: false,
                        select: true,
                        dom: 'bftrip',
                        ajax: {
                            url: "{{ url('/api/case/search/entry') }}",
                            data: function (d) {
                                d.next_date = next_date;
                            }
                        },
                        dataSrc: "data.data",
                        pageLength: 10,
                        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
                        order: [[2, 'asc']],
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'csv',
                                text: 'Download CSV',
                                title: 'Coupons Data export',
                                action: function (e, dt, node, config) {
                                    $.ajax({
                                        "url": "{{ url('/api/case/entry/export')}}",
                                        "data": dt.ajax.params(),
                                        "success": function (res, status, xhr) {
                                            var result = JSON.parse(res);
                                            window.open(result.filename.file);
                                            setTimeout(function () {
                                                $.ajax({
                                                    "url": "{{ url('/api/entries/delete/csv')}}",
                                                    "data": {"file": result.filename.delete},
                                                    "type": "POST",
                                                    "success": function (res, status, xhr) {
                                                    }
                                                })
                                            }, 4000);
                                        }
                                    });
                                }
                            },
                        ],
                        columns: [
                            {
                                title: '#', data: 'DT_RowIndex', name: 'DT_RowIndex', width: "2%",
                                "searchable": false,
                                "orderable": false
                            },

                            {
                                title: 'Case Number',
                                data: 'cases.case_number',
                                name: 'date',
                                width: "7%",
                                render: function (data, type, full, meta) {
                                    if (full['cases'].case_number == null) {
                                        return "N/A";
                                    }
                                    else {
                                        return $.camelCase(full['cases'].case_number);
                                    }
                                },
                                "searchable": true,
                                "orderable": true
                            },
                            {
                                title: 'Next Date',
                                data: 'next_date',
                                name: 'next_date',
                                width: "7%",
                                render: function (data, type, full, meta) {
                                    if (full['next_date'] == null) {
                                        return moment(full['date']).format('DD-MM-YYYY') + " <br><span class='next-date'> (" + moment(full['date']).fromNow() + ")</span>";
                                    }
                                    else {
                                        return moment(full['next_date']).format('DD-MM-YYYY') + " <br><span class='next-date'> (" + moment(full['next_date']).fromNow() + ")</span>";
                                    }
                                },
                                "searchable": true,
                                "orderable": true
                            },
                            {
                                title: 'Complainant Name',
                                data: 'cases.complainant_name',
                                name: 'date',
                                width: "7%",
                                render: function (data, type, full, meta) {
                                    if (full['cases'].complainant_name == null) {
                                        return "N/A";
                                    }
                                    else {
                                        return $.camelCase(full['cases'].complainant_name);
                                    }
                                },
                                "searchable": true,
                                "orderable": true
                            },
                            {
                                title: 'Client',
                                data: 'cases.client',
                                name: 'cases.client',
                                width: "7%",
                                render: function (data, type, full, meta) {
                                    if (full['cases'].client == null) {
                                        return "N/A";
                                    }
                                    else {
                                        return $.camelCase(full['cases'].client);
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

                        ], "initComplete": function () {
                            var r = $('#search-result tfoot tr');
                            $('#search-result thead').append(r);
                            this.api().columns().every(function () {
                                var column = this;
                                var input = document.createElement("input");
                                $(input).appendTo($(column.footer()).empty())
                                    .on('change', function () {
                                        column.search($(this).val(), false, false, true).draw();
                                    });
                            });
                        }
                    });
                    if (oTable.fnSettings().aoData.length === 0) {
                        $("#search_result").addClass('hide');
                        $('#nextcases').removeClass('hide');
                    } else {
                        $("#search_result").removeClass('hide');
                        $('#nextcases').addClass('hide');
                    }
                    $('#search-form').on('submit', function (e) {
                        oTable.dataTable().fnDraw();
                        oTable.fnAdjustColumnSizing();
                        e.preventDefault();
                    });
                    $('body').on('click', '#search_button', function (e) {
                        next_date = $("#date").val();
                        $('#nextcases').addClass('hide');
                        $("#search_result").removeClass('hide');
                        if (oTable.fnSettings().aoData.length === 0) {
                            $("#search_result").addClass('hide');
                            $('#nextcases h3').text('No Cases');
                            $('#nextcases').removeClass('hide');
                        }
                        oTable.dataTable().fnDraw();
                        oTable.fnAdjustColumnSizing();
                        e.preventDefault();
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

                    $("#date").datepicker({
                        format: 'dd-mm-yyyy'
                    });
                });


            </script>
    @endpush



