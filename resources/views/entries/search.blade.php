@extends('../layouts.master')
@section('title')
    CMS - Search
@endsection
@section('page_title')
    Search Case Entry
@endsection
@section('style')
    <style type="text/css">
        td > a{
            margin-left: 10px;
            margin-right: 10px;
        }
        .rw-class {
            margin-bottom: 5px;
            padding-bottom: 30px;
        }
        .attach-box{
            margin-right: 15px;display: block;padding: 35px;
            -webkit-box-shadow: 0.5px -0.5px 5.5px 0.5px rgba(0, 0, 0, 0.075);
            -moz-box-shadow: 0.5px -0.5px 5.5px 0.5px rgba(0, 0, 0, 0.075);
            box-shadow: 0.5px -0.5px 5.5px 0.5px rgba(0, 0, 0, 0.075);
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .attach-box img{
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
        .dt-buttons{
            position: absolute  !important;
            float:none !important;
            top: -70px !important;
            left: 85% !important;
        }
        .buttons-csv{
            background-image: -webkit-linear-gradient(top, #1f99cc 0%, #1f99cc 100%) !important;
            color: white !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            border-radius: 30px !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
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
                            <label class="control-label" for="date">Date</label>
                            <input id="date" type="text" class="form-control" name="date" >
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12 mt25">
                            <a href="javascript:void(0);" class="btn btn-primary btn-round" id="search_button">Search</a>
                        </div>
                    </div>
                </div>

                <div class="search-result hide" id="search_result">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-uppercase page-header">Search Results</h4>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-bordered bordered table-striped table-condensed datatable">

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
    <script type="text/javascript" src="https://datatables.yajrabox.com/vendor/datatables/buttons.server-side.js"></script>
    <script type="text/javascript">
        $(".panel-body").css('height', window.innerHeight);


        oTable = $('.datatable').dataTable({
            processing: true,
            serverSide: true,
            searching: false,
            select: true,
            dom:'bftrip',
            ajax: {
                url: "{{ url('/api/case/search/entry') }}",
                data: function (d) {
                    d.next_date =  $("#date").val();

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
                    text:'Download CSV',
                    title: 'Coupons Data export',
                    action: function (e, dt, node, config)
                    {
                        $.ajax({
                            "url": "{{ url('/api/case/entry/export')}}",
                            "data": dt.ajax.params(),
                            "success": function(res, status, xhr) {
                                var result = JSON.parse(res);
                                window.open(result.filename.file);
                                setTimeout(function(){
                                    $.ajax({
                                        "url": "{{ url('/api/entries/delete/csv')}}",
                                        "data": {"file":result.filename.delete},
                                        "type":"POST",
                                        "success": function(res, status, xhr) {
                                            console.log("File deleted successfully");
                                        }
                                    })
                                }, 4000);
                            }
                        });
                    }
                },
            ],
            columns:[
                {
                    title: '#', data: 'DT_RowIndex', name: 'DT_RowIndex', width: "2%",
                    "searchable": false,
                    "orderable": false
                },

                {
                    title: 'Case Number', data: 'cases.case_number', name: 'date', width: "7%", render: function ( data, type, full, meta ) {
                        if(full['cases'].case_number == null){
                            return "N/A";
                        }
                        else{
                            return $.camelCase(full['cases'].case_number);
                        }
                    },
                    "searchable": false,
                    "orderable": true
                },
                {
                    title: 'Next Date', data: 'next_date', name: 'next_date', width: "7%", render: function ( data, type, full, meta ) {
                        if(full['next_date'] == null){
                            return "N/A";
                        }
                        else{
                            return moment(full['next_date']).format('DD-MM-YYYY') + " <br><span class='next-date'> (" + moment(full['next_date']).fromNow()+")</span>";
                        }
                    },
                    "searchable": false,
                    "orderable": true
                },
                {
                    title: 'Camplainant Name', data: 'cases.complainant_name', name: 'date', width: "7%", render: function ( data, type, full, meta ) {
                        if(full['cases'].complainant_name == null){
                            return "N/A";
                        }
                        else{
                            return $.camelCase(full['cases'].complainant_name);
                        }
                    },
                    "searchable": false,
                    "orderable": true
                },
                {
                    title: 'Coram', data: 'coram', name: 'coram', width: "7%", render: function ( data, type, full, meta ) {
                        if(full['coram'] == null){
                            return "N/A";
                        }
                        else{
                            return $.camelCase(full['coram']);
                        }
                    },
                    "searchable": false,
                    "orderable": true
                },
                {
                    title: 'Stage', data: 'stage', name: 'stage', width: "10%", render: function ( data, type, full, meta ) {
                        if(full['stage'] == null){
                            return "N/A";
                        }
                        else{
                            var stage = full['stage'].toLowerCase();
                            var stag = stage.split(' ').join('_');
                            return '<span class="'+stag+'">'+full['stage']+'</span>';
                        }
                    },
                    "searchable": false,
                    "orderable": true
                },

            ]
        });
        // oTable.DataTable().buttons().container().appendTo( $('.col-sm-6:eq(0)', oTable.DataTable().table().container() ) );
        $('body').on('click','#search_button', function(e) {
            $("#search_result").removeClass('hide');
            oTable.dataTable().fnDraw();
            oTable.fnAdjustColumnSizing();
            e.preventDefault();
        });

        $('.datatable').on( 'draw.dt', function () {
            // alert( 'Table redrawn' );
            // console.log(oTable.fnGetData());
            current_material_list = {};
            var temp_ajax_src = oTable.fnGetData();
            for(i in temp_ajax_src){
                if(temp_ajax_src[i].request && temp_ajax_src[i].request.confirmations.length > 0){
                    for(j in temp_ajax_src[i].request.receipts){
                        temp_ajax_src[i].request.receipts[j]['url'] = temp_ajax_src[i].request.receipts[j].filename.replace('public', '/storage');
                    }
                    for(j in temp_ajax_src[i].request.confirmations){
                        temp_ajax_src[i].request.confirmations[j]['url'] = temp_ajax_src[i].request.confirmations[j].filename.replace('public', '/storage');
                    }
                }
                current_material_list[temp_ajax_src[i].id] = temp_ajax_src[i];
            }
        } );



        $(' body ').on('click','.swal-warning-cancel', function () {
            var id = $(this).attr('data-id');

            swal({
                    title: "Are you sure?",
                    text: "You want to delete this case entry",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ url('admin/entries/delete') }}',
                            data: {id: id},
                            type:'post',
                            success:function (res) {
                                if(res.token == 1){
                                    oTable.dataTable().fnDraw();
                                    swal({title: 'Deleted!', text: 'Case entry deleted successfully!', type: 'success', timer: 2000, showCancelButton: false,showConfirmButton: false}).catch(swal.noop);
                                }

                            },
                            error:function (res) {
                                var res = JSON.parse(res);
                                toastr.error(res.message);
                            }
                        });
                    } else {
                        swal("Cancelled", "Operation cancelled", "error");
                    }
                });
        });


        $(' body ').on('click','.delete-attachment', function () {
            var id = $(this).attr('data-id');

            swal({
                    title: "Are you sure?",
                    text: "You want to delete this attachment",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ url('admin/attachments/delete') }}',
                            data: {id: id},
                            type:'post',
                            success:function (res) {
                                if(res.token == 1){
                                    $("#attachment_"+id).parent().parent().parent().remove();
                                    swal({title: 'Deleted!', text: 'Attachment deleted successfully!', type: 'success', timer: 2000, showCancelButton: false,showConfirmButton: false});
                                }

                            },
                            error:function (res) {
                                var res = JSON.parse(res);
                                toastr.error(res.message);
                            }
                        });
                    } else {
                        swal("Cancelled", "Operation cancelled", "error");
                    }
                });
        });

        $("#date").datepicker({
            format:'dd-mm-yyyy'
        });
    </script>

@endpush



