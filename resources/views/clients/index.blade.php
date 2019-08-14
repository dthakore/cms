@extends('../layouts.master')
@section('title')
    CMS - Clients
@endsection
@section('page_title')
    Clients Manager
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
                    <li class="active">Clients</li>
                </ol>
            </div>
            <div class="panel-body">

                <a href="{{ url('admin/clients/create') }}" class="btn-primary btn btn-round btn-success" style="float: right; margin-bottom: 20px;"><i class="fa fa-plus"></i> Create new</a>
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
                    url: "{{ url('/api/clients/serverside') }}",
                    data: function (d) {

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
                        title: 'Name', data: 'name', name: 'name', width: "7%", render: function ( data, type, full, meta ) {
                            if(full['name'] == null){
                                return "N/A";
                            }
                            else{
                                return $.camelCase(full['name']);
                            }
                        },
                        "searchable": false,
                        "orderable": true
                    },
                    {
                        title: 'Email', data: 'email', name: 'email', width: "7%", render: function ( data, type, full, meta ) {
                            if(full['email'] == null){
                                return "N/A";
                            }
                            else{
                                return $.camelCase(full['email']);
                            }
                        },
                        "searchable": false,
                        "orderable": true
                    },
                    {
                        title: 'Contact Number', data: 'contact_number', name: 'contact_number', width: "7%", render: function ( data, type, full, meta ) {
                            if(full['contact_number'] == null){
                                return "N/A";
                            }
                            else{
                                return $.camelCase(full['contact_number']);
                            }
                        },
                        "searchable": false,
                        "orderable": true
                    },

                    {
                        title: 'company', data: 'company', name: 'company', width: "7%", render: function ( data, type, full, meta ) {
                            if(full['company'] == null){
                                return "N/A";
                            }
                            else{
                                return $.camelCase(full['company']);
                            }
                        },
                        "searchable": false,
                        "orderable": true
                    },

                    {
                        title: 'Action', data: '', name: '', width: "7%", render: function ( data, type, full, meta ) {

                            var url = "{{url('admin/clients/view')}}/"+full['id'];
                            var urlEdit = "{{url('admin/clients/update')}}/"+full['id'];
                            return '<a href="'+url+'"><i class="fa fa-eye" title="View case"></i></a> '+
                                ' <a href="'+urlEdit+'"><i class="fa fa-pencil" title="Edit case"></i></a>'+
                                ' <a href="javascript:;"><i class="fa fa-trash swal-warning-cancel" data-id="'+full['id']+'" title="Delete attribute"></i></a>'

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

            $(' body ').on('click','.swal-warning-cancel', function () {
                var id = $(this).attr('data-id');

                swal({
                        title: "Are you sure?",
                        text: "You want to delete this user",
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
                                url: '{{ url('admin/clients/delete') }}',
                                data: {id: id},
                                type:'post',
                                success:function (res) {
                                    if(res.token == 1){
                                        oTable.dataTable().fnDraw();
                                        swal({title: 'Deleted!', text: 'User deleted successfully!', type: 'success', timer: 2000, showCancelButton: false,showConfirmButton: false}).catch(swal.noop);
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



