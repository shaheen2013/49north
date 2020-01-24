{{-- \resources\views\users\edit.blade.php --}}

@extends('layouts.main')

@section('title', $user->exists ? 'Edit ' . $user->name : 'Add User')

@section('content1')

    <div class="tab-pane fade show active" id="nav-employee" role="tabpanel" aria-labelledby="nav-employee-tab">

        {{ Form::model($user, ['url' => route('users.store')]) }}
        {!! Form::hidden('id') !!}

        <div class="personal">
            <h2 class="form_title">Personal Information</h2>
            <div class="row">

                <div class="col-md-3">
                    <div class="text_outer">

                        {{ Form::label('firstname', 'First Name') }}
                        {{ Form::text('firstname', null, array('class' => 'form-control','placeholder'=>'First Name','required'=>'required')) }}

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text_outer">

                        {{ Form::label('lastname', 'Last Name') }}
                        {{ Form::text('lastname', null, array('class' => 'form-control','placeholder'=>'Last Name','required'=>'required')) }}

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('dob', 'Date of birth') }}
                        {{ Form::date('dob', null, array('class' => 'flatpickr form-control', 'placeholder' => 'Select Date of birth')) }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('phone_no', 'Phone') }}
                        {{ Form::number('phone_no', null, array('class' => 'form-control','Placeholder'=>"000 000 0000")) }}
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="text_outer">

                        {{ Form::label('address', 'Address') }}
                        {{ Form::text('address', null, array('class' => 'form-control','Placeholder'=>"Address")) }}


                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text_outer">

                        {{ Form::label('personalemail', 'Personal email') }}
                        {{ Form::email('personalemail', null, array('class' => 'form-control','Placeholder'=>"Personal email")) }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text_outer">

                        {{ Form::label('workemail', 'Work email') }}
                        {{ Form::email('workemail', null, array('class' => 'form-control','Placeholder'=>"Work email",'required'=>'required')) }}

                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="text_outer file_upload">
                        <label for="name" class="">Profile photo</label>
                        <input type="file" id="profile_pic" name="profile_pic" class="form-control">
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="text_outer">
                        <label for="name" class="">Password*</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="xxxxxxxx"
                               {{ $user->id ? '' : 'required' }} {{-- password is only required if it's a new user --}}>
                    </div>
                </div>

                <div class="col-md-3">
                    <p>**Only required if you are changing your password. Your password must
                        be more than 8 characters long, should contain at least 1 uppercase, 1
                        lowercase, 1 numeric and 1 special character.
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#upload-modal1" onclick="resetStuffPassword({{ $user->id }})">Click Reset</a>
                    </p>
                </div>

            </div>
        </div><!--------Personal Information----------->

        <div class="circumstances">
            <h2 class="form_title">Personal Circumstances</h2>
            <div class="row">

                <div class="col-md-3">
                    <div class="text_outer">
                        <label for="name" class="">Marital status</label>
                        <select class="select_status form-control" name="marital_status">
                            <option value="">Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text_outer">

                        {{ Form::label('no_ofchildren', 'Number of children') }}
                        {{ Form::number('no_ofchildren', null, array('class' => 'form-control','min' => 0)) }}

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text_outer">

                        {{ Form::label('family_inarea', 'Family in the area') }}
                        {{ Form::text('family_inarea', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>


            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="text_outer">

                        {{ Form::label('familycircumstance', 'Special family circumstances') }}
                        {{ Form::text('familycircumstance', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text_outer">

                        {{ Form::label('prsnl_belief', 'Personal belief/religious requirements') }}
                        {{ Form::text('prsnl_belief', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>

            </div>
        </div><!--------Personal Circumstances----------->

        <div class="health">
            <h2 class="form_title">Health Concerns</h2>
            <div class="row">

                <div class="col-md-6">
                    <div class="text_outer">

                        {{ Form::label('known_medical_conditions', 'Known medical conditions') }}
                        {{ Form::text('known_medical_conditions', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text_outer">

                        {{ Form::label('allergies', 'Allergies') }}
                        {{ Form::text('allergies', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>


            </div>

            <div class="row">

                <div class="col-md-3">
                    <div class="text_outer">

                        {{ Form::label('dietiary_restrictions', 'Dietary Restrictions') }}
                        {{ Form::text('dietiary_restrictions', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text_outer">

                        {{ Form::label('known_health_concerns', 'Known mental health concerns') }}
                        {{ Form::text('known_health_concerns', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text_outer">
                        {{ Form::label('aversion_phyactivity', 'Aversion to physical activity') }}
                        {{ Form::text('aversion_phyactivity', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>

            </div>
        </div><!--------Health Concerns----------->

        <div class="emergency">
            <h2 class="form_title">Emergency Contact Information</h2>
            <div class="row">

                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('emergency_contact_name', 'Emergency contact name') }}
                        {{ Form::text('emergency_contact_name', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('reltn_emergency_contact', 'Relationship to emergency contact') }}
                        {{ Form::text('reltn_emergency_contact', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text_outer">

                        {{ Form::label('emergency_contact_phone', 'Emergency contact phone') }}
                        {{ Form::text('emergency_contact_phone', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text_outer">

                        {{ Form::label('emergency_contact_email', 'Emergency contact email') }}
                        {{ Form::email('emergency_contact_email', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>

            </div>
        </div><!--------Emergency Contact Information----------->

        <div class="emergency">
            <h2 class="form_title">Admin</h2>
            <div class="row">
                <div class='col-md-3'>
                    <div class="text_outer">
                        {!! Form::checkbox('is_admin',1,null,['class' => 'form-check-input','id' => 'is-admin']) !!}
                        {!! Form::label('is-admin','Is Admin') !!}
                    </div>
                </div>
            </div>
        </div>

        {{ Form::button($user->exists ? 'Edit' : 'Add', array('class' => 'btn-dark contact_btn','type'=>'submit')) }}

        {{ Form::close() }}
    </div>

    <script type="text/javascript">

    var user_id = null
    function resetStuffPassword(id){
        user_id = id;

        console.log(user_id)

        $.ajax({
            method: "POST",
            url: "/reset/stuff/password/"+id,
            dataType: 'JSON',
            success: function( results ) {
                // $.toaster({ message : 'Password Updated successfully', title : 'Success', priority : 'success' });
                // window.location.reload();

                if (results.success === true) {
                    swal("Done!", results.message, "success").then(function () {

                        // window.location.reload()
                    })
                } else {
                    swal("Error!", results.message, "error");
                }
            }
        });
    }

    </script>

@endsection
