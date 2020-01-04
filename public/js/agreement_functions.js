function get_agreementlist() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'POST',
        url: "./agreementlist",
        dataType: 'html',
        data: {_token: CSRF_TOKEN},
        success: function (response) {
            console.log(response);
            $(".total_agreement_list").html(response);
        }
    });
}

function show_modal_agreement(id, type) {
    $('#show_modal_agreement').modal('show');
    $('#employee_id_modal').val(id);
    $('#agreement_type').val(type);
}

$(".nav_agreement").click(function () {
    get_agreementlist();
});

$('#upload_agreement').submit(function (e) {
    e.preventDefault();
    var form_data = new FormData($("#upload_agreement")[0]);
    $.ajax({
        type: 'post',
        url: './addagreement',
        data: form_data,
        processData: false,
        contentType: false,
        success: function (response) {
            $('#show_modal_agreement').modal('hide');
            get_agreementlist();
            swal("Agreement Uploaded successfully", "", "success");

        }
    });
});

function delete_agreement(id, type) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: 'DELETE',
        url: "./delete_agreement/" + id + '/' + type,
        dataType: 'json',
        data: {_token: CSRF_TOKEN, type: type},
        success: function (response) {
            get_agreementlist();
            swal("Delete successfully", "", "success");
        }
    });
}

function old_contracts() {
    $("#old_contracts_agree").addClass("active-span");
    $("#active_contracts_agree").removeClass("active-span");
    $("#active_contracts_agreediv").hide();
    $("#old_contracts_agreediv").show();

}



