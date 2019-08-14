@extends('../layouts.master')
@section('title')
    IMS - Attributes
@endsection
@section('page_title')
    Attribute Manager
@endsection
@section('style')
    <style type="text/css">
        td > a{
            margin-left: 10px;
            margin-right: 10px;
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
                    <li class="active">Cases</li>
                </ol>
            </div>
            <div class="panel-body">

                <a href="{{ url('admin/cases/create') }}" class="btn-primary btn btn-round btn-success" style="float: right; margin-bottom: 20px;"><i class="fa fa-plus"></i> Create new</a>
                <table class="table table-bordered bordered table-striped table-condensed datatable">

                </table>
            </div>
        </div>
@endsection
@push('jsfiles')
    <script type="text/javascript">
        $(document).ready( function () {


            oTable = $('.datatable').dataTable({
                processing: true,
                serverSide: true,
                searching: false,
                select: true,
                buttons: [

                ],
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
                columns:[
                    {
                        title: '#', data: 'id', name: 'id', width: "2%", render: function ( data, type, full, meta ) {
                            if(full['id'] == null){
                                return "N/A";
                            }
                            else{
                                return $.camelCase(full['id']);
                            }
                        },
                        "searchable": false,
                        "orderable": true
                    },
                    {
                        title: 'Case Number', data: 'case_number', name: 'case_number', width: "7%", render: function ( data, type, full, meta ) {
                            if(full['case_number'] == null){
                                return "N/A";
                            }
                            else{
                                return $.camelCase(full['case_number']);
                            }
                        },
                        "searchable": false,
                        "orderable": true
                    },
                    {
                        title: 'Complainant Name', data: 'complainant_name', name: 'complainant_name', width: "7%", render: function ( data, type, full, meta ) {
                            if(full['complainant_name'] == null){
                                return "N/A";
                            }
                            else{
                                return $.camelCase(full['complainant_name']);
                            }
                        },
                        "searchable": false,
                        "orderable": true
                    },
                    {
                        title: 'Complainant Details', data: 'complainant_details', name: 'complainant_details', width: "7%", render: function ( data, type, full, meta ) {
                            if(full['complainant_details'] == null){
                                return "N/A";
                            }
                            else{
                                return $.camelCase(full['complainant_details']);
                            }
                        },
                        "searchable": false,
                        "orderable": true
                    },
                    {
                        title: 'Date Of Filing', data: 'date_of_filing', name: 'date_of_filing', width: "7%", render: function ( data, type, full, meta ) {
                            if(full['date_of_filing'] == null){
                                return "N/A";
                            }
                            else{
                                return moment(full['date_of_filing']).format('DD-MM-YYYY');
                            }
                        },
                        "searchable": false,
                        "orderable": true
                    },
                    {
                        title: 'court', data: 'court', name: 'court', width: "7%", render: function ( data, type, full, meta ) {
                            if(full['court'] == null){
                                return "N/A";
                            }
                            else{
                                return $.camelCase(full['court']);
                            }
                        },
                        "searchable": false,
                        "orderable": true
                    },
                    {
                        title: 'Stage', data: 'stage', name: 'stage', width: "7%", render: function ( data, type, full, meta ) {
                            if(full['stage'] == null){
                                return "N/A";
                            }
                            else{
                                return $.camelCase(full['stage']);
                            }
                        },
                        "searchable": false,
                        "orderable": true
                    },
                    {
                        title: 'next_date', data: 'next_date', name: 'next_date', width: "7%", render: function ( data, type, full, meta ) {
                            if(full['next_date'] == null){
                                return "N/A";
                            }
                            else{
                                return moment(full['next_date']).format('DD-MM-YYYY');
                            }
                        },
                        "searchable": false,
                        "orderable": true
                    },
                    {
                        title: 'comments', data: 'comments', name: 'comments', width: "7%", render: function ( data, type, full, meta ) {
                            if(full['comments'] == null){
                                return "N/A";
                            }
                            else{
                                return $.camelCase(full['comments']);
                            }
                        },
                        "searchable": false,
                        "orderable": true
                    },
                    {
                        title: 'Action', data: '', name: '', width: "7%", render: function ( data, type, full, meta ) {

                            var url = "{{url('cases/view')}}/"+full['id'];
                            var urlEdit = "{{url('cases/update')}}/"+full['id'];
                            return '<a href="'+url+'"><i class="fa fa-eye" title="View case"></i></a> '+
                                ' <a href="'+urlEdit+'"><i class="fa fa-pencil" title="Edit case"></i></a>'+
                                ' <a href="javascript:;"><i class="fa fa-trash swal-warning-cancel" id="deleteAttr_'+full['id']+'" title="Delete attribute"></i></a>'

                        },
                        "searchable": false,
                        "orderable": false
                    }
                ]
            });
            // oTable.DataTable().buttons().container().appendTo( $('.col-sm-6:eq(0)', oTable.DataTable().table().container() ) );
            $('#search-form').on('submit', function(e) {
                oTable.dataTable().fnDraw();
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
        } );


    </script>
@endpush



