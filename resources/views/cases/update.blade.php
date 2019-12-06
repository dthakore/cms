@extends('../layouts.master')
@section('title')
    CMS - Cases
@endsection
@section('page_title')
    Update Case Details
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
                    <li class="active">Case Update</li>
                </ol>
            </div>
            <div class="panel-body">
                <form id="case_form" action="{{ url('admin/cases/save/')."/".$case->id }}" method="post">
                    {{ csrf_field() }}
                    <h3 class="page-header">Update New Case</h3>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                        <div class="form-group row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-sm-12">
                                <label class="control-label" for="stage">Client</label>
                                <select id="user_id" type="text" class="form-control" name="user_id">
                                    <option>Select client</option>
                                    @foreach($users as $user)
                                        <option {{ ($case->user_id == $user->id ? 'selected' : '') }} value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-sm-12">
                                <label class="control-label" for="case_number">Case Number</label>
                                <input id="case_number" value="{{$case->case_number}}" type="text" class="form-control"
                                       name="case_number">

                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-sm-12">
                                <label class="control-label" for="opponent_name">Opponent Name</label>
                                <input id="opponent_name" value="{{$case->opponent_name}}" type="text"
                                       class="form-control" name="opponent_name">

                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                                <label class="control-label" for="complainant_details">Complainant Details</label>
                                <textarea rows="10" id="complainant_details" type="text" class="form-control"
                                          name="complainant_details">{{$case->complainant_details}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="date_of_filing">Date of Filing</label>
                                <div class="input-prepend input-group "><span class="add-on input-group-addon"><i
                                                class="fa fa-calendar"></i></span>
                                    <input id="date_of_filing" type="text"
                                           value="{{\Carbon\Carbon::parse($case->date_of_filing)->format('d-m-Y')}}"
                                           class="form-control" name="date_of_filing">
                                </div>

                            </div>

                            {{--<div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">--}}
                            {{--<label class="control-label" for="court">Court</label>--}}
                            {{--<input id="court" type="text" value="{{$case->court}}" class="form-control" name="court" >--}}
                            {{--</div>--}}
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="stage">Stage</label>
                                <select id="stage" type="text" class="form-control" name="stage">
                                    <option>Select stage</option>
                                    <option {{ ($case->stage == 'Filing VP') ? 'selected' : '' }} value="Filing VP">
                                        Filing VP
                                    </option>
                                    <option {{ ($case->stage == 'To file reply') ? 'selected' : '' }} value="To file reply">
                                        To file reply
                                    </option>
                                    <option {{ ($case->stage == 'For rejoinder') ? 'selected' : '' }} value="For rejoinder">
                                        For rejoinder
                                    </option>
                                    <option {{ ($case->stage == 'For arguments') ? 'selected' : '' }} value="For arguments">
                                        For arguments
                                    </option>
                                    <option {{ ($case->stage == 'For judgment') ? 'selected' : '' }} value="For judgment">
                                        For judgment
                                    </option>
                                    <option {{ ($case->stage == 'Disposed') ? 'selected' : '' }} value="Disposed">
                                        Disposed
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                                <label class="control-label" for="comments">Case Comments</label>
                                <textarea rows="10" id="comments" type="text" class="form-control"
                                          name="comments">{{$case->comments}}</textarea>
                            </div>
                        </div>


                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-sm-12">
                            <button type="submit" class="btn btn-success btn-round text-center">Update</button>
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
                        case_number: {
                            required: true,
                        },
                        opponent_name: {
                            required: true,
                        },
                        date_of_filing: {
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
                $('#state').change(function () {
                    var selectedValue = $(this).val();
                    $("#id-" + selectedValue).show();
                    $("#select-box").hide();
                    if (selectedValue == 0) {
                        $("#select-box").show();
                        $("#id-Gujarat").hide();
                        $("#id-Rajasthan").hide();
                    }
                    if (selectedValue === 'Rajasthan') {
                        $("#id-Gujarat").hide();
                    }
                    if (selectedValue === 'Gujarat') {
                        $("#id-Rajasthan").hide();
                    }

                });
                $('#court').change(function () {
                    var selectedValue = $(this).val();
                    if (selectedValue === 'Other') {
                        $('#other').removeClass('hide');
                    } else {
                        $('#other').addClass('hide');
                    }

                });

                $("#date_of_filing, #next_date").datepicker({
                    format: 'dd-mm-yyyy'
                });

            </script>
    @endpush



