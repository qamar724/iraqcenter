/*
This code generated automatically by generatesystems.com
*/


/**************************************************************************/
/*************Begin Functionality to table distributions ******************/
/*************************************************************************/



// start add form button
function AddForm_distributions() {
    $(".result").show();
    $(".result_content").html("<img   src='../images/loading.gif'  class='loaderImgPopup' />");
    $.ajax({
           url: "distributions_form_add",
        method: "get",
      success: function (result) {
            $(".result_content").html(result)
        }, 
    });
}
//end add form button


// Form update button start 
function update_form_distributions(id, table) { 
    $(".result").show();
    $(".result_content").html("<img   src='../images/loading.gif'  class='loaderImgPopup' />");
    $.ajaxSetup({ headers: {  "X-CSRF-TOKEN": $("#token").val()} });
    $.ajax({
        url: "distributions_form_update",
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
function ConfirmUpdateData_distributions(table) {
    var errorList = [];
    var form_data = new FormData();
    var outputErr=[];
    form_data.append("table", "distributions"  );
    form_data.append("id", $("#id").val()  );


    /*********** start required fields ***********/
    if ($("#users_id").val() == -1) {
      errorList.push("Err_users_id");
      $("#users_id").next().toggleClass("border_red", $("#users_id :selected").val() == -1);
    } else {
      $("#users_id").next().toggleClass("border_green", $("#users_id :selected").val() > 0);
      errorList.splice(errorList.indexOf("Err_users_id"), -1)
      form_data.append("users_id", $("#users_id").val());
    }
    if ($("#hospitals_id").val() == -1) {
      errorList.push("Err_hospitals_id");
      $("#hospitals_id").next().toggleClass("border_red", $("#hospitals_id :selected").val() == -1);
    } else {
      $("#hospitals_id").next().toggleClass("border_green", $("#hospitals_id :selected").val() > 0);
      errorList.splice(errorList.indexOf("Err_hospitals_id"), -1)
      form_data.append("hospitals_id", $("#hospitals_id").val());
    }
    if ($("#hospitals_has_specialties_id").val() == -1) {
      errorList.push("Err_hospitals_has_specialties_id");
      $("#hospitals_has_specialties_id").next().toggleClass("border_red", $("#hospitals_has_specialties_id :selected").val() == -1);
    } else {
      $("#hospitals_has_specialties_id").next().toggleClass("border_green", $("#hospitals_has_specialties_id :selected").val() > 0);
      errorList.splice(errorList.indexOf("Err_hospitals_has_specialties_id"), -1)
      form_data.append("hospitals_has_specialties_id", $("#hospitals_has_specialties_id").val());
    }
    if ($("#status_id").val() == -1) {
      errorList.push("Err_status_id");
      $("#status_id").next().toggleClass("border_red", $("#status_id :selected").val() == -1);
    } else {
      $("#status_id").next().toggleClass("border_green", $("#status_id :selected").val() > 0);
      errorList.splice(errorList.indexOf("Err_status_id"), -1)
      form_data.append("status_id", $("#status_id").val());
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
                   url: "distributions_update",
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
                      $(".loader").removeClass(" fa-spinner fa-spin");
                      $("#Save").prop("disabled", false);
                      $("#Close").prop("disabled", false);
                      $(".errorsResults").show();
                      var currentLang = getCookie("lang");
                      var errorMsg = "";
                      if(currentLang == "ar"){
                          errorMsg = data.dublicateField + " موجود مسبقاً، لا يسمح بالتكرار";
                      } else {
                          errorMsg = data.dublicateField + " already exists, duplication is not allowed";
                      }
                      $(".errorsResults").html("<p class='alert alert-danger'>" + errorMsg + "</p>")
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
  function  distributions_ConfirmInsertData() {
  // PROCCESS 7000001
    var errorList = [];
    var outputErr = [];
    var form_data = new FormData();
    form_data.append("table", "distributions");


    /*********** start required fields ***********/
    if ($("#users_id").val() == -1) {
      errorList.push("Err_users_id");
      $("#users_id").next().toggleClass("border_red", $("#users_id :selected").val() == -1);
    } else {
      $("#users_id").next().toggleClass("border_green", $("#users_id :selected").val() > 0);
      errorList.splice(errorList.indexOf("Err_users_id"), -1)
      form_data.append("users_id", $("#users_id").val());
    }
    if ($("#hospitals_id").val() == -1) {
      errorList.push("Err_hospitals_id");
      $("#hospitals_id").next().toggleClass("border_red", $("#hospitals_id :selected").val() == -1);
    } else {
      $("#hospitals_id").next().toggleClass("border_green", $("#hospitals_id :selected").val() > 0);
      errorList.splice(errorList.indexOf("Err_hospitals_id"), -1)
      form_data.append("hospitals_id", $("#hospitals_id").val());
    }
    if ($("#hospitals_has_specialties_id").val() == -1) {
      errorList.push("Err_hospitals_has_specialties_id");
      $("#hospitals_has_specialties_id").next().toggleClass("border_red", $("#hospitals_has_specialties_id :selected").val() == -1);
    } else {
      $("#hospitals_has_specialties_id").next().toggleClass("border_green", $("#hospitals_has_specialties_id :selected").val() > 0);
      errorList.splice(errorList.indexOf("Err_hospitals_has_specialties_id"), -1)
      form_data.append("hospitals_has_specialties_id", $("#hospitals_has_specialties_id").val());
    }
    if ($("#status_id").val() == -1) {
      errorList.push("Err_status_id");
      $("#status_id").next().toggleClass("border_red", $("#status_id :selected").val() == -1);
    } else {
      $("#status_id").next().toggleClass("border_green", $("#status_id :selected").val() > 0);
      errorList.splice(errorList.indexOf("Err_status_id"), -1)
      form_data.append("status_id", $("#status_id").val());
    }
    /*********** start required fields ***********/


 $.ajaxSetup({ headers: {  "X-CSRF-TOKEN": $("#token").val()} });
  if (errorList.length == 0) {
     $(".loader").addClass(" fa-spinner fa-spin");
     $("#Save").prop("disabled", true);
     $("#Close").prop("disabled", true);
     $(".loader").addClass(" fa-spinner fa-spin");
           $.ajax({ 
                   url: "distributions_insert",
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
                              if (data.errors == "dublicated") {
                                    drawErrorBox += "<p class='alert alert-danger' >" + data.label + " </p>";
                                    $(".errorsResults").show();
                                    $(".errorsResults").html(drawErrorBox)
                              } else if (Object.entries(data.errors).length >= 1) {
                                      drawErrorBox += "<ul class='list-group alert-danger' >";
                                      for (const [key, value] of Object.entries(data.errors)) {
                                          drawErrorBox += "<li class='list-group-item list-group-item-danger'  >" + key + " : " + value + "</li>";
                                      }
                                      drawErrorBox += "</ul>";
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
function get_data_distributions_hospitals_id_hospitals_has_specialties(){
    var hospitals_id = $("#hospitals_id").val();
    $.get("distributions_get_hospitals_has_specialties_by_hospitals_id", {
            hospitals_id: hospitals_id
        }, function (data) {
             $("#hospitals_has_specialties_id").html(data);
        });
} 
$(document).ready(function () {

// get hospitals_has_specialties for filter on main page
$("#key_hospitals_id").change(function() {
    var hospitals_id = $("#key_hospitals_id").val();
    $.get("distributions_get_hospitals_has_specialties_by_hospitals_id", {
            hospitals_id: hospitals_id
        }, function (data) {
             $("#key_hospitals_has_specialties_id").html(data);
        });
}); 
   });
//delete from table distributions start 
function delete_form_distributions(id) {
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
    output += "<div class='alert alert-danger bg-danger text-white border-0 m-0'><h3> "+msg+"</h3> <div class='modal-footer' id='modal-footer'  > <input type='button'    value='"+btn_yes+" '  id='confirmDelete' onclick='ConfirmDelete_distributions(\""+id+"\")'   class='btn btn-success'><input type= 'button'  data-bs-toggle='modal'    data-bs-target='.bd-dialog-modal-lg' data-toggle='modal' data-target='.bd-dialog-modal-lg'  data-bs-dismiss='modal' value='"+btn_no+" ' onclick='hidepopup()' class='btn btn-warning'></div></div>";
    $(".result_content").html(output)
}
// delete from table  distributions end


//confirm delete from table  distributions end
function ConfirmDelete_distributions(id) {
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
    
        $.get("distributions_delete", {
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
//confirm delete from table  distributions end
/**************************************************************************/
/*************End Functionality to table distributions ******************/
/*************************************************************************/