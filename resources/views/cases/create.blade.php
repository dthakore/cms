@extends('../layouts.master')
@section('title')
    CMS - Cases
@endsection
@section('page_title')
    Create New Case
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
                    <li class="active">Case create</li>
                </ol>
            </div>
            <div class="panel-body">
                <form id="case_form" action="{{ url('admin/cases/create') }}" method="post">
                    {{ csrf_field() }}
                    <h3 class="page-header">Create New Case</h3>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="statecommission">Commission</label>
                                <select id="state" type="text" class="form-control" name="state">
                                    <option value="0"> Select</option>
                                    <option value="NCDRC">NCDRC</option>
                                    <option value="Gujarat">Gujarat</option>
                                    <option value="Rajasthan">Rajasthan</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12" id="district">
                                <label class="control-label" for="statecommission">District</label>
                                <select id="select-box" class="form-control">
                                    <option>Select</option>
                                </select>
                                <select id="id-Rajasthan" class="form-control" for="Rajasthan" style="display: none;"
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
                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="court">Court</label>
                                <select id="court" type="text" class="form-control" name="court">
                                    <option value="0"> Select</option>
                                    <option value="High-Court">High Court</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12 hide" id="other">
                                <label class="control-label" for="other-court">Other</label>
                                <input id="other-court" type="text" class="form-control" name="other-court"/>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="form-group row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-sm-12">
                                <label class="control-label" for="case_number">Case Number</label>
                                <input id="case_number" type="text" class="form-control" name="case_number">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <h5><label class="control-label" for="applicant">Are you Applicant?</label>
                                    <input type="radio" name="applicant" value="0"> Yes
                                    <input type="radio" name="applicant" value="1"> No</h5>
                            </div>
                        </div>
                        <div class="form-group row hide" id="applicant-yes">

                        </div>
                        <div class="form-group row hide" id="applicant-no">

                        </div>
                        <br>

                        <div class="form-group row">
                            {{--<div class="col-lg-4 col-md-4 col-sm-4 col-sm-12">--}}
                            {{--<label class="control-label" for="stage">Client</label>--}}
                            {{--<select id="user_id" type="text" class="form-control" name="user_id">--}}
                            {{--<option></option>--}}
                            {{--@foreach($users as $user)--}}
                            {{--<option value="{{$user->id}}">{{$user->name}}</option>--}}
                            {{--@endforeach--}}
                            {{--</select>--}}
                            {{--</div>--}}



                            {{--<div class="col-lg-4 col-md-4 col-sm-4 col-sm-12">--}}
                            {{--<label class="control-label" for="opponent_name">Opponent Name</label>--}}
                            {{--<input id="opponent_name" type="text" class="form-control" name="opponent_name">--}}

                            {{--</div>--}}
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                                <label class="control-label" for="complainant_details">Complainant Details</label>
                                <textarea rows="10" id="complainant_details" type="text" class="form-control"
                                          name="complainant_details"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <label class="control-label" for="date_of_filing">Date of Filing</label>
                                <input id="date_of_filing" type="text" class="form-control" name="date_of_filing">

                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                    <label class="control-label" for="stage">Stage</label>
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
                            {{--<div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">--}}
                            {{--<label class="control-label" for="court">Court</label>--}}
                            {{--<input id="court" type="text" class="form-control" name="court">--}}
                            {{--</div>--}}
                        </div>


                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
                                <label class="control-label" for="comments">Case Comments</label>
                                <textarea rows="10" id="comments" type="text" class="form-control"
                                          name="comments"></textarea>
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
                $('[name="applicant"]').change(function () {
                    $('[name="applicant"]:checked').each(function () {
                        if (this.value == 0) {
                            $("#applicant-yes").removeClass('hide');
                            $("#applicant-no").addClass('hide');
                            $("#applicant-yes").empty();
                            $("#applicant-no").empty();
                            $("#applicant-yes").append('<div class="col-lg-6 col-md-6 col-sm-6 col-sm-12"><label class="control-label" for="client">Client</label><select id="user_id" type="text" class="form-control" name="user_id"><option></option><?php foreach($users as $user): ?><option value="<?php echo $user->id;?>"><?php echo $user->name;?></option><?php endforeach; ?></select></div><div class="col-lg-6 col-md-6 col-sm-6 col-sm-12"><label class="control-label" for="role1">Client Role</label><select id="client_role" type="text" class="form-control" name="client_role"><option value="Petitioner">Petitioner</option><option value="Appellant">Appellant</option><option value="Applicant">Applicant</option><option value="Complainant">Complainant</option></select></div><div class="col-lg-6 col-md-6 col-sm-6 col-sm-12"><label class="control-label" for="stage">Opponent Name</label><input id="opponent_name" type="text" class="form-control" name="opponent_name"></div><div class="col-lg-6 col-md-6 col-sm-6 col-sm-12"><label class="control-label" for="stage">Opponent Role</label><select id="opponent_role" type="text" class="form-control" name="opponent_role"><option value="Respondent">Respondent</option><option value="Opponent">Opponent</option><option value="Accused">Accused</option></select></div>').find('#applicant-yes');
                        }
                        if (this.value == 1) {
                            $("#applicant-no").removeClass('hide');
                            $("#applicant-yes").addClass('hide');
                            $("#applicant-yes").empty();
                            $("#applicant-no").empty();
                            $("#applicant-no").append('<div class="col-lg-6 col-md-6 col-sm-6 col-sm-12"><label class="control-label" for="stage">Applicant Name</label><input id="opponent_name" type="text" class="form-control" name="opponent_name"></div><div class="col-lg-6 col-md-6 col-sm-6 col-sm-12"><label class="control-label" for="stage">Applicant Role</label><select id="opponent_role" type="text" class="form-control" name="opponent_role"><option value="Petitioner">Petitioner</option><option value="Appellant">Appellant</option><option value="Applicant">Applicant</option><option value="Complainant">Complainant</option></select></div><div class="col-lg-6 col-md-6 col-sm-6 col-sm-12"><label class="control-label" for="client">Client</label><select id="user_id" type="text" class="form-control" name="user_id"><option></option><?php foreach($users as $user): ?>
                                <option value="<?php echo $user->id; ?>"><?php echo $user->name;?>
                                </option><?php endforeach; ?></select></div><div class="col-lg-6 col-md-6 col-sm-6 col-sm-12"><label class="control-label" for="role1">Client Role</label><select id="client_role" type="text" class="form-control" name="client_role"><option value="Respondent">Respondent</option><option value="Opponent">Opponent</option><option value="Accused">Accused</option></select></div>').find('#applicant-no'); // append the select and find it

                        }
                    });
                });


                $("#date_of_filing, #next_date").datepicker({
                    format: 'dd-mm-yyyy'
                });

            </script>
    @endpush



