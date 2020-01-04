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
                        <!--------------agreements-------------->
                      <div class="tab-pane fade" id="nav-agreements" role="tabpanel" aria-labelledby="nav-agreements-tab">
                        <div class="agreements">
                            <h3><span  class="active-span" id="active_contracts_agree">Active Contracts </span> | <span  id="old_contracts_agree"> Old Contracts</span></h3>
                            <div id="active_contracts_agreediv">
                            <div class="top_part_">
                                <ul>
                                    <li>Date</li>
                                    <li>Descripon</li>
                                </ul>
                            </div>
                            <div class="download_file">
                                <div class="left_part">
                                    <p>12/09/2019</p>
                                    <p>John Doe Contract of Employment</p>
                                </div>
                                <div class="right_part">
                                    <a href="#">VIEW</a>
                                    <a href="#" class="down">DOWNLOAD</a>
                                </div>
                            </div><!------------------>
                            </div>
                            <div id="old_contracts_agreediv" style="display:none;">
                                <div class="top_part_">
                                <ul>
                                    <li>Date</li>
                                    <li>Descripon</li>
                                </ul>
                            </div>
                            <div class="download_file">
                                <div class="left_part">
                                    <p>12/09/2019</p>
                                    <p>John Doe Contract of Employment</p>
                                </div>
                                <div class="right_part">
                                    <a href="#">VIEW</a>
                                    
                                </div>
                            </div><!------------------>
                            </div>
                            
                        </div>
                      </div><!-------------end--------->

 
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>