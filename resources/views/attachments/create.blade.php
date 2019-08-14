@extends('../layouts.master')
@section('title')
    CMS - Attachments
@endsection
@section('page_title')
    Create New Attachment
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
                    <li class="active">Attachment create</li>
                </ol>
            </div>
            <div class="panel-body">

                <form enctype="multipart/form-data" id="entry_form" action="{{ url('admin/attachments/create') }}" method="post">
                    {{ csrf_field() }}
                    <h3  class="page-header">Create New Attachment</h3>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                                <input value="{{$case->id}}" type="hidden" name="case_id" >
                                <label class="control-label" for="attachment">Attachment <small> (You can select multiple files) </small></label>
                                <input id="attachment" type="file" class="form-control" name="attachment[]" multiple >
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
                    $("#entry_form").validate({
                        rules: {
                            date: {
                                required: true,
                            },

                            stage: {
                                required: true,
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

                $("#date, #next_date").datepicker({
                    format:'dd-mm-yyyy'
                });

            </script>
@endpush



