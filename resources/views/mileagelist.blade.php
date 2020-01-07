
@extends('layouts.main')   
@include('modal')
@section('content1') 
     <div class="tab-pane  " id="nav-mileage" role="tabpanel" aria-labelledby="nav-mileage-tab">

                        <!--- mileage List  -->
                            <div class="mileage inner-tab-box">

                            <h3><span  class="active-span" id=active_mileage_span"">Pending </span>
                                <!--<span  id="old_mileage_span" >Old Contracts</span>
                                <span>-->
                                <i class="fa fa-plus" data-toggle="modal" data-target="#mileage-modal" style="background-color:#cecece; font-size:11px; padding:5px; border-radius:50%;color:#fff; float:right;"></i></span></h3>

                            <div id="active_mileage_div">
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Reason for mileage</th>
                                        <th>Total Km</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="return_mileagelist">
                                @if($mileage_list)
                                @foreach ($mileage_list as $mlist) 
                                
                                    <tr style="margin-bottom:10px;">
                                        <td><?= $mlist->date ?></td>
                                        <td><?= $mlist->reasonmileage ?></td>
                                        <td><?= $mlist->kilometers ?></td>
                                        <td class="action-box">
                                            <a href="javascript:void();" data-toggle="modal" data-target="#mileage-modaledit" data="<?= $mlist->id ?>" class="edit_mileage" onclick="edit_mileage(<?= $mlist->id ?>)">EDIT</a>
                                            <a href="#" class="down" onclick="delete_mileage(<?= $mlist->id ?>);">DELETE</a></td>
                                    </tr>
                                    <tr class="spacer"></tr>

                                @endforeach
                                @endif
                                </tbody>
                            </table>
                                </div>

                             <!--   <div id="old_mileage_div" style="display:none;">
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Reason for mileage</th>
                                        <th>Total Km</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="margin-bottom:10px;">
                                        <td>12/09/2019</td>
                                        <td>Client site visit</td>
                                        <td>10km</td>
                                        <td class="action-box"><a href="javascript:void();" >view</a></td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                    <tr>
                                        <td>12/09/2019</td>
                                        <td>Client site visit</td>
                                        <td>20km</td>
                                        <td class="action-box"><a href="javascript:void();" >view</a></td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                    <tr>
                                        <td>12/09/2019</td>
                                        <td>Client site visit</td>
                                        <td>10km</td>
                                        <td class="action-box"><a href="javascript:void();" >view</a></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                                </div>-->
                                
                        </div>



                        
                      </div><!-------------end--------->
                   
@endsection