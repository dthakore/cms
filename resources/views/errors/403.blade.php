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
                            <span>403</span>
                        </div>
                        <div class="h5">Restricred Area</div>
                        <p>Sorry, but you don't have rights to access this page.</p>
                    </div>
                </div>
                <!-- /error wrapper -->

            </div>
        </div>
    </div>
@endsection




