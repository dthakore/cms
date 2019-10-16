@extends('layouts.master')

@section('content')


    <div class="main-content">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-uppercase dashboard-headings">Upcoming Dates {{--{{ Counter::showAndCount('home') }}--}}</h4>

                        <table class="table table-bordered bordered table-striped table-condensed datatable">

                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-uppercase dashboard-headings">Ongoing Cases</h4>

                        <table class="table table-bordered bordered table-striped table-condensed datatable2">

                        </table>
                    </div>
                </div>
            </div>
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
                dom:'bftrip',
                buttons: [

                ],
                ajax: {
                    url: "{{ url('/api/entries/dashboard') }}",
                    data: function (d) {
                        d.case_id = '';

                    }
                },
                dataSrc: "data.data",
                pageLength: 10,
                lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
                order: [[2, 'asc']],
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
                        title: 'Camplainant Name', data: 'cases.opponent_name', name: 'date', width: "7%", render: function ( data, type, full, meta ) {
                            if(full['cases'].opponent_name == null){
                                return "N/A";
                            }
                            else{
                                return $.camelCase(full['cases'].opponent_name);
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
                        title: 'Stage', data: 'stage', name: 'stage', width: "7%", render: function ( data, type, full, meta ) {
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


            pTable = $('.datatable2').dataTable({
                processing: true,
                serverSide: true,
                searching: false,
                select: true,
                dom:'bftrip',
                buttons: [

                ],
                ajax: {
                    url: "{{ url('/api/entries/dashboard2') }}",
                    data: function (d) {
                        d.case_id = '';

                    }
                },
                dataSrc: "data.data",
                pageLength: 10,
                lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
                order: [[2, 'asc']],
                columns:[
                    {
                        title: '#', data: 'DT_RowIndex', name: 'DT_RowIndex', width: "2%",
                        "searchable": false,
                        "orderable": false
                    },

                    {
                        title: 'Case Number', data: 'case_number', name: 'date', width: "7%", render: function ( data, type, full, meta ) {
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
                        title: 'Camplainant Name', data: 'opponent_name', name: 'date', width: "7%", render: function ( data, type, full, meta ) {
                            if(full['opponent_name'] == null){
                                return "N/A";
                            }
                            else{
                                return $.camelCase(full['opponent_name']);
                            }
                        },
                        "searchable": false,
                        "orderable": true
                    },
                    {
                        title: 'Court', data: 'court', name: 'court', width: "7%", render: function ( data, type, full, meta ) {
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
            // pTable.DataTable().buttons().container().appendTo( $('.col-sm-6:eq(0)', pTable.DataTable().table().container() ) );
            $('#search-form').on('submit', function(e) {
                pTable.dataTable().fnDraw();
                e.preventDefault();
            });

            $('.datatable2').on( 'draw.dt', function () {
                // alert( 'Table redrawn' );
                // console.log(pTable.fnGetData());
                current_material_list = {};
                var temp_ajax_src = pTable.fnGetData();
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
