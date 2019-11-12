@extends('../layouts.master')
@section('title')
    CMS - Cases
@endsection
@section('page_title')
    View Case Details
@endsection
@section('style')
    <style type="text/css">
        td > a {
            margin-left: 10px;
            margin-right: 10px;
        }

        .rw-class {
            margin-bottom: 5px;
            padding-bottom: 30px;
        }
        .margin10{
            margin-left: 10px !important;
        }

        .attach-box {
            text-align: center;
            margin-right: 15px;
            display: block;
            padding: 20px;
            -webkit-box-shadow: 0.5px -0.5px 5.5px 0.5px rgba(0, 0, 0, 0.075);
            -moz-box-shadow: 0.5px -0.5px 5.5px 0.5px rgba(0, 0, 0, 0.075);
            box-shadow: 0.5px -0.5px 5.5px 0.5px rgba(0, 0, 0, 0.075);
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .attach-box img {
            margin: auto;
            display: block;
        }

        .attach-box-action a {
            margin-right: 40px;
            text-align: center;
        }

        .attach-box-action {
            margin-top: 30px;
            text-align: center;
        }

        .cases .rw-class {
            margin-bottom: 10px !important;
            padding-bottom: 25px;
        }

        .cases .page-header {
            margin: 20px 0 20px;
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
                    <li class="active">Case View</li>
                </ol>
            </div>
            <div class="panel-body cases">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-uppercase page-header">Case Details</h4>
                    </div>
                    <div class="col-md-6">
                        <div class="panel mb25">
                            <div class="panel-body">
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Case Number</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $case->case_number }}
                                    </div>
                                </div>
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Date of filing</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ \Carbon\Carbon::parse($case->date_of_filing)->format('d-m-Y') }}
                                    </div>
                                </div>
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Stage</b>
                                    </div>
                                    <div class="col-md-8 {{strtolower(str_replace(' ','_',$case->stage))}}">
                                        {{ $case->stage}}
                                    </div>
                                </div>
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Client</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ \App\User::where('id',$case->user_id)->first()->name}}
                                    </div>
                                </div>
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Opponent Name</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $case->opponent_name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel mb25">
                            <div class="panel-body">
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Court</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $case->court}}
                                    </div>
                                </div>

                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Case Details</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $case->complainant_details }}
                                    </div>
                                </div>

                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Comments</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $case->comments}}
                                    </div>
                                </div>
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Bench</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $caseEntries->bench}}
                                    </div>
                                </div>
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Next Date </b>
                                    </div>
                                    <div class="col-md-8">
                                        @if($caseEntries)
                                            @if($caseEntries->next_date == '' || $caseEntries->next_date == null)
                                                @php
                                                    $diff = \Carbon\Carbon::parse($caseEntries->date)->diffForHumans();
                                                    if (strpos($diff, 'ago') !== false){
                                                        $class = 'ago';
                                                    }else{
                                                        $class = 'after';
                                                    }
                                                @endphp
                                                {{ \Carbon\Carbon::parse($caseEntries->date)->format('d-m-Y') }} <br>
                                                <span class='next-date {{$class}} '>({{ $diff }})</span>
                                            @elseif($caseEntries->date)
                                                @php
                                                    $diff = \Carbon\Carbon::parse($caseEntries->next_date)->diffForHumans();
                                                    if (strpos($diff, 'ago') !== false){
                                                        $class = 'ago';
                                                    }else{
                                                        $class = 'after';
                                                    }
                                                @endphp
                                                {{ \Carbon\Carbon::parse($caseEntries->next_date)->format('d-m-Y') }}
                                                <br><span class='next-date {{$class}} '>({{ $diff }})</span>
                                            @else
                                                N/A
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-uppercase page-header">Case Entries</h4>
                    </div>
                    <div class="col-md-12">
                        <?php if(count($caseEntries) == 0):?>
                        <a href="{{ url('admin/entries/create') }}/{{$case->id}}"
                           class="btn-primary btn btn-round btn-success" style="float: right; margin-bottom: 20px;"><i
                                    class="fa fa-plus"></i>Create new entry</a>
                        <?php endif; ?>
                        <table class="table table-bordered bordered table-striped table-condensed datatable">
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-uppercase page-header">Case Attachments</h4>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <a href="{{ url('admin/attachments/create') }}/{{$case->id}}"
                               class="btn-primary btn btn-round btn-success" style="float: right; margin-bottom: 20px;"><i
                                        class="fa fa-plus"></i> Add attachment</a>
                        </div>
                        @if(!$case->attachment->isEmpty())
                            <div class="attach-box-div">
                                @foreach($case->attachment as $key => $value)
                                    <div class="col-md-4">
                                        <a target="_blank" href=" {{url('attachment')."/".$value->attachment}}">
                                            <div class="attach-box">
                                                @if($value->attachment)
                                                    @if (strpos($value->attachment, '.png') !== false || strpos($value->attachment, '.jpg') !== false || strpos($value->attachment, '.jpeg') !== false || strpos($value->attachment, '.bmp') !== false)
                                                        <h5>{{$value->attachment}}</h5>
                                                        <img width="100" height="100"
                                                             src="{{ url('attachment')."/".$value->attachment }}">
                                                    @else
                                                        <h5>{{$value->attachment}}</h5>
                                                        @if(strpos($value->attachment, '.pdf') !== false)
                                                            <img width="100" height="100"
                                                                 src="{{ url('images')}}/pdf.png">
                                                        @elseif(strpos($value->attachment, '.dox') !== false)
                                                            <img width="100" height="100"
                                                                 src="{{ url('images')}}/doc.png">
                                                        @elseif(strpos($value->attachment, '.csv') !== false)
                                                            <img width="100" height="100"
                                                                 src="{{ url('images')}}/csv.png">
                                                        @else
                                                            <img width="100" height="100"
                                                                 src="{{ url('images')}}/file.png">
                                                        @endif
                                                    @endif
                                                    <div class="attach-box-action">
                                                        <a title="View attachment" target="_blank"
                                                           href=" {{url('attachment')."/".$value->attachment}}"><i
                                                                    class="fa fa-eye"></i></a>
                                                        <a title="Download attachment"
                                                           href="{{url('attachment')."/".$value->attachment}}"
                                                           download=""><i class="fa fa-download"></i></a>
                                                        <a title="Delete attachment" href="javascript:void(0);"
                                                           class="delete-attachment" id="attachment_{{$value->id}}"
                                                           data-id="{{$value->id}}" download=""><i
                                                                    class="fa fa-trash"></i></a>
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="col-md-12">
                                <p class="text-center">No Attachments Available</p>
                            </div>
                        @endif
                    </div>
                </div>


            </div>
        </div>
        @endsection
        @push('jsfiles')
            <script type="text/javascript">
                $(document).ready(function () {
                    oTable = $('.datatable').dataTable({
                        processing: true,
                        serverSide: true,
                        searching: false,
                        select: true,
                        buttons: [],
                        ajax: {
                            url: "{{ url('/api/entries/serverside') }}",
                            data: function (d) {
                                d.case_id = '{{$case->id}}';

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
                                "searchable": false,
                                "orderable": true
                            },
                            {
                                title: 'Next Date',
                                data: 'next_date',
                                name: 'next_date',
                                width: "10%",
                                render: function (data, type, full, meta) {
                                    if (full['next_date'] == null) {
                                        return "N/A";
                                    }
                                    else {
                                        var diff = moment(full['next_date']).fromNow();
                                        if (diff.indexOf('ago') != -1) {
                                            var Cls = 'ago';
                                        } else {
                                            var Cls = 'after'
                                        }
                                        return moment(full['next_date']).format('DD-MM-YYYY') + " <br><span class='next-date " + Cls + " '> (" + diff + ")</span>";
                                    }
                                },
                                "searchable": false,
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
                                "searchable": false,
                                "orderable": true
                            },
                            {
                                title: 'Comments',
                                data: 'comments',
                                name: 'comments',
                                width: "7%",
                                render: function (data, type, full, meta) {
                                    if (full['comments'] == null) {
                                        return "N/A";
                                    }
                                    else {
                                        return $.camelCase(full['comments']);
                                    }
                                },
                                "searchable": false,
                                "orderable": true
                            },
                            {
                                title: 'Is Order',
                                data: 'img',
                                name: 'order',
                                width: "7%",
                                align: "center",
                                render: function (url, type, full) {
                                    if (full['attachment'] == null) {
                                        return '<span class="margin10"><i class="icon-square-cross"></i></span>'
                                    } else {
                                        return '<a class="margin10" href="<?= url('attachment')?>/' + full['attachment'] + '" download>' +
                                            '<i class="fa fa-cloud-download"></i></a>'
                                            +'<img height="50" width="50" src="<?= url('attachment')?>/' + full['attachment'] + '"/>';

                                    }
                                },
                                "searchable": false,
                                "orderable": true
                            },
                            {
                                title: 'Action',
                                data: '',
                                name: '',
                                width: "7%",
                                render: function (data, type, full, meta) {
                                    var urlEdit = "{{url('admin/entries/update')}}/" + full['id'];

                                    return '<a href="javascript:;"><i class="fa fa-trash swal-warning-cancel" data-id="' + full['id'] + '" title="Delete attribute"></i></a>' +
                                        ' <a href="' + urlEdit + '"><i class="fa fa-pencil" title="Edit case"></i></a>';


                                },
                                "searchable": false,
                                "orderable": false
                            }

                        ]
                    });
                    // oTable.DataTable().buttons().container().appendTo( $('.col-sm-6:eq(0)', oTable.DataTable().table().container() ) );
                    $('#search-form').on('submit', function (e) {
                        oTable.dataTable().fnDraw();
                        e.preventDefault();
                    });

                    $('.datatable').on('draw.dt', function () {
                        // alert( 'Table redrawn' );
                        // console.log(oTable.fnGetData());
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
                });


                $(' body ').on('click', '.swal-warning-cancel', function () {
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
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: '{{ url('admin/entries/delete') }}',
                                    data: {id: id},
                                    type: 'post',
                                    success: function (res) {
                                        if (res.token == 1) {
                                            oTable.dataTable().fnDraw();
                                            swal({
                                                title: 'Deleted!',
                                                text: 'Case entry deleted successfully!',
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


                $(' body ').on('click', '.delete-attachment', function () {
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
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: '{{ url('admin/attachments/delete') }}',
                                    data: {id: id},
                                    type: 'post',
                                    success: function (res) {
                                        if (res.token == 1) {
                                            $("#attachment_" + id).parent().parent().parent().remove();
                                            swal({
                                                title: 'Deleted!',
                                                text: 'Attachment deleted successfully!',
                                                type: 'success',
                                                timer: 2000,
                                                showCancelButton: false,
                                                showConfirmButton: false
                                            });
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

            </script>
    @endpush



