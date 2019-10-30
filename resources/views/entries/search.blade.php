@extends('../layouts.master')
@section('title')
    CMS - Search
@endsection
@section('page_title')
    Search Case Entry
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">

    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
@endsection

@section('content')
    <div class="main-content">
        <div class="panel">
            <div class="panel-heading border">
                <ol class="breadcrumb mb0 no-padding left">
                    <li>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/search/entry') }}">Causelist</a>
                    </li>
                </ol>
                <b class="breadcrumb mb0 no-padding right">
                    Date : <?php echo date('d-m-Y'); ?>
                </b>
                <br>
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
                <div class="col-sm-12">
                    <br>
                    <div class="box-tab justified">
                        <ul class="nav nav-tabs">
                            @php
                                $nextDates = next3days();
                                foreach ($nextDates as $next):
                                $class = ($next === reset($nextDates))?"active":"";
                                echo '<li class="'.$class.'"><a href="#next'. date('d-m-Y',strtotime($next)).'" data-toggle="tab">'.date('d M, Y',strtotime($next)).'</a></li>';
                                $nextArr[] = 'next'. date('d-m-Y',strtotime($next));
                                endforeach;
                            @endphp

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="<?=$nextArr[0]?>">
                            </div>
                            <div class="tab-pane" id="<?=$nextArr[1]?>">
                            </div>
                            <div class="tab-pane" id="<?=$nextArr[2]?>">
                            </div>
                        </div>
                    </div>
                </div>
                {{--<table class="table table-bordered bordered table-striped table-condensed datatable"--}}
                       {{--id="search-result" style="width: -webkit-fill-available;">--}}
                    {{--<tfoot>--}}
                    {{--<tr>--}}
                        {{--<th></th>--}}
                        {{--<th></th>--}}
                        {{--<th></th>--}}
                        {{--<th></th>--}}
                        {{--<th></th>--}}
                        {{--<th></th>--}}
                        {{--<th></th>--}}
                    {{--</tr>--}}
                    {{--</tfoot>--}}
                {{--</table>--}}
                <div style="background:white" class="search-result" id="search_result">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-uppercase page-header result-text"></h4>
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
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('jsfiles')
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
    <script type="text/javascript">
        $(".panel-body").css('height', window.innerHeight);
        var next_date;
        var home;
        if ($("#date").val() == "") {
            // next_date = new Date();
            // var dd = String(next_date.getDate()).padStart(2, '0');
            // var mm = String(next_date.getMonth() + 1).padStart(2, '0');
            // var yyyy = next_date.getFullYear();
            var next_date_str = '<?php echo $nextArr[0]; ?>';
            var res = next_date_str.split("next");
            next_date = res[1];
            home = 0;
        } else {
            next_date = $("#date").val();
            home = 0;
        }

        $('.nav-tabs > li > a').click( function() {
            var activeTab = $(this);
            var str = activeTab.attr('href');
            var res = str.split("#next");
            next_date = res[1];
            oTable.dataTable().fnDraw();
            oTable.fnAdjustColumnSizing();
        } );
        oTable = $('.datatable').dataTable({
            dom: 'Bfrtip',
            processing: true,
            serverSide: true,
            searching: false,
            select: true,
            ajax: {
                url: "{{ url('/api/case/search/entry') }}",
                data: function (d) {
                    d.next_date = next_date;
                    d.totaldays = home;
                }
            },
            dataSrc: "data.data",
            pageLength: 10,
            "language": {
                "emptyTable": "No Cases"
            },
            lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
            order: [[2, 'asc']],
            buttons: [
                {
                    extend: 'csv',
                    text: 'Download CSV',
                    title: 'Cases Data export',
                    action: function (e, dt, node, config) {
                        $.ajax({
                            "url": "{{ url('/api/case/entry/export')}}",
                            "data": dt.ajax.params(),
                            "success": function (res, status, xhr) {
                                console.log(dt.ajax.params());
                                var result = JSON.parse(res);
                                window.open(result.filename.file);
                                setTimeout(function () {
                                    $.ajax({
                                        "url": "{{ url('/api/entries/delete/csv')}}",
                                        "data": {"file": result.filename.delete},
                                        "type": "POST",
                                        "success": function (res, status, xhr) {
                                            console.log("File deleted successfully");
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
                            return "N/A";
                        }
                        else {
                            return moment(full['next_date']).format('DD-MM-YYYY') + " <br><span class='next-date'> (" + moment(full['next_date']).fromNow() + ")</span>";
                        }
                    },
                    "searchable": true,
                    "orderable": true
                },
                {
                    title: 'Opponent Name',
                    data: 'cases.opponent_name',
                    name: 'date',
                    width: "7%",
                    render: function (data, type, full, meta) {
                        if (full['cases'].opponent_name == null) {
                            return "N/A";
                        }
                        else {
                            return $.camelCase(full['cases'].opponent_name);
                        }
                    },
                    "searchable": true,
                    "orderable": true
                },
                {
                    title: 'Client',
                    data: 'cases.client.name',
                    name: 'cases.client.name',
                    width: "7%",
                    render: function (data, type, full, meta) {
                        if (full['cases'].client.name == null) {
                            return "N/A";
                        }
                        else {
                            return $.camelCase(full['cases'].client.name);
                        }
                    },
                    "searchable": true,
                    "orderable": true
                }, {
                    title: 'Coram',
                    data: 'coram',
                    name: 'coram',
                    width: "7%",
                    render: function (data, type, full, meta) {
                        if (full['coram'] == null) {
                            return "N/A";
                        }
                        else {
                            return $.camelCase(full['coram']);
                        }
                    },
                    "searchable": true,
                    "orderable": true
                },

                {
                    title: 'Stage',
                    data: 'stage',
                    name: 'stage',
                    width: "7%",
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
                this.api().columns().every(function (i) {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = '100%';
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    if (i == 6) {
                        var select = $('<select><option value="...">Select All</option><option value="true">Accepted</option><option value="false">Rejected</option></select>')
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

        $('body').on('click', '#search_button', function (e) {
            next_date = $("#date").val();
            home = 0;
            $('.box-tab').hide();
            $('.result-text').text('Search Result');
            oTable.dataTable().fnDraw();
            oTable.fnAdjustColumnSizing();
            e.preventDefault();
        });
        $("#date").datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,

        });
    </script>

@endpush



