

/*
This code generated automatically by generatesystems.com
*/


/**************************************************************************/
/*************Begin Functionality to table logsystem ******************/
/*************************************************************************/


 
 

//Details Button Function 
function getDetails_activitylog(id ) { 
    $(".result").show();
    $(".result_content").html("<img   src='../images/loading.gif'  class='loaderImgPopup' />");
    var  table = $("#hiddenTable").val();
    $.get("logsystem_details", {
          id: id,
       table: table,
    }, function (data) {
         $(".result_content").css("background","white");
         $(".result_content").html(data);
    });
}


 
