function maintenanceEditView(id, route){
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
