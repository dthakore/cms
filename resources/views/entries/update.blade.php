@extends('../layouts.master')
@section('title')
    CMS - Entries
@endsection
@section('page_title')
    Update Case Entries
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
                    <li class="active">Entry udpate</li>
                </ol>
            </div>
            <div class="panel-body">
                <form enctype="multipart/form-data" id="entry_form" action="{{ url('admin/entries/save') }}/{{$entries->id}}" method="post">
                    {{ csrf_field() }}
                    <h3  class="page-header">Update New Entry</h3>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">

                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="date">Date *</label>
                                <input id="date" type="text" class="form-control" value="{{\Carbon\Carbon::parse($entries->date)->format('d-m-Y')}}" name="date" >
                                <input value="{{$entries->case_id}}"  type="hidden" name="case_id" >

                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="coram">Coram</label>
                                <input id="coram" type="text" value="{{$entries->coram}}" class="form-control" name="coram" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="stage">Stage *</label>
                                <select id="stage" type="text" class="form-control" name="stage" >
                                    <option></option>
                                    <option {{ ($entries->stage == 'Filing VP') ? 'selected' : '' }} value="Filing VP">Filing VP</option>
                                    <option {{ ($entries->stage == 'To file reply') ? 'selected' : '' }} value="To file reply">To file reply</option>
                                    <option {{ ($entries->stage == 'For rejoinder') ? 'selected' : '' }} value="For rejoinder">For rejoinder</option>
                                    <option {{ ($entries->stage == 'For arguments') ? 'selected' : '' }} value="For arguments">For arguments</option>
                                    <option {{ ($entries->stage == 'For judgment') ? 'selected' : '' }} value="For judgment">For judgment</option>
                                    <option {{ ($entries->stage == 'Disposed') ? 'selected' : '' }} value="Disposed">Disposed</option>
                                </select>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="next_date">Next Date</label>
                                <input id="next_date" type="text" value="{{\Carbon\Carbon::parse($entries->next_date)->format('d-m-Y')}}"  class="form-control" name="next_date" >

                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                                <label class="control-label" for="comments">Comments</label>
                                <textarea rows="10" id="comments"  type="text" class="form-control" name="comments" >{{$entries->comments}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                                <label class="control-label" for="attachment">Attachment</label>
                                <input id="attachment" type="file" class="form-control" name="attachment" value="{{$entries->attachment}}" >
                                @if($entries->attachment)
                                    @if (strpos($entries->attachment, '.pdf') !== false || strpos($entries->attachment, '.docx') !== false || strpos($entries->attachment, '.pdf') !== false || strpos($entries->attachment, '.csv') !== false)
                                        <a target="_blank" href=" {{url('attachment')."/".$entries->attachment}}"> {{$entries->attachment}} </a>
                                    @else
                                        <img src="{{ url('attachment')."/".$entries->attachment }}" width="140" style="margin-top: 20px">
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-sm-12">
                            <button type="submit" class="btn btn-success btn-round text-center">Save</button>
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



