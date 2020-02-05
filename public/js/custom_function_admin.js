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



function mainance_edit_view_ajax(id, route){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type: 'POST',
		url: route,
		dataType:'html',
		data: {
		    _token: CSRF_TOKEN ,
           id: id
        },
		success:function(response)
		{
	      $(".maintenance1_edit").html(response);
	      $(".edit-maintenance-modal").modal("show");
		}
	});
}

function ticketCancel(id){
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
