function get_agreementlist()
{
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	$.ajax({
		type:'GET',
		url:"./agreementlist",
		dataType:'html',
		data: {_token: CSRF_TOKEN},
		success:function(response)
		{
		   $(".total_agreement_list").html(response);
		}
	});
}



function show_modal_agreement(id,type)
{  //alert('edfds');
	$('#show_modal_agreement').modal('show');
	$('#employee_id_modal').val(id);  
	$('#agreement_type').val(type);
}

$(".nav_agreement").click(function(){
	get_agreementlist();
});	

$('#upload_agreement').submit(function(e)
{
    e.preventDefault();
    var form_data =  new FormData($("#upload_agreement")[0]);
	$.ajax({
		type:'post',
		url: './addagreement',		
		data:form_data,
		processData: false,
  		contentType: false,
		success:function(response)
		{
			
			$('#show_modal_agreement').modal('hide');
			
		  swal(response.desc,"", response.status);
		  get_agreementlist();

		}
	});
});

function delete_agreement(id,type)
{
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'DELETE',
		url:"./delete_agreement/"+id+'/'+type,
		dataType:'json',
		data: {_token: CSRF_TOKEN,type:type},
		success:function(response)
		{
		   //get_agreementlist();
		  swal("Delete successfully","", "success");
		setTimeout(function(){
		       location.reload();
		   },3000);
		}
	});
}


///////// Mileage List

$(".nav_mileage,.active_mileage").click(function(){
	get_mileagelist();
});	


function get_mileagelist()
{
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	$.ajax({
		type:'POST',
		url:"./mileagelist",
		dataType:'html',
		data: {_token: CSRF_TOKEN},
		success:function(response)
		{
		   resp = JSON.parse(response);
	      $(".return_mileagelist").html(resp.data);

		}
	});
}





function addmileage_details()
{	
     form_data =  $('#employee_mileage').serialize();
    
	$.ajax({
		type:'post',
		url: './addmileage',		
		data:form_data,		
		success:function(response)
		{  
			$('#mileage-modal').modal('hide');
			//get_mileagelist();
		  swal("Your information is submitted Successfully","", "success");
		  location.reload();

		}
	});
}

function edit_mileage(id)
{
	$('#mileage-modaledit').modal('show');
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'post',
		url: './get_mileagedetails/'+id,
		dataType:'html',		
		data: {_token: CSRF_TOKEN},
		success:function(response)
		{ 
			//$("#employee_mileageedit").html(response);
			$("#employee_mileageedit").html(response);

		}
	});
}



function delete_mileage(id)
{	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'post',
		url: './deletemileage/'+id,
		dataType:'html',		
		data: {_token: CSRF_TOKEN},
		success:function(response)
		{ 
			//get_mileagelist();
		  swal("Deleted Successfully","", "success");
		  location.reload();
		}
	});
}


function employee_agreement()
{ var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'post',
		url: './employee_agreementlist',
		dataType:'html',		
		data: {_token: CSRF_TOKEN},
		success:function(response)
		{
			$(".employeeagreements").html(response);
		}
	});
}

function old_contracts()
{
	$("#old_contracts_agree").addClass("active-span");
            $("#active_contracts_agree").removeClass("active-span");
            $("#active_contracts_agreediv").hide();
            $("#old_contracts_agreediv").show();

}




// Expenses code

function expences_listed(){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./expences_list",
		dataType:'html',
		data: {_token: CSRF_TOKEN},
		success:function(response)
		{
	   	  resp = JSON.parse(response);
	      $(".return_expence_ajax").html(resp.data);
		}
	});
}

/*$(".nav_expense").click(function(){
	expences_listed();
});	

$('.expences').submit(function(e)
{
    e.preventDefault();
    var form_data =  new FormData($(".expences")[0]);
	$.ajax({
		type:'post',
		url: './expences',		
		data:form_data,
		processData: false,
  		contentType: false,
		success:function(response)
		{
		  $("#expense-modal").modal("hide");
		  expences_listed();
		  swal("Expence Report Add Successfully","", "success");
		}
	});
});*/

function edit_view_ajax(id){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./expense_edit_view",
		dataType:'html',
		data: {_token: CSRF_TOKEN ,
			   id: id},
		success:function(response)
		{
	   	  $("#expense-modal-edit2").modal("show");
	      $("#expenses_edit2").html(response);
		}
	});
}

function edit_expences()
{
    var form_data =  new FormData($(".expences_edit1")[0]);
	$.ajax({
		type:'post',
		url: './expences_edit',		
		data:form_data,
		processData: false,
  		contentType: false,
		success:function(response)
		{
		  $(".expense-modal-edit").modal("hide");
		  expences_listed();
		  swal("Expence Report Edit Successfully","", "success");
		}
	});
}



      
function delete_expence(id){

	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./delete",
		dataType:'html',
		data: {_token: CSRF_TOKEN ,
			   id: id},
		success:function(response)
		{
		  //$('p.alert').text('Deleted successfully');
		  location.reload();
		}
	});

}

function expence_approve(id){
 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./approve",
		dataType:'html',
		data: {_token: CSRF_TOKEN ,
			   id: id},
		success:function(response)
		{
	   	  expences_listed();
		  swal("Expence Approved Successfully","", "success");
		}
	});
}

function expence_reject(id){
 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./reject",
		dataType:'html',
		data: {_token: CSRF_TOKEN ,
			   id: id},
		success:function(response)
		{
	   	  expences_listed();
		  swal("Expence Reject Successfully","", "success");
		}
	});
}

function expences_pending(id){
 expences_listed();
}

function expense_history(id){
 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./history",
		dataType:'html',
		data: {_token: CSRF_TOKEN},
		success:function(response)
		{
	   	   resp = JSON.parse(response);
	      $(".return_expence_ajax_history").html(resp.data);
		}
	});
}




// Faiz maintenance

function maintanance_list(){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./maintanance_list",
		dataType:'html',
		data: {_token: CSRF_TOKEN},
		success:function(response)
		{
			resp = JSON.parse(response);
		   $(".maintanance_list_come_ajax").html(resp.data);
		}
	});
}

$('.maintenance1').submit(function(e){
    e.preventDefault();
    var form_data =  new FormData($(".maintenance1")[0]);
	$.ajax({
		type:'post',
		url: './maintenance',		
		data:form_data,
		processData: false,
  		contentType: false,
		success:function(response)
		{
		  maintanance_list();
		  $("#maintenance-modal").modal("hide");
		  swal("Tech Maintenance Add Successfully","", "success");
		}
	});
});

function mainance_edit_view_ajax(id){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./mainance_edit_view_ajax",
		dataType:'html',
		data: {_token: CSRF_TOKEN ,
			   id: id},
		success:function(response)
		{
	   	  resp = JSON.parse(response);
	      $(".edit-maintenance-modal").html(resp.data);
	      $(".edit-maintenance-modal").modal("show");
		}
	});
}

// $('.maintenance1_edit').submit(function(e){
//     e.preventDefault();
//     alert("ok");
//  });

function maintenance1_edit(){
	//var frm=$('.maintenance1_edit').serialize()
	var form_data = new FormData($(".maintenance1_edit")[0]); 
	$.ajax({
		type:'post',
		url: './maintenance1_edit',		
		data:form_data,
		processData: false,
  		contentType: false,
		success:function(response)
		{
		  maintanance_list();
		  $(".edit-maintenance-modal").modal("hide");
		  swal("Tech Maintenance Edit Successfully","", "success");
		}
	});
}

function delete_maintance(id){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./delete_maintance",
		dataType:'html',
		data: {_token: CSRF_TOKEN ,
			   id: id},
		success:function(response)
		{
	   	  maintanance_list();
		  swal("Tech Maintenance Deleted Successfully","", "success");
		}
	});
}

function ticket_inprogress(id){
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
		type:'POST',
		url:"./ticket_inprogress",
		dataType:'html',
		data: {_token: CSRF_TOKEN ,
			   id: id},
		success:function(response)
		{
	   	  maintanance_list();
		  swal("Tech Maintenance Inprogress Successfully","", "success");
		}
  });
}

function ticket_cancel(id){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./ticket_cancel",
		dataType:'html',
		data: {_token: CSRF_TOKEN ,
			   id: id},
		success:function(response)
		{
	   	  maintanance_list();
		  swal("Tech Maintenance Cancel Successfully","", "success");
		}
	});

}

function complited_ticket(){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./complited_ticket",
		dataType:'html',
		data: {_token: CSRF_TOKEN},
		success:function(response)
		{
			resp = JSON.parse(response);
		   $(".maintanance_list_come_ajax_completed_ticket").html(resp.data);
		}
	});
}