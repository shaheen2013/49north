<div class="agreements">
            <h3><span  class="active-span" id="active_contracts_agree">Active Contracts </span> | <span  id="old_contracts_agree" onclick="old_contracts()"> Old Contracts</span></h3>
            <div id="active_contracts_agreediv">
            <div class="top_part_">
                <ul>
                    <li>Date</li>
                    <li>Agreement Type</li>
                </ul>
            </div>
            @if (isset($employee))
            @foreach ($employee as $user)
            <div class="download_file">
                <div class="left_part">
                    <p>{{$user->created_at}}</p>
                    <p>{{$user->agreement_type}}</p>
                </div>
                <div class="right_part">
                    <a href="#">VIEW</a>
                    <a href="#" class="down">DOWNLOAD</a>
                </div>
            </div><!------------------>
            @endforeach
            @endif
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