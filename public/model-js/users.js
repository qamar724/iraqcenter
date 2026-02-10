

/*
This code generated automatically by generatesystems.com
*/


/**************************************************************************/
/*************Begin Functionality to table users ******************/
/*************************************************************************/



// start add form button
function AddForm_users() {
    $(".result").show();
    $(".result_content").html("<img   src='../images/loading.gif'  class='loaderImgPopup' />");
    $.ajax({
           url: "users_form_add",
        method: "get",
      success: function (result) {
            $(".result_content").html(result)
        }, 
    });
}
//end add form button


// Form update button start 
function update_form_users(id, table) { 
    $(".result").show();
    $(".result_content").html("<img   src='../images/loading.gif'  class='loaderImgPopup' />");
    $.ajaxSetup({ headers: {  "X-CSRF-TOKEN": $("#token").val()} });
    $.ajax({
        url: "users_form_update",
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
function ConfirmUpdateData_users(table) {
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
    form_data.append("hospitals_id", $("#hospitals_id").val());
    form_data.append("specialties_id", $("#specialties_id").val());
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
    if ($("#tbl_users_type_id").val() == -1) {
      errorList.push("Err_tbl_users_type_id");
      $("#tbl_users_type_id").next().toggleClass("border_red", $("#tbl_users_type_id :selected").val() == -1);
    } else {
      $("#tbl_users_type_id").next().toggleClass("border_green", $("#tbl_users_type_id :selected").val() > 0);
      errorList.splice(errorList.indexOf("Err_tbl_users_type_id"), -1)
      form_data.append("tbl_users_type_id", $("#tbl_users_type_id").val());
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
                   url: "users_update",
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


//Confirm insert data button start 
  function  users_ConfirmInsertData() {
  // PROCCESS 7000001
    var errorList = [];
    var outputErr = [];
    var form_data = new FormData();
    form_data.append("table", "users");


    /*********** start not required fields ***********/
      if ($("#profile_photo_path").val() !=  "") {
      var file_data = $("#profile_photo_path").prop("files")[0];  
      form_data.append("profile_photo_path", file_data); 
      }
    form_data.append("city_id", $("#city_id").val());
    form_data.append("hospitals_id", $("#hospitals_id").val());
    form_data.append("specialties_id", $("#specialties_id").val());
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
    if ($("#tbl_users_type_id").val() == -1) {
      errorList.push("Err_tbl_users_type_id");
      $("#tbl_users_type_id").next().toggleClass("border_red", $("#tbl_users_type_id :selected").val() == -1);
    } else {
      $("#tbl_users_type_id").next().toggleClass("border_green", $("#tbl_users_type_id :selected").val() > 0);
      errorList.splice(errorList.indexOf("Err_tbl_users_type_id"), -1)
      form_data.append("tbl_users_type_id", $("#tbl_users_type_id").val());
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
    /*********** start required fields ***********/


 $.ajaxSetup({ headers: {  "X-CSRF-TOKEN": $("#token").val()} });
  if (errorList.length == 0) {
     $(".loader").addClass(" fa-spinner fa-spin");
     $("#Save").prop("disabled", true);
     $("#Close").prop("disabled", true);
     $(".loader").addClass(" fa-spinner fa-spin");
           $.ajax({ 
                   url: "users_insert",
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
                  var drawErrorBox = "";
                  if (data.response != "inserted") {
                              $(".loader").removeClass(" fa-spinner fa-spin");
                              $("#Save").prop("disabled", false);
                              $("#Close").prop("disabled", false);
                              if (Object.entries(data.errors).length >= 1) {
                                  if(data.errors=="dublicated"){
                                    drawErrorBox += "<p class= 'alert alert-danger' >" + data.label + " </p>";
                                  }else{
                                      drawErrorBox += "<ul class= 'list-group alert-danger' >";
                                      for (const [key, value] of Object.entries(data.errors)) {
                                          drawErrorBox += "<li class='list-group-item list-group-item-danger'  >" + key + " : " + value + "</li>";
                                      }
                                      drawErrorBox += "</ul>";
                                  }
                                $(".errorsResults").show();
                                $(".errorsResults").html(drawErrorBox)
                              }
                  } else if (data.response == "inserted") {
                              location.reload();
                  }
              }, error: function (data) {
                   $(".loader").removeClass("fa-spinner fa-spin");
                   $("#Save").prop("disabled", false);
                   $("#Close").prop("disabled", false);
                    var res = $.parseJSON(data.responseText);
                    var feedback = "<ul class='list-group alert-danger' >";
                    $.each(res.errors, function (key, val) {
                        $.each(val, function (k, e) {
                            feedback += "<li class='list-group-item list-group-item-danger'  >" + e + "</li>";
                        });
                    });
                            feedback += "</ul>";
                    $("#errorsResults").html(feedback);
              }
          }) 
        } 
}
function get_data_users_city_id_hospitals(){
    var city_id = $("#city_id").val();
    $.get("users_get_hospitals_by_city_id", {
            city_id: city_id
        }, function (data) {
             $("#hospitals_id").html(data);
        });
} 
$(document).ready(function () {

// get hospitals for filter on main page
$("#key_city_id").change(function() {
    var city_id = $("#key_city_id").val();
    $.get("users_get_hospitals_by_city_id", {
            city_id: city_id
        }, function (data) {
             $("#key_hospitals_id").html(data);
        });
}); 
   });
//delete from table users start 
function delete_form_users(id) {
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
    output += "<div class='alert alert-danger bg-danger text-white border-0 m-0'><h3> "+msg+"</h3> <div class='modal-footer' id='modal-footer'  > <input type='button'    value='"+btn_yes+" '  id='confirmDelete' onclick='ConfirmDelete_users(\""+id+"\")'   class='btn btn-success'><input type= 'button'  data-bs-toggle='modal'    data-bs-target='.bd-dialog-modal-lg' data-toggle='modal' data-target='.bd-dialog-modal-lg'  data-bs-dismiss='modal' value='"+btn_no+" ' onclick='hidepopup()' class='btn btn-warning'></div></div>";
    $(".result_content").html(output)
}
// delete from table  users end


//confirm delete from table  users end
function ConfirmDelete_users(id) {
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
/*************Active or deActive users********* */
function deactivate_form_users(users_id,table){
  $.get("deactivate_form_users", {
    users_id: users_id,
     table: table,
 }, function (data) {
     if (data.response == "done") {
      location.reload(); 
    } 
 }, "json");
}
/***************end Active or deActive users*******/
/**************************************************************************/
/*************End Functionality to table users ******************/
/*************************************************************************/
function UsersChangePassword_form_users(id, table) {
    $(".result").show();
    $(".result_content").html("<img   class='loaderImgPopup' src='../images/loading.gif'  />");
    $.ajaxSetup({ headers: { "X-CSRF-TOKEN": $("#token").val() } });
    $.ajax({
        url: "UsersChangePassword_form_users",
        method: "post",
        data: {
            id: id,
            table: table,
        },
        success: function(result) {
            $(".result_content").html(result)
        },
    });
}
function ConfirmchangePasswordFromAdmin() {
  var errorList = [];
  var form_data = new FormData();
  form_data.append("id", $("#selectedUserid").val());
  if ($("#password").val() == "") {
      errorList.push("password");
      $("#password").css("border", "1px solid red");
  } else {
      $("#password").css("border", "1px solid green");
      errorList.splice(errorList.indexOf("password"), -1)
      form_data.append("password", $("#password").val());
  }
  if ($("#confirm_password").val() == "") {
      errorList.push("confirm_password");
      $("#confirm_password").css("border", "1px solid red");
  } else {
      $("#confirm_password").css("border", "1px solid green");
      errorList.splice(errorList.indexOf("confirm_password"), -1)
      form_data.append("confirm_password", $("#confirm_password").val());
 }
 if (errorList.length == 0) {
    $(".loader").addClass(" fa-spinner fa-spin");
    $("#Save").prop("disabled", true);
    $("#Close").prop("disabled", true);
    $(".loader").addClass(" fa-spinner fa-spin");
    $.ajax({
        url: "ConfirmchangePasswordFromAdmin",
        dataType: "text", 
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        data: form_data,
        type: "post",
        beforeSend: function() {},
        success: function(data) {
            if (data.response == "updated") {
                location.reload();
            } else if (data.response == "password_not_match") {
                $(".loader").removeClass("fa-spinner fa-spin");
                $("#Save").prop("disabled", false);
                $("#Close").prop("disabled", false);
                $(".errorsResults").show();
                $(".errorsResults").html("<p  class= 'alert alert-danger'      > " + data.label + "    </p>")
            }
        },
        error: function(data) {
            $(".loader").removeClass("fa-spinner fa-spin");
            $("#Save").prop("disabled", false);
            $("#Close").prop("disabled", false);
        }
    })
}
}
function LockAccount_form_users(id) {
    $(".result").show();
    $(".result_content").html("<img    class='loaderImgPopup' src='../images/loading.gif'   />");
    $.ajaxSetup({ headers: { "X-CSRF-TOKEN": $("#token").val() } });
    $.ajax({
        url: "LockUnlockAccount_form_users",
        method: "post",
        data: {
            id: id,
        },
        success: function(result) {
        location.reload();
    },
});
}
