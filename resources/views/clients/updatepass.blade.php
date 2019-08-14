@extends('../layouts.master')
@section('title')
    CMS - Clients
@endsection
@section('page_title')
    Update Password
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
                    <li class="active">Client Password update</li>
                </ol>
            </div>
            <div class="panel-body">
                <form id="case_form" action="{{ url('clients/pass/save') }}/{{$user->id}}" method="post">
                    {{ csrf_field() }}
                    <h3  class="page-header">Update client password</h3>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                        @if (Session::has('message'))
                            <div class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif
                        @if(\Illuminate\Support\Facades\Session::has('msg'))
                            <h4 class="text-center text-success"><b>Password changed successfully</b></h4>
                        @endif
                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                                <label class="control-label" for="name">Old Password</label>
                                <input id="old_password" type="password" class="form-control" name="oldpassword" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                                <label class="control-label" for="name">New Password</label>
                                <input id="new_password" type="password" class="form-control" name="newpassword" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                                <label class="control-label" for="name">Repeat Password</label>
                                <input id="repeat_password" type="password" class="form-control" name="repeatpassword" >
                            </div>
                        </div>

                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-sm-12">
                            <button type="submit" class="btn btn-success btn-round text-center">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endsection
        @push('jsfiles')
            <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
            <script>
                $("#case_form").validate({
                    rules: {
                        oldpassword: {
                            required: true,
                            remote: {
                                url: "{{ url('/api/check/pass/update') }}",
                                type: "post",
                                data:
                                    {
                                        oldpassword: function(){
                                            return $('#case_form :input[name="oldpassword"]').val();
                                        },
                                        user: '{{$user->id}}'
                                    }
                            }
                        },
                        newpassword: {
                            required: true,

                        },
                        repeatpassword: {
                            required: true,
                            equalTo: "#new_password"
                        }

                    },
                    messages: {
                        oldpassword: {
                            required: "Please enter old password",
                            remote: "Current password do not match"
                        },

                        newpassword: {
                            required: "Please enter new password",
                        },
                        repeatpassword: {
                            required: "Please enter repeat password",
                            equalTo: "Password do not match"
                        },
                    },
                    highlight: function (element, errorClass) {
                        $(element).removeClass(errorClass);
                        $(element).parent().addClass('has-error');
                    },
                    unhighlight: function (element) {
                        $(element).parent().removeClass('has-error');
                    },
                    submitHandler: function (form) {
                        form.submit();
                        return true;
                    }
                });

                $("#date_of_filing, #next_date").datepicker({
                    format:'dd-mm-yyyy'
                });

            </script>
    @endpush



