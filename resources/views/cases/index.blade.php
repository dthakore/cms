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
                        <th></th>
                    </tr>
                    </tfoot>
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
                searching: true,
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
                        title: '#', data: 'DT_RowIndex', name: 'DT_RowIndex', width: "2%",
                        "searchable": false,
                        "orderable": false
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
                        "searchable": true,
                        "orderable": true
                    },
                    {
                        title: 'Client Name', data: 'cases.client', name: 'cases.client', width: "7%", render: function ( data, type, full, meta ) {
                            if(full['client'] == null){
                                return "N/A";
                            }
                            else{
                                return $.camelCase(full['client'].name);
                            }
                        },
                        "searchable": true,
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
                        "searchable": true,
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
                        "searchable": true,
                        "orderable": true
                    },
                    {
                        title: 'Court', data: 'court', name: 'court', width: "6%", render: function ( data, type, full, meta ) {
                            if(full['court'] == null){
                                return "N/A";
                            }
                            else{
                                return $.camelCase(full['court']);
                            }
                        },
                        "searchable": true,
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
                        "searchable": true,
                        "orderable": true
                    },
                    {
                        title: 'Next Date', data: 'next_date', name: 'next_date', width: "10%", render: function ( data, type, full, meta ) {
                            if(full['next_date'] == null){
                                return "N/A";
                            }
                            else{
                                return moment(full['next_date']).format('DD-MM-YYYY')+ " <br><span class='next-date'> (" + moment(full['next_date']).fromNow()+")</span>";
                            }
                        },
                        "searchable": true,
                        "orderable": true
                    },

                    {
                        title: 'Action', data: '', name: '', width: "7%", render: function ( data, type, full, meta ) {

                            var url = "{{url('admin/cases/view')}}/"+full['id'];
                            var urlEdit = "{{url('admin/cases/update')}}/"+full['id'];
                            return '<a href="'+url+'"><i class="fa fa-eye" title="View case"></i></a> '+
                                ' <a href="'+urlEdit+'"><i class="fa fa-pencil" title="Edit case"></i></a>'+
                                ' <a href="javascript:;"><i class="fa fa-trash swal-warning-cancel" data-id="'+full['id']+'" title="Delete attribute"></i></a>'

                        },
                        "searchable": false,
                        "orderable": false
                    }
                ],
                "initComplete": function () {
                var r = $('#cases tfoot tr');
                $('#cases thead').append(r);

                this.api().columns().every(function () {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width ="100px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {

                            column.search($(this).val(), false, false,true).draw();
                        });
                });

            }
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

            $(' body ').on('click','.swal-warning-cancel', function () {
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
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: '{{ url('admin/cases/delete') }}',
                                data: {id: id},
                                type:'post',
                                success:function (res) {
                                    if(res.token == 1){
                                        oTable.dataTable().fnDraw();
                                        swal({title: 'Deleted!', text: 'Case deleted successfully!', type: 'success', timer: 2000, showCancelButton: false,showConfirmButton: false}).catch(swal.noop);
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

        } );


    </script>
@endpush



