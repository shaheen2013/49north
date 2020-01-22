///////// Mileage List

$(".nav_mileage,.active_mileage").click(function(){
	get_mileagelist();
});

function edit_mileage(id)
{
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'post',
		url: './get_mileagedetails/'+id,
		dataType:'html',
		data: {_token: CSRF_TOKEN},
		success:function(response)
		{
			$("#employee_mileageedit").html(response);
		}
	});
}

function editmileage_details()
{
    //var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var form_data = $('#employee_mileageedit').serialize();
    $.ajax({
		type:'post',
		url: './updatemileage',
		dataType:'html',
		data: form_data,
		success:function(response)
		{
			$('#mileage-modaledit').modal('hide');
			get_mileagelist();
		  swal("Information edited Successfully","", "success");
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
			get_mileagelist();
		  swal("Deleted Successfully","", "success");
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

// Expenses code

function expenses_listed(){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./expenses_list",
		dataType:'html',
		data: {_token: CSRF_TOKEN},
		success:function(response)
		{
	   	  resp = JSON.parse(response);
	      $(".return_expense_ajax").html(resp.data);
		}
	});
}

$(".nav_expense").click(function(){
	expenses_listed();
});

$('.expenses').submit(function(e)
{
    e.preventDefault();
    var form_data =  new FormData($(".expenses")[0]);
	$.ajax({
		type:'post',
		url: './expenses',
		data:form_data,
		processData: false,
  		contentType: false,
		success:function(response)
		{
		  $("#expense-modal").modal("hide");
		  expenses_listed();
		  swal("expense Report Add Successfully","", "success");
		}
	});
});

function edit_view_ajax(id){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./expenses_edit_view",
		dataType:'html',
		data: {_token: CSRF_TOKEN ,
			   id: id},
		success:function(response)
		{
	   	  resp = JSON.parse(response);
	      $(".expense-modal-edit").html(resp.data);
	      $(".expense-modal-edit").modal("show");
		}
	});
}

function edit_expenses()
{
    var form_data =  new FormData($(".expenses_edit1")[0]);
	$.ajax({
		type:'post',
		url: './expenses_edit',
		data:form_data,
		processData: false,
  		contentType: false,
		success:function(response)
		{
		  $(".expense-modal-edit").modal("hide");
		  expenses_listed();
		  swal("expense Report Edit Successfully","", "success");
		}
	});
}




function delete_expense(id){

	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./delete_expense",
		dataType:'html',
		data: {_token: CSRF_TOKEN ,
			   id: id},
		success:function(response)
		{
	   	  expenses_listed();
		  swal("expense Report Deleted Successfully","", "success");
		}
	});

}

function expense_approve(id){
 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./expense_approve",
		dataType:'html',
		data: {_token: CSRF_TOKEN ,
			   id: id},
		success:function(response)
		{
	   	  expenses_listed();
		  swal("expense Approved Successfully","", "success");
		}
	});
}
function expense_reject(id){
 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./expense_reject",
		dataType:'html',
		data: {_token: CSRF_TOKEN ,
			   id: id},
		success:function(response)
		{
	   	  expenses_listed();
		  swal("expense Reject Successfully","", "success");
		}
	});
}

function expenses_pending(id){
 expenses_listed();
}

function expenses_historical(id){
 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./expenses_historical",
		dataType:'html',
		data: {_token: CSRF_TOKEN},
		success:function(response)
		{
	   	   resp = JSON.parse(response);
	      $(".return_expense_ajax_history").html(resp.data);
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

/*$('.maintenance1').submit(function(e){
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
});*/

/*function mainance_edit_view_ajax(id){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type:'POST',
		url:"./editview",
		dataType:'html',
		data: {_token: CSRF_TOKEN ,
			   id: id},
		success:function(response)
		{
	      $(".maintenance1_edit").html(response);
	      $(".edit-maintenance-modal").modal("show");
		}
	});
}*/

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
