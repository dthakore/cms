@extends('../layouts.master')
@section('title')
    CMS - Cases
@endsection
@section('page_title')
    Create New Case
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
@endsection
@section('content')
    <div class="main-content">
        <div class="panel">
            <div class="panel-heading border">
                <ol class="breadcrumb mb0 no-padding">
                    <li>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="active">Case create</li>
                </ol>
            </div>
            <div class="panel-body">
                <form id="case_form" action="{{ url('admin/cases/create') }}" method="post" class="form-horizontal"
                      role="form" novalidate="novalidate">
                    {{ csrf_field() }}
                    <h3 class="page-header">Create New Case</h3>
                    <div class="box-tab justified" id="rootwizard">
                        <ul class="nav nav-tabs margin-bottom10">
                            <li id="tab1-li" class="active"><a href="#tab1" data-toggle="tab" aria-expanded="true">Forum details</a>
                            </li>
                            <li id="tab2-li" ><a href="#tab2" data-toggle="tab">Case Details</a></li>
                            <li id="tab3-li" ><a href="#tab3" data-toggle="tab">Additional Information</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="form-group"><label class="col-sm-2 control-label">Select Forum</label>
                                    <div class="col-sm-4">
                                        <select id="forum" type="text" class="form-control" name="forum">
                                            <option value="0"> Select</option>
                                            <option value="sc">Supreme Court</option>
                                            <option value="hc">High Courts</option>
                                            <option value="dc">District Courts</option>
                                            <option value="cf">Consumer Forums</option>
                                            <option value="tribunals">Tribunals</option>
                                            <option value="cn">CNR Number</option>
                                            <option value="cc">Custom Courts</option>
                                            <option value="other">Other Options</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group hide" id="dc-form"><label
                                            class="col-sm-2 control-label">State</label>
                                    <div class="col-sm-4">
                                        <select id="state" type="text" class="form-control" name="state">
                                            <option value="0"> Select</option>
                                            <option value="NCDRC">NCDRC</option>
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Rajasthan">Rajasthan</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 control-label" for="statecommission">District</label>
                                    <div class="col-sm-4" id="district">
                                        <select id="select-box" class="form-control">
                                            <option>Select</option>
                                        </select>
                                        <select id="id-Rajasthan" class="form-control" for="Rajasthan"
                                                style="display: none;"
                                                name="id-Rajasthan">
                                            <option value="">Select</option>
                                            <option value="Ajmer">Ajmer</option>
                                            <option value="Alwar">Alwar</option>
                                            <option value="Banswara">Banswara</option>
                                            <option value="Baran">Baran</option>
                                            <option value="Barmer">Barmer</option>
                                            <option value="Bharatpur">Bharatpur</option>
                                            <option value="Bhilwara">Bhilwara</option>
                                            <option value="Bikaner">Bikaner</option>
                                            <option value="Bundi">Bundi</option>
                                            <option value="Chittaurgarh">Chittaurgarh</option>
                                            <option value="Churu">Churu</option>
                                            <option value="Dausa">Dausa</option>
                                            <option value="Dhaulpur">Dhaulpur</option>
                                            <option value="Dungarpur">Dungarpur</option>
                                            <option value="Ganganagar">Ganganagar</option>
                                            <option value="Hanumangarh">Hanumangarh</option>
                                            <option value="Jaipur-I">Jaipur-I</option>
                                            <option value="Jaipur-II">Jaipur-II</option>
                                            <option value="Jaipur-III">Jaipur-III</option>
                                            <option value="Jaipur-IV">Jaipur-IV</option>
                                            <option value="Jaisalmer">Jaisalmer</option>
                                            <option value="Jalor">Jalor</option>
                                            <option value="Jhalawar">Jhalawar</option>
                                            <option value="Jhunjhunun">Jhunjhunun</option>
                                            <option value="Jodhpur">Jodhpur</option>
                                            <option value="Jodhpur-II">Jodhpur-II</option>
                                            <option value="Karauli">Karauli</option>
                                            <option value="Kota">Kota</option>
                                            <option value="Nagaur">Nagaur</option>
                                            <option value="Pali">Pali</option>
                                            <option value="Pratapgarh">Pratapgarh</option>
                                            <option value="Rajsamand">Rajsamand</option>
                                            <option value="Sawai Madhopu">Sawai Madhopur</option>
                                            <option value="Sikar">Sikar</option>
                                            <option value="Sirohi">Sirohi</option>
                                            <option value="Tonk">Tonk</option>
                                            <option value="Udaipur">Udaipur</option>
                                        </select>
                                        <select id="id-Gujarat" class="form-control" for="Gujarat" style="display: none"
                                                name="id-Gujarat">
                                            <option value="">Select</option>
                                            <option value="Ahmedabad Addl">Ahmedabad Addl</option>
                                            <option value="Ahmedabad City">Ahmedabad City</option>
                                            <option value="Ahmedabad Rural">Ahmedabad Rural</option>
                                            <option value="Amreli">Amreli</option>
                                            <option value="Anand">Anand</option>
                                            <option value="Aravalli">Aravalli</option>
                                            <option value="Banas Kantha">Banas Kantha</option>
                                            <option value="Bharuch">Bharuch</option>
                                            <option value="Bhavnagar">Bhavnagar</option>
                                            <option value="Botad">Botad</option>
                                            <option value="Chhota Udaipur">Chhota Udaipur</option>
                                            <option value="Devbhumi Dwarka">Devbhumi Dwarka</option>
                                            <option value="Dohad">Dohad</option>
                                            <option value="Gandhinagar">Gandhinagar</option>
                                            <option value="Girsomnath">Girsomnath</option>
                                            <option value="Jamnagar">Jamnagar</option>
                                            <option value="Junagadh">Junagadh</option>
                                            <option value="Kachchh">Kachchh</option>
                                            <option value="Kheda">Kheda</option>
                                            <option value="Mahesana">Mahesana</option>
                                            <option value="Mahisagar">Mahisagar</option>
                                            <option value="Morbi">Morbi</option>
                                            <option value="Narmada">Narmada</option>
                                            <option value="Navsari">Navsari</option>
                                            <option value="Panch Mahals">Panch Mahals</option>
                                            <option value="Patan">Patan</option>
                                            <option value="Porbandar">Porbandar</option>
                                            <option value="Rajkot">Rajkot</option>
                                            <option value="Rajkot Addl">Rajkot Addl</option>
                                            <option value="Rajpipla">Rajpipla</option>
                                            <option value="Sabar kantha">Sabar kantha</option>
                                            <option value="Surat">Surat</option>
                                            <option value="Surat Addl">Surat Addl</option>
                                            <option value="Surendranagar">Surendranagar</option>
                                            <option value="Tapi">Tapi</option>
                                            <option value="The Dangs">The Dangs</option>
                                            <option value="Vadodara">Vadodara</option>
                                            <option value="Vadodra Addl">Vadodra Addl</option>
                                            <option value="Valsad">Valsad</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row hide" id="court-field">
                                    <label class="col-sm-2 control-label" for="court">Court</label>
                                    <div class="col-sm-4">
                                        <input id="court" type="text" class="form-control" name="court"/>
                                    </div>
                                </div>
                                <div class="form-group row" id="casetype_form">
                                    <label class="col-sm-2 control-label" for="case_type">Case Type</label>
                                    <div class="col-sm-4" id="casetype_label">
                                        <input id="case_type" type="text" class="form-control" name="case_type">
                                    </div>
                                </div>
                                <div class="wizard-pager">
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-default button-previous disabled">Previous
                                        </button>
                                        <a type="button" data-toggle="tab" class="btn btn-primary button-next"
                                           href="#tab2">Next</a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label" for="case_number">Case Number</label>
                                    <div class="col-sm-4">
                                        <input id="case_number" type="text" class="form-control" name="case_number">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label" for="applicant">Are you Applicant?</label>
                                    <div class="col-sm-4">
                                        <h5>
                                            <input type="radio" name="applicant" value="0"> Yes
                                            <input type="radio" name="applicant" value="1"> No</h5>
                                    </div>
                                </div>
                                <div class="row hide" id="applicant-yes">

                                </div>
                                <div class="row hide" id="applicant-no">

                                </div>
                                <div class="wizard-pager">
                                    <div class="pull-right">
                                        <a type="button" data-toggle="tab" href="#tab1"
                                           class="btn btn-default  button-previous">Previous
                                        </a>
                                        <a type="button" data-toggle="tab" class="btn btn-primary button-next"
                                           href="#tab3">Next</a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab3">
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label" for="date_of_filing">Date of Filing</label>
                                    <div class="col-sm-4">
                                        <input id="date_of_filing" type="text" class="form-control" name="date_of_filing">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label" for="stage">Stage</label>
                                    <div class="col-sm-4">
                                        <select id="stage" type="text" class="form-control" name="stage">
                                            <option></option>
                                            <option value="Filing VP">Filing VP</option>
                                            <option value="To file reply">To file reply</option>
                                            <option value="For rejoinder">For rejoinder</option>
                                            <option value="For arguments">For arguments</option>
                                            <option value="For judgment">For judgment</option>
                                            <option value="Disposed">Disposed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label" for="complainant_details">Complainant Details</label>
                                    <div class="col-sm-4">
                                        <textarea rows="10" id="complainant_details" type="text" class="form-control"
                                                  name="complainant_details"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label" for="comments">Case Comments</label>
                                    <div class="col-sm-4">
                                        <textarea rows="10" id="comments" type="text" class="form-control"
                                                  name="comments"></textarea>
                                    </div>
                                </div>
                                <div class="wizard-pager">
                                    <div class="pull-right">
                                        <a type="button" data-toggle="tab" href="#tab2"
                                           class="btn btn-default  button-previous">Previous
                                        </a>
                                        <button type="submit" class="btn btn-primary button-next">Submit</button>
                                    </div>
                                </div>
                            </div>
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
                    $('#district').hide();
                    $("#select-box").hide();
                    if (selectedValue == 0) {
                        $('#district').show();
                        $("#select-box").show();
                        $("#id-Gujarat").hide();
                        $("#id-Rajasthan").hide();
                    }
                    if (selectedValue === 'Rajasthan') {
                        $('#district').show();
                        $("#id-Gujarat").hide();
                    }
                    if (selectedValue === 'Gujarat') {
                        $('#district').show();
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
                $('#forum').change(function () {
                    var selectedValue = $(this).val();
                    $('body').find('#court_form').remove();
                    $('#court-field').addClass('hide');
                    if (selectedValue === 'hc') {
                        $('#dc-form').addClass('hide');
                        $("<div class=\"form-group row\" id=\"court_form\"><label class=\"col-sm-2 control-label\" for=\"court\">Select Court</label><div class=\"col-sm-4\" id=\"court_label\">" +
                            "<select id=\"court\" type=\"text\" class=\"form-control\" name=\"court\"><option value='Rajasthan High Court at Jodhpur'>Rajasthan High Court at Jodhpur</option><option value='Rajasthan High Court at Jaipur'>Rajasthan High Court at Jaipur</option>" +
                            "<option value='Gujarat High Court'>Gujarat High Court</option></select></div></div>").insertBefore("#casetype_form");
                    } else if (selectedValue === 'dc' || selectedValue === 'cf') {
                        $('#dc-form').removeClass('hide');
                        $('#court-field').removeClass('hide');
                    } else if (selectedValue === 'sc') {
                        $('#dc-form').addClass('hide');
                        $('#court-field').addClass('hide');
                    } else {
                        $('#dc-form').addClass('hide');
                        $('#court-field').removeClass('hide');
                    }

                });
                $('[name="applicant"]').change(function () {
                    $('[name="applicant"]:checked').each(function () {
                        if (this.value == 0) {
                            $("#applicant-yes").removeClass('hide');
                            $("#applicant-no").addClass('hide');
                            $("#applicant-yes").empty();
                            $("#applicant-no").empty();
                            $("#applicant-yes").append('<div class="form-group row"><label class="col-sm-2 control-label" for="client">Client</label><div class="col-sm-4"><select id="user_id" type="text" class="form-control" name="user_id"><option></option><?php foreach($users as $user): ?><option value="<?php echo $user->id;?>"><?php echo $user->name;?></option><?php endforeach; ?></select></div></div><div class="form-group row"><label class="col-sm-2 control-label" for="role1">Client Role</label><div class="col-sm-4"><select id="client_role" type="text" class="form-control" name="client_role"><option value="Petitioner">Petitioner</option><option value="Appellant">Appellant</option><option value="Applicant">Applicant</option><option value="Complainant">Complainant</option></select></div></div>' +
                                '<div class="form-group row"><label class="col-sm-2 control-label" for="stage">Opponent Name</label><div class="col-sm-4"><input id="opponent_name" type="text" class="form-control" name="opponent_name"></div></div><div class="form-group row"><label class="col-sm-2 control-label" for="stage">Opponent Role</label><div class="col-sm-4"><select id="opponent_role" type="text" class="form-control" name="opponent_role"><option value="Respondent">Respondent</option><option value="Opponent">Opponent</option><option value="Accused">Accused</option></select></div></div><div class="form-group row"><label class="col-sm-2 control-label" for="role2advocate">Opponent Advocate(s)</label><div class="col-sm-4"><input id="opponent_advocate" type="text" class="form-control" name="opponent_advocate"></input></div></div>').find('#applicant-yes');
                        }
                        if (this.value == 1) {
                            $("#applicant-no").removeClass('hide');
                            $("#applicant-yes").addClass('hide');
                            $("#applicant-yes").empty();
                            $("#applicant-no").empty();
                            $("#applicant-no").append('<div class="form-group row"><label class="col-sm-2 control-label" for="stage">Applicant Name</label><div class="col-sm-4"><input id="opponent_name" type="text" class="form-control" name="opponent_name"></div></div><div class="form-group row"><label class="col-sm-2 control-label" for="stage">Applicant Role</label><div class="col-sm-4"><select id="opponent_role" type="text" class="form-control" name="opponent_role"><option value="Petitioner">Petitioner</option><option value="Appellant">Appellant</option><option value="Applicant">Applicant</option><option value="Complainant">Complainant</option></select></div></div><div class="form-group row"><label class="col-sm-2 control-label" for="role1advocate">Applicant Advocate(s)</label><div class="col-sm-4"><input id="opponent_advocate" type="text" class="form-control" name="opponent_advocate"></input></div></div><div class="form-group row"><label class="col-sm-2 control-label" for="client">Client</label><div class="col-sm-6"><select id="user_id" type="text" class="form-control" name="user_id"><option></option><?php foreach($users as $user): ?><option value="<?php echo $user->id; ?>"><?php echo $user->name;?></option><?php endforeach; ?></select></div></div><div class="form-group row"><label class="col-sm-2 control-label" for="role1">Client Role</label><div class="col-sm-6"><select id="client_role" type="text" class="form-control" name="client_role"><option value="Respondent">Respondent</option><option value="Opponent">Opponent</option><option value="Accused">Accused</option></select></div></div>').find('#applicant-no'); // append the select and find it

                        }
                    });
                });


                $("#date_of_filing, #next_date").datepicker({
                    format: 'dd-mm-yyyy'
                });
                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    $(".nav li").removeClass("active");
                    var id = e.target.getAttribute('href');
                    $(id+'-li').addClass('active');
                })

            </script>
    @endpush



