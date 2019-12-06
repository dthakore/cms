@extends('../layouts.master')
@section('title')
    CMS - Entries
@endsection
@section('page_title')
    Create New Entries
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
                    <li class="active">Entry create</li>
                </ol>
            </div>
            <div class="panel-body">
                <form enctype="multipart/form-data" id="entry_form" action="{{ url('admin/entries/create') }}"
                      method="post">
                    {{ csrf_field() }}
                    <h3 class="page-header">Create New Entry</h3>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">

                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                @if($next_date == '')
                                    <label class="control-label" for="date">Date*</label>
                                    <div class="input-prepend input-group "><span
                                                class="add-on input-group-addon"><i
                                                    class="fa fa-calendar"></i></span>
                                        <input id="date" type="text" class="form-control" name="date">
                                    </div>
                                    <input value="{{$case->id}}" type="hidden" name="case_id">
                                @else
                                    <label class="control-label" for="date">Date*</label>
                                    {{--<input id="date" type="text" class="form-control" name="date" value="{{$next_date}}">--}}
                                    {!! Form::text('date', "$next_date", ['class'=>'form-control','readonly']) !!}
                                    <input value="{{$case->id}}" type="hidden" name="case_id">

                                @endif
                            </div>

                            {{--<div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">--}}
                            {{--<label class="control-label" for="coram">Coram</label>--}}
                            {{--<input id="coram" type="text" class="form-control" name="coram" >--}}
                            {{--</div>--}}

                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="coram">Bench</label>
                                <input id="bench" type="text" class="form-control" name="bench">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="stage">Stage *</label>
                                <select id="stage" type="text" class="form-control" name="stage">
                                    <option>Select stage</option>
                                    <option value="Filing VP">Filing VP</option>
                                    <option value="To file reply">To file reply</option>
                                    <option value="For rejoinder">For rejoinder</option>
                                    <option value="For arguments">For arguments</option>
                                    <option value="For judgment">For judgment</option>
                                    <option value="Disposed">Disposed</option>
                                </select>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="next_date">Next Date*</label>
                                <div class="input-prepend input-group "><span
                                            class="add-on input-group-addon"><i
                                                class="fa fa-calendar"></i></span>
                                    <input id="next_date" type="text" class="form-control" name="next_date">
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                                <label class="control-label" for="comments">Case Comments</label>
                                <textarea rows="10" id="comments" type="text" class="form-control"
                                          name="comments"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                                <input name="is_order" id="is_order" type="checkbox" onchange="isOrder()"> Is An Order
                            </div>
                        </div>

                        <div class="form-group row hide" id="attachment-div">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                                <label class="control-label" for="attachment">Attachment</label>
                                <input id="attachment" type="file" class="form-control" name="attachment">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                                <input name="send_mail" id="mailbox" type="checkbox" onchange="valueChanged()"> Send
                                Email
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                                <div name="content" id="content" class="maileditor" hidden>
                                    <span>
                                        Dear Sir/Madam,
                                    </span> <br><br><br>
                                    [body] <br><br>
                                    <span>
                                        Regards,<br>
                                        Chaitanya Joshi | Advocate <br>
                                        Nachiketa Associates
                                    </span>
                                </div>
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
            <script src="../../../vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
            <script src="../../../vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
            <script>
                function valueChanged() {
                    if ($('#mailbox').is(':checked')) {
                        $('#cke_content').show();
                        CKEDITOR.replace('content');
                        $('#mail-content').val(CKEDITOR.instances.content.getData());
                        $('.maileditor').ckeditor();
                    } else {
                        $('#cke_content').hide();
                    }
                }

                function isOrder() {
                    if ($('#is_order').is(':checked')) {
                        $('#attachment-div').removeClass('hide');
                    } else {
                        $('#attachment-div').addClass('hide');
                    }
                }

                // var element = CKEDITOR.dom.element.createFromHtml( '<span>Dear Sir/Mam,</span>' );
                // CKEDITOR.instances.content.insertElement( element );

                $("#entry_form").validate({
                    rules: {
                        date: {
                            required: true,
                        },
                        stage: {
                            required: true,
                        },
                        next_date: {
                            required: true
                        }
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
                    format: 'yyyy-mm-dd',
                    startDate: new Date($("input[name=date]").val()),
                    todayHighlight: true,
                });

            </script>
    @endpush



