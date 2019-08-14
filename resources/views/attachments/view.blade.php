@extends('../layouts.master')
@section('title')
    CMS - Attachments
@endsection
@section('page_title')
    View Attachments
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
                        <a href="{{ url('admin/cases/view/')}}/{{ $entries->id  }}">Case view</a>
                    </li>
                    <li class="active">Entry View</li>
                </ol>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-uppercase page-header">Attachments Details</h4>
                    </div>
                    <div class="col-md-6">
                        <div class="panel mb25">
                            <div class="panel-body">
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Date</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ \Carbon\Carbon::parse($entries->date)->format('d-m-Y') }}
                                    </div>
                                </div>
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Coram</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $entries->coram}}
                                    </div>
                                </div>
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Stage</b>
                                    </div>
                                    <div class="col-md-8 {{strtolower(str_replace(' ','_',$entries->stage))}}">
                                        {{ $entries->stage}}
                                    </div>
                                </div>
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Next Date</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ \Carbon\Carbon::parse($entries->next_date)->format('d-m-Y') }} ( After {{ \Carbon\Carbon::parse($entries->next_date)->diffInDays() }} Days )
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
                                        <b>Comments</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $entries->comments}}
                                    </div>
                                </div>
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Attachmetns</b>
                                    </div>
                                    <div class="col-md-8">
                                        <a target="_blank" href="{{ url('attachment') ."/". $entries->attachment }}">{{ $entries->attachment }} <i class="fa fa-eye"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
@endsection

