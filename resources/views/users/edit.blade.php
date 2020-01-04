{{-- \resources\views\users\edit.blade.php --}}

@extends('layouts.main')

@section('title', $user->exists ? 'Edit ' . $user->name : 'Add User')

@section('content1')

 <div class="tab-pane fade show active" id="nav-employee" role="tabpanel" aria-labelledby="nav-employee-tab">

    {{ Form::model($user, array('route' => array('users.store'))) }}
    {!! Form::hidden('id') !!}
                        
                          <div class="personal">
                            <h2 class="form_title">Personal Information</h2>
                            <div class="row">
                                
                                <div class="col-md-3">
                                    <div class="text_outer">
                                       
                                        {{ Form::label('First Name', 'First Name') }}
                                        {{ Form::text('name', null, array('class' => 'form-control','placeholder'=>'First Name','required'=>'required')) }}

                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text_outer">
                                       
                                        {{ Form::label('Last Name', 'Last Name') }}
                                        {{ Form::text('lastname', null, array('class' => 'form-control','placeholder'=>'Last Name','required'=>'required')) }}

                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text_outer">
                                        {{ Form::label('dob', 'Date of birth') }}
                                        {{ Form::date('dob', null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text_outer">
                                        {{ Form::label('phone', 'Phone') }}
                                        {{ Form::number('phone_no', null, array('class' => 'form-control','Placeholder'=>"000 000 0000")) }}
                                    </div>
                                </div>
            
                            </div>
                            
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="text_outer">
                                       
                                         {{ Form::label('Aaddress', 'Address') }}
                                        {{ Form::text('address', null, array('class' => 'form-control','Placeholder'=>"Address")) }}


                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text_outer">
                                        
                                         {{ Form::label('Personal email', 'Personal email') }}
                                        {{ Form::email('personalemail', null, array('class' => 'form-control','Placeholder'=>"Personal email")) }}
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text_outer">
                                        
                                        {{ Form::label('Work email', 'Work email') }}
                                        {{ Form::email('email', null, array('class' => 'form-control','Placeholder'=>"Work email",'required'=>'required')) }}

                                    </div>
                                </div>
                                
                            </div>
                            
                             <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="text_outer file_upload">
                                        <label for="name" class="">Profile photo</label>
                                        <input type="file" id="profile_pic" name="profile_pic" class="form-control" >
                                    </div>
                                </div>
                               

                                <div class="col-md-3">
                                    <div class="text_outer">
                                        <label for="name" class="">Password*</label>
                                        <input type="password" id="password" name="password" class="form-control" placeholder="xxxxxxx" required>
                                       
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <p>**Only required if you are changing your password. Your password must
                                         be more than 6 characters long, should contain at least 1 uppercase, 1
                                         lowercase, 1 numeric and 1 special character.
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#upload-modal1">Click Reset</a>
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
                                       
                                        {{ Form::label('familyinfo', 'Number of children') }}
                                        {{ Form::text('no_ofchildren', null, array('class' => 'form-control')) }}

                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="text_outer">
                                        
                                        {{ Form::label('familyinfo', 'Family in the area') }}
                                        {{ Form::text('family_inarea', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                                    </div>
                                </div>
                                
                               
                            </div>
                            
                             <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="text_outer">

                                        {{ Form::label('familyinfo', 'Special family circumstances') }}
                                        {{ Form::text('spclfamilycircumstace', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text_outer">
                                       
                                        {{ Form::label('familyinfo', 'Personal belief/religious requirements') }}
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

                                        {{ Form::label('familyinfo', 'Known medical condions') }}
                                        {{ Form::text('known_medical_conditions', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="text_outer">
                                      
                                        {{ Form::label('familyinfo', 'Allergies') }}
                                        {{ Form::text('allergies', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                                    </div>
                                </div>
                                
                               
                               
                            </div>
                            
                             <div class="row">
                             
                                 <div class="col-md-3">
                                    <div class="text_outer">
                                       
                                        {{ Form::label('familyinfo', 'Dietary restricons') }}
                                        {{ Form::text('dietiary_restrictions', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text_outer">
                                       
                                        {{ Form::label('familyinfo', 'Known mental health concerns') }}
                                        {{ Form::text('known_health_concerns', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="text_outer">
                                         {{ Form::label('familyinfo', 'Aversion to physical acvity') }}
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
                                         {{ Form::label('familyinfo', 'Emergency contact name') }}
                                        {{ Form::text('emergency_contact_name', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text_outer">
                                         {{ Form::label('familyinfo', 'Relaonship to emergency contact') }}
                                        {{ Form::text('reltn_emergency_contact', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text_outer">
                                        
                                        {{ Form::label('familyinfo', 'Emergency contact phone') }}
                                        {{ Form::text('emergency_contact_phone', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text_outer">
                                        
                                        {{ Form::label('familyinfo', 'Emergency contact email') }}
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

@endsection
