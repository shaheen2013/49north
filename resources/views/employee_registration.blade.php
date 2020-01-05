@include('layouts.employee')

<section class="page-section" id="user_part">
    <div class="profile_section_text">
        <div class="tab-content" id="myTabContent">

            <!-------------Profile--------------->
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <!-- employee nav here  --->
                @include('navbar')
                <div class="container-fluid">
                    <div class="tab-content" id="nav-tabContent">


                        <div class="tab-pane fade show active" id="nav-employee" role="tabpanel"
                             aria-labelledby="nav-employee-tab">
                            <form id="contacts_form" name="contact-form" action="" method="POST">

                                <div class="personal">
                                    <h2 class="form_title">Personal Information</h2>
                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="text_outer">
                                                <label for="name" class="">First name</label>
                                                <input type="text" id="name" name="name" class="form-control"
                                                       placeholder="John">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text_outer">
                                                <label for="name" class="">Last name</label>
                                                <input type="text" id="email" name="email" class="form-control"
                                                       placeholder="Doe">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text_outer">
                                                <label for="name" class="">Date of birth</label>
                                                <input type="date" id="email" name="email" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text_outer">
                                                <label for="name" class="">Phone</label>
                                                <input type="number" id="email" name="email" class="form-control"
                                                       placeholder="000 000 0000">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="text_outer">
                                                <label for="name" class="">Address</label>
                                                <input type="text" id="name" name="name" class="form-control"
                                                       placeholder="208-123 Water Street, Vancouver, BC, VIM 3C9">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text_outer">
                                                <label for="name" class="">Personal email</label>
                                                <input type="email" id="email" name="email" class="form-control"
                                                       placeholder="johndoe@gmail.com">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text_outer">
                                                <label for="name" class="">Work email</label>
                                                <input type="email" id="email" name="email" class="form-control"
                                                       placeholder="johndoe@gmail.com">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="text_outer file_upload">
                                                <label for="name" class="">Profile photo</label>
                                                <input type="file" id="icondemo" name="name" class="form-control">
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <div class="text_outer">
                                                <label for="name" class="">Password*</label>
                                                <input type="password" id="email" name="email" class="form-control"
                                                       placeholder="xxxxxxx">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <p>**Only required if you are changing your password. Your password must
                                                be more than 6 characters long, should contain at least 1 uppercase, 1
                                                lowercase, 1 numeric and 1 special character.</p>
                                        </div>

                                    </div>
                                </div><!--------Personal Information----------->

                                <div class="circumstances">
                                    <h2 class="form_title">Personal Circumstances</h2>
                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="text_outer">
                                                <label for="name" class="">Marital status</label>
                                                <select class="select_status form-control">
                                                    <option>Select</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text_outer">
                                                <label for="name" class="">Number of children</label>
                                                <input type="number" id="email" name="email" class="form-control"
                                                       placeholder="0">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="text_outer">
                                                <label for="name" class="">Family in the area</label>
                                                <input type="text" id="email" name="email" class="form-control"
                                                       placeholder="Insert text here">
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="text_outer">
                                                <label for="name" class="">Special family circumstances</label>
                                                <input type="text" id="name" name="name" class="form-control"
                                                       placeholder="Insert text here">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text_outer">
                                                <label for="name" class="">Personal belief/religious
                                                    requirements</label>
                                                <input type="text" id="email" name="email" class="form-control"
                                                       placeholder="Insert text here">
                                            </div>
                                        </div>

                                    </div>
                                </div><!--------Personal Circumstances----------->

                                <div class="health">
                                    <h2 class="form_title">Health Concerns</h2>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="text_outer">
                                                <label for="name" class="">Known medical conditions</label>
                                                <input type="text" id="name" name="name" class="form-control"
                                                       placeholder="Insert text here">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="text_outer">
                                                <label for="name" class="">Allergies</label>
                                                <input type="text" id="email" name="email" class="form-control"
                                                       placeholder="Insert text here">
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="text_outer">
                                                <label for="name" class="">Dietary Restrictions</label>
                                                <input type="text" id="email" name="email" class="form-control"
                                                       placeholder="Insert text here">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text_outer">
                                                <label for="name" class="">Known mental health concerns</label>
                                                <input type="text" id="name" name="name" class="form-control"
                                                       placeholder="Insert text here">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="text_outer">
                                                <label for="name" class="">Aversion to physical activity</label>
                                                <input type="text" id="email" name="email" class="form-control"
                                                       placeholder="Insert text here">
                                            </div>
                                        </div>

                                    </div>
                                </div><!--------Health Concerns----------->

                                <div class="emergency">
                                    <h2 class="form_title">Emergency Contact Information</h2>
                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="text_outer">
                                                <label for="name" class="">Emergency contact name</label>
                                                <input type="text" id="name" name="name" class="form-control"
                                                       placeholder="Insert text here">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text_outer">
                                                <label for="name" class="">Relationship to emergency contact</label>
                                                <input type="text" id="email" name="email" class="form-control"
                                                       placeholder="Insert text here">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text_outer">
                                                <label for="name" class="">Emergency contact phone</label>
                                                <input type="text" id="email" name="email" class="form-control"
                                                       placeholder="Insert text here">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text_outer">
                                                <label for="name" class="">Emergency contact email</label>
                                                <input type="text" id="email" name="email" class="form-control"
                                                       placeholder="Insert text here">
                                            </div>
                                        </div>

                                    </div>
                                </div><!--------Emergency Contact Information----------->

                                <button type="submit" class="btn-dark contact_btn">Save</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
