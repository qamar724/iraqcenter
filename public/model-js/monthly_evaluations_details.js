

/*
This code generated automatically by generatesystems.com
*/


/**************************************************************************/
/*************Begin Functionality to table monthly_evaluations_details ******************/
/*************************************************************************/



// start add form button
function AddForm_monthly_evaluations_details() {
    $(".result").show();
    $(".result_content").html("<img   src='../images/loading.gif'  class='loaderImgPopup' />");
    $.ajax({
           url: "monthly_evaluations_details_form_add",
        method: "get",
      success: function (result) {
            $(".result_content").html(result)
        }, 
    });
}
//end add form button


// Form update button start 
function update_form_monthly_evaluations_details(id, table) { 
    $(".result").show();
    $(".result_content").html("<img   src='../images/loading.gif'  class='loaderImgPopup' />");
    $.ajaxSetup({ headers: {  "X-CSRF-TOKEN": $("#token").val()} });
    $.ajax({
        url: "monthly_evaluations_details_form_update",
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
function ConfirmUpdateData_monthly_evaluations_details(table) {
    var errorList = [];
    var form_data = new FormData();
    var outputErr=[];
    form_data.append("table", "monthly_evaluations_details"  );
    form_data.append("id", $("#id").val()  );


    /*********** start not required fields ***********/
    form_data.append("n_a", $("#n_a").val());
    form_data.append("below_standard", $("#below_standard").val());
    form_data.append("meets_standard", $("#meets_standard").val());
    form_data.append("above_standard", $("#above_standard").val());
    form_data.append("feedback_discussion", $("#feedback_discussion").val());
    form_data.append("feedback", $("#feedback").val());
    form_data.append("aspects", $("#aspects").val());
    form_data.append("suggested", $("#suggested").val());
    form_data.append("able_perform_procedure", $("#able_perform_procedure").val());
    form_data.append("unable_perform_procedure", $("#unable_perform_procedure").val());
    form_data.append("trained_and_competent", $("#trained_and_competent").val());
    form_data.append("able_perform_procedure_limited", $("#able_perform_procedure_limited").val());
    form_data.append("competent_perform_procedure_unsupervised", $("#competent_perform_procedure_unsupervised").val());
    form_data.append("agree_action_plan", $("#agree_action_plan").val());
    /*********** end not required fields ***********/


    /*********** start required fields ***********/
    if ($("#monthly_evaluations_id").val() == -1) {
      errorList.push("Err_monthly_evaluations_id");
      $("#monthly_evaluations_id").next().toggleClass("border_red", $("#monthly_evaluations_id :selected").val() == -1);
    } else {
      $("#monthly_evaluations_id").next().toggleClass("border_green", $("#monthly_evaluations_id :selected").val() > 0);
      errorList.splice(errorList.indexOf("Err_monthly_evaluations_id"), -1)
      form_data.append("monthly_evaluations_id", $("#monthly_evaluations_id").val());
    }
    if ($("#assessment_criteria_id").val() == -1) {
      errorList.push("Err_assessment_criteria_id");
      $("#assessment_criteria_id").next().toggleClass("border_red", $("#assessment_criteria_id :selected").val() == -1);
    } else {
      $("#assessment_criteria_id").next().toggleClass("border_green", $("#assessment_criteria_id :selected").val() > 0);
      errorList.splice(errorList.indexOf("Err_assessment_criteria_id"), -1)
      form_data.append("assessment_criteria_id", $("#assessment_criteria_id").val());
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
                   url: "monthly_evaluations_details_update",
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
  function  monthly_evaluations_details_ConfirmInsertData() {
  // PROCCESS 7000001
    var errorList = [];
    var outputErr = [];
    var form_data = new FormData();
    form_data.append("table", "monthly_evaluations_details");


    /*********** start not required fields ***********/
    form_data.append("n_a", $("#n_a").val());
    form_data.append("below_standard", $("#below_standard").val());
    form_data.append("meets_standard", $("#meets_standard").val());
    form_data.append("above_standard", $("#above_standard").val());
    form_data.append("feedback_discussion", $("#feedback_discussion").val());
    form_data.append("feedback", $("#feedback").val());
    form_data.append("aspects", $("#aspects").val());
    form_data.append("suggested", $("#suggested").val());
    form_data.append("able_perform_procedure", $("#able_perform_procedure").val());
    form_data.append("unable_perform_procedure", $("#unable_perform_procedure").val());
    form_data.append("trained_and_competent", $("#trained_and_competent").val());
    form_data.append("able_perform_procedure_limited", $("#able_perform_procedure_limited").val());
    form_data.append("competent_perform_procedure_unsupervised", $("#competent_perform_procedure_unsupervised").val());
    form_data.append("agree_action_plan", $("#agree_action_plan").val());
    /*********** end not required fields ***********/


    /*********** start required fields ***********/
    if ($("#monthly_evaluations_id").val() == -1) {
      errorList.push("Err_monthly_evaluations_id");
      $("#monthly_evaluations_id").next().toggleClass("border_red", $("#monthly_evaluations_id :selected").val() == -1);
    } else {
      $("#monthly_evaluations_id").next().toggleClass("border_green", $("#monthly_evaluations_id :selected").val() > 0);
      errorList.splice(errorList.indexOf("Err_monthly_evaluations_id"), -1)
      form_data.append("monthly_evaluations_id", $("#monthly_evaluations_id").val());
    }
    if ($("#assessment_criteria_id").val() == -1) {
      errorList.push("Err_assessment_criteria_id");
      $("#assessment_criteria_id").next().toggleClass("border_red", $("#assessment_criteria_id :selected").val() == -1);
    } else {
      $("#assessment_criteria_id").next().toggleClass("border_green", $("#assessment_criteria_id :selected").val() > 0);
      errorList.splice(errorList.indexOf("Err_assessment_criteria_id"), -1)
      form_data.append("assessment_criteria_id", $("#assessment_criteria_id").val());
    }
    /*********** start required fields ***********/


 $.ajaxSetup({ headers: {  "X-CSRF-TOKEN": $("#token").val()} });
  if (errorList.length == 0) {
     $(".loader").addClass(" fa-spinner fa-spin");
     $("#Save").prop("disabled", true);
     $("#Close").prop("disabled", true);
     $(".loader").addClass(" fa-spinner fa-spin");
           $.ajax({ 
                   url: "monthly_evaluations_details_insert",
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
//delete from table monthly_evaluations_details start 
function delete_form_monthly_evaluations_details(id) {
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
    output += "<div class='alert alert-danger bg-danger text-white border-0 m-0'><h3> "+msg+"</h3> <div class='modal-footer' id='modal-footer'  > <input type='button'    value='"+btn_yes+" '  id='confirmDelete' onclick='ConfirmDelete_monthly_evaluations_details(\""+id+"\")'   class='btn btn-success'><input type= 'button'  data-bs-toggle='modal'    data-bs-target='.bd-dialog-modal-lg' data-toggle='modal' data-target='.bd-dialog-modal-lg'  data-bs-dismiss='modal' value='"+btn_no+" ' onclick='hidepopup()' class='btn btn-warning'></div></div>";
    $(".result_content").html(output)
}
// delete from table  monthly_evaluations_details end


//confirm delete from table  monthly_evaluations_details end
function ConfirmDelete_monthly_evaluations_details(id) {
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
    
        $.get("monthly_evaluations_details_delete", {
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
//confirm delete from table  monthly_evaluations_details end
/**************************************************************************/
/*************End Functionality to table monthly_evaluations_details ******************/
/*************************************************************************/
