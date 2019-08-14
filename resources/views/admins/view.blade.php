@extends('../layouts.master')
@section('title')
    CMS - Users
@endsection
@section('page_title')
    View User Details
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
                    <li class="active">Admin View</li>
                </ol>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{url('admin/adminlist')}}" class="btn btn-primary btn-round" style="float: right;">Go to admin list</a>
                        <h4 class="text-uppercase dashboard-headings">User Details</h4>
                    </div>
                    <div class="col-md-6">
                        <div class="panel mb25">
                            <div class="panel-body">
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Name</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $user->name }}
                                    </div>
                                </div>
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Email</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $user->email}}
                                    </div>
                                </div>
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Contact Number</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $user->contact_number}}
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
                                        <b>Alternate Email</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $user->alternate_email }}
                                    </div>
                                </div>
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Company</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $user->company }}
                                    </div>
                                </div>
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Whatsapp Enabled</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ ($user->whatsapp_enabled) ? 'Activate' : 'Deactivate'}}
                                    </div>
                                </div>
                                <div class="rw-class">
                                    <div class="col-md-4">
                                        <b>Email Enabled</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ ($user->email_enabled) ? 'Activate' : 'Deactivate'}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



            </div>
        </div>
@endsection
@push('jsfiles')
@endpush



