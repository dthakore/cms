@extends('../layouts.master')
@section('title')
    CMS - Cases
@endsection
@section('page_title')
    Create New Case
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
    <div class="eq-col">
        <div class="relative full-height">
            <div class="display-row">

                <!-- error wrapper -->
                <div class="center-wrapper error-page">
                    <div class="center-content text-center">
                        <div class="error-number">
                            <span>404</span>
                        </div>
                        <div class="h5">PAGE NOT FOUND</div>
                        <p>Sorry, but the page you were trying to view does not exist.</p>
                        <a href="{{url('/')}}">Go to login page</a>
                    </div>
                </div>
                <!-- /error wrapper -->

            </div>
        </div>
    </div>
@endsection




