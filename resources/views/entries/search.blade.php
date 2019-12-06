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

                <b class="breadcrumb mb0 right btn btn-sm btn-info">
                    TODAY : <?php echo date('d-m-Y'); ?>
                </b >
                <br>
            </div>
            @if( Session::has("success") )
                <div class="alert alert-success alert-block" role="alert">
                    <button class="close" data-dismiss="alert"></button>
                    {{ Session::get("success") }}
                </div>
            @endif
            <div class="panel-body">
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                            <label class="control-label" for="date"><h4>DATE TO GET CAUSELIST</h4></label>
                            <input id="date" type="text" class="form-control" name="date" placeholder="Search for your date..">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12 mt2">
                            <br><br>
                            <a href="javascript:void(0);" class="btn btn-info"
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
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal bs-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Add Item Numbers</h4></div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer no-border">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id='modal-add' class="btn btn-primary">Add</button>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>


    <script type="text/javascript">
        $(".panel-body").css('height', window.innerHeight);
        var next_date;
        var home;
        if ($("#date").val() == "") {
            var next_date_str = '<?php echo $nextArr[0]; ?>';
            var res = next_date_str.split("next");
            next_date = res[1];
            home = 0;
        } else {
            next_date = $("#date").val();
            home = 0;
        }
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
                    text: '<b>Export CSV</b>',
                    className: "btn-datatable",
                    title: 'CauseList-' + next_date,
                },
                {
                    text: '<b>Export PDF</b>',
                    className: "btn-datatable",
                    action: function (e, dt, node, config) {
                        $.ajax({
                            "url": "{{url('/api/export/cases')}}",
                            "data": {next_date: next_date,totaldays:home},
                            xhrFields: {
                                responseType: 'blob'
                            },
                            "success": function (response, status, xhr) {
                                var filename = "";
                                var disposition = xhr.getResponseHeader('Content-Disposition');

                                if (disposition) {
                                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                                    var matches = filenameRegex.exec(disposition);
                                    if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                                }
                                var linkelem = document.createElement('a');

                                var blob = new Blob([response], { type: 'application/octet-stream' });

                                if (typeof window.navigator.msSaveBlob !== 'undefined') {
                                    //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                                    window.navigator.msSaveBlob(blob, filename);
                                } else {
                                    var URL = window.URL || window.webkitURL;
                                    var downloadUrl = URL.createObjectURL(blob);

                                    if (filename) {
                                        // use HTML5 a[download] attribute to specify filename
                                        var a = document.createElement("a");

                                        // safari doesn't support this yet
                                        if (typeof a.download === 'undefined') {
                                            window.location = downloadUrl;
                                        } else {
                                            a.href = downloadUrl;
                                            a.download = filename;
                                            document.body.appendChild(a);
                                            a.target = "_blank";
                                            a.click();
                                        }
                                    } else {
                                        window.location = downloadUrl;
                                    }
                                }
                            }
                        });
                    }
                },
                {
                    text: '<i class="fa fa-edit"/><b> Item Number</b>',
                    className: "btn-datatable",
                    action: function (e, dt, node, config) {
                        $.ajax({
                            "url": "{{ url('/api/get/cases')}}",
                            "data": {next_date: next_date},
                            "success": function (res, status, xhr) {
                                $('.modal').modal('show');
                                $('.modal-body').empty();
                                obj = JSON.parse(res);
                                for (const [key, value] of Object.entries(obj)) {
                                    console.log(obj);
                                    console.log(key);
                                    console.log(value);
                                    $('.modal-body').append('<div class="row mb25">\n' +
                                        '<div class="col-12">\n' +
                                        '<div class="col-sm-6"><label>' + value.case_number + '</label></div>\n' +
                                        '<div class="col-sm-6">' +
                                        '<input class="form-control" placeholder="Item Number" id="entry#' + key + '" value=' + value.item_number + '></div>\n' +
                                        '</div>\n' +
                                        '</div>');
                                }
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
                    title: 'Date',
                    data: 'date',
                    name: 'date',
                    width: "7%",
                    render: function (data, type, full, meta) {
                        if (full['date'] == null) {
                            return "N/A";
                        }
                        else {
                            return moment(full['date']).format('DD-MM-YYYY');
                        }
                    },
                    "searchable": true,
                    "orderable": true
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
                    title: 'Court',
                    data: 'cases.court',
                    name: 'court',
                    width: "7%",
                    render: function (data, type, full, meta) {
                        if (full['cases'].court == null) {
                            return "N/A";
                        }
                        else {
                            return $.camelCase(full['cases'].court);
                        }
                    },
                    "searchable": true,
                    "orderable": true
                },
                {
                    title: 'Bench',
                    data: 'bench',
                    width: "7%",
                    render: function (data, type, full, meta) {
                        if (full['bench'] == null) {
                            return "N/A";
                        }
                        else {
                            return $.camelCase(full['bench']);
                        }
                    },
                    "searchable": true,
                    "orderable": true
                },
                {
                    title: 'Case',
                    data: 'cases.opponent_name',
                    width: "7%",
                    render: function (data, type, full, meta) {
                        if (full['cases'].opponent_name == null) {
                            return "N/A";
                        }
                        else {
                            return $.camelCase(full['cases'].client.name) + ' <b> (client)</b>' + '<br> VS <br>' + $.camelCase(full['cases'].opponent_name);
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
                {
                    title: 'Item',
                    data: 'item_number',
                    name: 'item_number',
                    width: "7%",
                    render: function (data, type, full, meta) {
                        if (full['item_number'] == null) {
                            return "N/A";
                        }
                        else {
                            return $.camelCase(full['item_number']);
                        }
                    },
                    "searchable": true,
                    "orderable": true
                }
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

        $('.nav-tabs > li > a').click(function () {
            var activeTab = $(this);
            var str = activeTab.attr('href');
            var res = str.split("#next");
            next_date = res[1];
            oTable.dataTable().fnDraw();
            oTable.fnAdjustColumnSizing();

        });

        $('body').on('click', '#search_button', function (e) {
            next_date = $("#date").val();
            home = 0;
            $('.box-tab').hide();
            $('.result-text').text('Search Result');
            oTable.dataTable().fnDraw();
            oTable.buttons().enable(
                oTable.rows({selected: true}).indexes().length === 0 ?
                    false :
                    true
            );
            oTable.fnAdjustColumnSizing();
            e.preventDefault();
        });
        $("#date").datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,

        });
        $('body').on('click', '#modal-add', function (e) {
            var data = {};

            $(".modal-body :input").each(function ($this) {
                $element = $(this);
                console.log($element);
                $getId = $element.attr('id');
                console.log($getId);
                $splitId = $getId.split("entry#");
                $id = $splitId[1];
                $val = $element.val();
                data[$id] = $val;
                console.log($id);
            });
            console.log(data);
            $.post({
                "url": "{{ url('/admin/entries/add/itemnumber')}}",
                "data": {'data': data, "_token": "{{ csrf_token() }}"},
                "success": function (res, status, xhr) {
                    if (res.result == 1) {
                        location.reload(true);

                    }
                }
            });
        });

    </script>

@endpush



