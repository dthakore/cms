@extends('../layouts.master')
@section('title')
    CMS - Clients
@endsection
@section('page_title')
    Update Client
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
                    <li class="active">Client update</li>
                </ol>
            </div>
            <div class="panel-body">
                <form id="case_form" action="{{ url('admin/clients/save') }}/{{$user->id}}" method="post">
                    {{ csrf_field() }}
                    <h3  class="page-header">Update Client</h3>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">

                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                                <label class="control-label" for="name">Name</label>
                                <input id="name" value="{{ $user->name }}" type="text" class="form-control" name="name" >

                            </div>


                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="email">Email</label>
                                <input id="email" value="{{ $user->email }}" type="text" class="form-control" name="email" >
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="name">Alternate Email</label>
                                <input id="alternate_email" value="{{ $user->alternate_email }}" type="text" class="form-control" name="alternate_email" >

                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="contact_number">Contact Number</label>
                                <input id="contact_number" value="{{ $user->contact_number }}"  type="text" class="form-control" name="contact_number" >
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="contact_number">Company</label>
                                <input id="company" value="{{ $user->company }}"  type="text" class="form-control" name="company" >
                            </div>


                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="email_enabled">Email Enabled</label>
                                <input id="email_enabled" {{ ($user->email_enabled) ? 'checked' : '' }} type="checkbox" class="form-control" name="email_enabled" >

                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="whatsapp_enabled">Whatsapp Enabled</label>
                                <input id="whatsapp_enabled" {{ ($user->whatsapp_enabled) ? 'checked' : '' }} type="checkbox" class="form-control" name="whatsapp_enabled" >
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
                            required: true,
                            email: true,
                            remote: {
                                url: "{{ url('/api/check/email/update') }}",
                                type: "post",
                                data:
                                    {
                                        email: function(){
                                            return $('#case_form :input[name="email"]').val();
                                        },
                                        user: '{{$user->id}}'
                                    }
                            }
                        },
                        contact_number: {
                            number:true,
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
                            number:'Please enter only number',
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



