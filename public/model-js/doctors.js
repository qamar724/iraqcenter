function ImportForm_doctors() {
    $(".result").show();
    $(".result_content").html("<img   src='../images/loading.gif'  class='loaderImgPopup' />");
    $.ajax({
           url: "doctors_import_add",
        method: "get",
      success: function (result) {
            $(".result_content").html(result)
        }, 
    });
}

function doctors_ConfirmImport(){
  var form_data = new FormData();
  var errorList = [];
  var fileInput = document.getElementById('file');
  if(!fileInput.files.length){
    errorList.push('file');
    $('#file').addClass('is-invalid');
  } else {
    $('#file').removeClass('is-invalid');
    form_data.append('file', fileInput.files[0]);
  }
  if(errorList.length){
    $('#errorsResults').html('<div class="alert alert-danger">{{__("public.file_field_required") ?? "The file field is required."}}</div>');
    return;
  }

  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('#token').val() } });
  $('.loader').addClass('fa-spinner fa-spin');
  $('#Save').prop('disabled', true);
  $('#Close').prop('disabled', true);
  $.ajax({
    url: 'doctors_import',
    method: 'post',
    data: form_data,
    cache: false,
    contentType: false,
    processData: false,
    success: function(data){
      if(data.response === 'success'){
        location.reload();
      }else if(data.response === 'no_permission'){
        $('#errorsResults').html('<div class="alert alert-danger">'+data.message+'</div>');
      }
    },
    error: function(xhr){
      $('.loader').removeClass('fa-spinner fa-spin');
      $('#Save').prop('disabled', false);
      $('#Close').prop('disabled', false);
      var res = $.parseJSON(xhr.responseText);
      var feedback = '<ul class="alert alert-danger">';
      $.each(res.errors, function (key, val) {
          $.each(val, function (k, e) {
              feedback += '<li>' + e + '</li>';
          });
      });
      feedback += '</ul>';
      $('#errorsResults').html(feedback);
    }
  });
}

function update_form_doctors(id, table) { 
  $(".result").show();
  $(".result_content").html("<img   src='../images/loading.gif'  class='loaderImgPopup' />");
  $.ajaxSetup({ headers: {  "X-CSRF-TOKEN": $("#token").val()} });
  $.ajax({
      url: "doctors_form_update",
      method: "post",
      data: {
          id: id,
          table: table,
      },
      success: function (result) {
          $(".result_content").html(result)
      },
  });
}
//Form update button end




// Confirm update data button start 
function ConfirmUpdateData_doctors(table) {
  var errorList = [];
  var form_data = new FormData();
  var outputErr=[];
  form_data.append("table", "users"  );
  form_data.append("id", $("#id").val()  );


  /*********** start not required fields ***********/
if($("#profile_photo_path").val() != "") { 
  var file_data = $("#profile_photo_path").prop("files")[0];  
  form_data.append("profile_photo_path", file_data); 
}  
  form_data.append("city_id", $("#city_id").val());
  /*********** end not required fields ***********/


  /*********** start required fields ***********/
  if ($("#name").val() == "") {
    errorList.push("Err_name");
    $("#name").css("border", "1px solid red");
  } else {
    $("#name").css("border", "1px solid green");
    errorList.splice(errorList.indexOf("Err_name"), -1)
    form_data.append("name", $("#name").val());
  }
  if ($("#email").val() == "") {
    errorList.push("Err_email");
    $("#email").css("border", "1px solid red");
  } else {
    $("#email").css("border", "1px solid green");
    errorList.splice(errorList.indexOf("Err_email"), -1)
    form_data.append("email", $("#email").val());
  }
  if ($("#phone").val() == "") {
    errorList.push("Err_phone");
    $("#phone").css("border", "1px solid red");
  } else {
    $("#phone").css("border", "1px solid green");
    errorList.splice(errorList.indexOf("Err_phone"), -1)
    form_data.append("phone", $("#phone").val());
  }
  if ($("#genders_id").val() == -1) {
    errorList.push("Err_genders_id");
    $("#genders_id").next().toggleClass("border_red", $("#genders_id :selected").val() == -1);
  } else {
    $("#genders_id").next().toggleClass("border_green", $("#genders_id :selected").val() > 0);
    errorList.splice(errorList.indexOf("Err_genders_id"), -1)
    form_data.append("genders_id", $("#genders_id").val());
  }
  /*********** end required fields ***********/


if(outputErr.length >= 1){
$("#errorsResults").show();
$("#errorsResults").html(outputErr); 
} 
if (errorList.length == 0) {
   $.ajaxSetup({ headers: {  "X-CSRF-TOKEN": $("#token").val()} });
   $(".loader").addClass(" fa-spinner fa-spin");
   $("#Save").prop("disabled", true);
   $("#Close").prop("disabled", true);
         $.ajax({ 
                 url: "doctors_update",
            dataType: "text",  // what to expect back from the PHP script, if anything
               cache: false,
         contentType: false,
         processData: false,
            dataType: "json",
                data: form_data,
                type: "post",
          beforeSend: function() { 
                

              }, 
             success: function(data) { //console.log(response); 
                if(data.response == "updated"){
                    location.reload(); 
                }else if(data.response == "dublicated"){
                    $(".errorsResults").show();
                    $(".errorsResults").html("<p class= 'alert alert-danger'    >Sorry, field  (" + data.dublicateField + ") already exists not allow dublicated </p>")
                }}, error: function (data) {
                    var res = $.parseJSON(data.responseText);
                    $(".loader").removeClass(" fa-spinner fa-spin");
                    $("#Save").prop("disabled", false);
                    $("#Close").prop("disabled", false);
                    var feedback = "<ul class=>";
                    $.each(res.errors, function (key, val) {
                        $.each(val, function (k, e) {
                            feedback += "<li class= >" + e + "</li>";
                        });
                  });
                    feedback += "</ul>";
                    $("#errorsResults").html(feedback);
            }
        }) 
      } 
}
//Confirm update data button end

//delete from table users start 
function delete_form_doctors(id) {
  var table = $("#hiddenTable").val();
  $(".result").show();
   var currentLang = getCookie("lang");
   var msg = "";
   var btn_yes = "";
   var btn_no = "";
   if(currentLang == "ar"){
     msg = "هل انت متأكد من حذف هذا السجل";
     btn_yes = "نعم";
     btn_no = "لا";
   }else {
     msg = "Are you sure to remove this row ?";
     btn_yes = "Yes";
     btn_no = "No";
   }
  var output = "";
  output += "<div class='alert alert-danger bg-danger text-white border-0 m-0'><h3> "+msg+"</h3> <div class='modal-footer' id='modal-footer'  > <input type='button'    value='"+btn_yes+" '  id='confirmDelete' onclick='ConfirmDelete_doctors(\""+id+"\")'   class='btn btn-success'><input type= 'button'  data-bs-toggle='modal'    data-bs-target='.bd-dialog-modal-lg' data-toggle='modal' data-target='.bd-dialog-modal-lg'  data-bs-dismiss='modal' value='"+btn_no+" ' onclick='hidepopup()' class='btn btn-warning'></div></div>";
  $(".result_content").html(output)
}
// delete from table  users end


//confirm delete from table  users end
function ConfirmDelete_doctors(id) {
  var table = $("#hiddenTable").val();
  $(".result").show();
  $(".result_content").html("<img   src='../images/loading.gif'  class='loaderImgPopup'   />");
  var currentLang = getCookie("lang");
  var btn_close = "";
  if(currentLang == "ar"){
    btn_close = "اغلاق";
  }else {
    btn_close = "Close";
  }
  
      $.get("users_delete", {
           id: id,
        table: table,
      }, function (data) {
          if (data.response == "deleted") {
              $(".result_content").html("<div class='alert alert-success text-white border-0 m-0'><h3>"+data.message+"</h3> <br> <input type='button'  data-toggle='modal' data-target='.bd-dialog-modal-lg' value='"+btn_close+"' data-bs-dismiss='modal'  onclick='hidepopup()' class='btn btn-danger'></div>");
              $("#column_" + id).remove();
              $("#tr_" + id).remove();
          }else if(data.response == "not_allow"){
              $(".result_content").html("<div class='alert alert-danger bg-danger text-white border-0 m-0'><h3>"+data.message+"</h3> <br> <input type='button'  data-toggle='modal' data-target='.bd-dialog-modal-lg' value='"+btn_close+"' data-bs-dismiss='modal'   onclick='hidepopup()' class='btn btn-danger'></div>");
          }else if(data.response == "no_permission"){
              $(".result_content").html("<div class='alert alert-danger bg-danger text-white border-0 m-0'><h3>"+data.message+"</h3> <br> <input type='button'  data-toggle='modal' data-target='.bd-dialog-modal-lg' value='"+btn_close+"' data-bs-dismiss='modal'   onclick='hidepopup()' class='btn btn-danger'></div>");
          } else {
              $(".result_content").html("<div class='alert alert-danger bg-danger text-white border-0 m-0'><h3>"+data.message+"</h3> <br> <input type='button' value='"+btn_close+"' onclick='hidepopup()'  data-toggle='modal' data-target='.bd-dialog-modal-lg' data-bs-dismiss='modal' class='btn btn-danger'></div>");
          }
      }, "json");
}
//confirm delete from table  users end

