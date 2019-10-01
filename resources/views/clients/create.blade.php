@extends('../layouts.master')
@section('title')
    CMS - Clients
@endsection
@section('page_title')
    Create New Client
@endsection
@section('style')
    <style type="text/css">
        td > a {
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
                    <li class="active">Client create</li>
                </ol>
            </div>
            <div class="panel-body">
                <form id="case_form" action="{{ url('admin/clients/create') }}" method="post">
                    {{ csrf_field() }}
                    <h3 class="page-header">Create New Client</h3>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">

                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="name">Name</label>
                                <input id="case_number" type="text" class="form-control" name="name">

                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="email">Email</label>
                                <input id="email" type="text" class="form-control" name="email">

                            </div>
                            {{--<div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">--}}
                            {{--<label class="control-label" for="password">Password</label>--}}
                            {{--<input id="password"  type="password" class="form-control" name="password" >--}}

                            {{--</div>--}}
                        </div>

                        <div class="form-group row">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="name">Alternate Email</label>
                                <input id="alternate_email" type="text" class="form-control" name="alternate_email">

                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="contact_number">Contact Number</label>
                                <input id="contact_number" type="text" class="form-control" name="contact_number">
                            </div>

                        </div>

                        <div class="form-group row">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="contact_number">Company</label>
                                <input id="company" type="text" class="form-control" name="company">
                            </div>
                            @if(auth()->user()->hasRole(['super_admin']))
                                <div class="form-group row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                        <label class="control-label" for="email_enabled">Role</label>
                                        <select class="form-control" id="roles" name="role">
                                            <option value=""></option>
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>
                                </div>
                            @endif


                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="whatsapp_enabled">Whatsapp Enabled</label>
                                <input id="whatsapp_enabled" type="checkbox" class="form-control"
                                       name="whatsapp_enabled">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="email_enabled">Email Enabled</label>
                                <input id="email_enabled" type="checkbox" class="form-control" name="email_enabled">

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
                        name: {
                            required: true,
                        },
                        email: {
                            required: false,
                            email: true,
                            remote: {
                                url: "{{ url('/api/check/email') }}",
                                type: "post"
                            }
                        },
                        contact_number: {
                            number: true,
                        },
                        password: {
                            required: true,
                        },

                    },
                    messages: {
                        name: {
                            required: "Please enter name",
                        },
                        email: {
                            required: "Please Enter Email!",
                            email: "This is not a valid email!",
                            remote: "Email already in use!"
                        },

                        contact_number: {
                            number: 'Please enter only number',
                        },
                        password: {
                            required: "Please enter password",
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
                    format: 'dd-mm-yyyy'
                });

            </script>
    @endpush



