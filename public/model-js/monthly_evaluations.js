

/*
This code generated automatically by generatesystems.com
*/


/**************************************************************************/
/*************Begin Functionality to table monthly_evaluations ******************/
/*************************************************************************/


// Info popup button start
function info_form_monthly_evaluations(id) {
    $(".result").show();
    $(".result_content").html("<img src='../images/loading.gif' class='loaderImgPopup' />");
    $.ajaxSetup({ headers: { "X-CSRF-TOKEN": $("#token").val() } });
    $.ajax({
        url: "monthly_evaluations_info",
        method: "post",
        data: {
            id: id,
        },
        success: function (result) {
            $(".result_content").html(result)
        },
    });
}
// Info popup button end


/**************************************************************************/
/*************End Functionality to table monthly_evaluations ******************/
/*************************************************************************/

