function changeLangTO(lang) {
    $.get(
        "changelanguage",
        {
            lang: lang,
        },
        function (data) {
            location.reload();
        }
    );
}
function setThemeMode() {
    var themeMode = $("#themeMode").val();
    document.cookie =
        "themeMode=" + themeMode + "; expires=Thu, 18 Dec 2030 12:00:00 UTC";
    $("body").attr("data-theme-version", themeMode);
}
function setmenuStyle() {
    var menuStyle = $("#menuStyle").val();
    document.cookie =
        "menuStyle=" + menuStyle + "; expires=Thu, 18 Dec 2030 12:00:00 UTC";
    $("body").attr("data-layout", menuStyle);
}
function setmenuType() {
    var menuType = $("#menuType").val();
    document.cookie =
        "menuType=" + menuType + "; expires=Thu, 18 Dec 2030 12:00:00 UTC";
    $("body").attr("data-sidebar-style", menuType);
}
function setmenuPosition() {
    var menuPosition = $("#menuPosition").val();
    document.cookie =
        "menuPosition=" +
        menuPosition +
        "; expires=Thu, 18 Dec 2030 12:00:00 UTC";
    $("body").attr("data-sidebar-position", menuPosition);
}
function setheaderPosition() {
    var headerPosition = $("#headerPosition").val();
    document.cookie =
        "headerPosition=" +
        headerPosition +
        "; expires=Thu, 18 Dec 2030 12:00:00 UTC";
    $("body").attr("data-header-position", headerPosition);
}
function setcontainerLayout() {
    var containerLayout = $("#containerLayout").val();
    document.cookie =
        "containerLayout=" +
        containerLayout +
        "; expires=Thu, 18 Dec 2030 12:00:00 UTC";
    $("body").attr("data-container", containerLayout);
}
function setheaderBgColor() {
    var headerBg = $("#headerBg").val();
    document.cookie =
        "headerBg=" + headerBg + "; expires=Thu, 18 Dec 2030 12:00:00 UTC";
    $("body").attr("data-headerbg", headerBg);
}
function setnavheaderBg() {
    var navheaderBg = $("#navheaderBg").val();
    document.cookie =
        "navheaderBg=" +
        navheaderBg +
        "; expires=Thu, 18 Dec 2030 12:00:00 UTC";
    $("body").attr("data-nav-headerbg", navheaderBg);
}
function setsidebarBg() {
    var sidebarBg = $("#sidebarBg").val();
    document.cookie =
        "sidebarBg=" + sidebarBg + "; expires=Thu, 18 Dec 2030 12:00:00 UTC";
    $("body").attr("data-sibebarbg", sidebarBg);
}
function getFormToApplyTheme() {
    $(".result").show();
    $(".result_content").html(
        "<img   src='../images/loading.gif'  class='loaderImgPopup' />"
    );
    $.get("themeSetting", {}, function (data) {
        $(".result_content").html(data);
    });
}
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(";");
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == " ") {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function hidepopup() {
    $(".result").hide();
}
function hidepopupChangePassword() {
    $(".PassContainer").hide();
}
function hidepopupProfile() {
    $(".ProfileContainer").hide();
}
function hidepopupNotification() {
    $(".NotificationContainer").hide();
}
// laravel public function start
function getUpdateForm() {
    $(".result").show();
    $(".result_content").html(
        "<img   src='../images/loading.gif'  class='loaderImgPopup' />"
    );
    $.get("getUpdateForm", {}, function (data) {
        $(".result_content").html(data);
    });
}
function ConfirmProfile() {
    var errorList = [];
    var form_data = new FormData();
    if ($("#name").val() == "") {
        errorList.push("name");
        $("#name").css("border", "1px solid red");
    } else {
        $("#name").css("border", "1px solid green");
        errorList.splice(errorList.indexOf("name"), -1);
        form_data.append("name", $("#name").val());
    }
    if ($("#email").val() == "") {
        errorList.push("email");
        $("#email").css("border", "1px solid red");
    } else {
        $("#email").css("border", "1px solid green");
        errorList.splice(errorList.indexOf("email"), -1);
        form_data.append("email", $("#email").val());
    }
    if ($("#profile_photo_path").val() != "") {
        var file_data = $("#profile_photo_path").prop("files")[0];
        form_data.append("profile_photo_path", file_data);
    }
    $.ajaxSetup({ headers: { "X-CSRF-TOKEN": $("#token").val() } });
    if (errorList.length == 0) {
        $.ajaxSetup({ headers: { "X-CSRF-TOKEN": $("#token").val() } });
        $(".loader").addClass(" fa-spinner fa-spin");
        $("#Save").prop("disabled", true);
        $("#Close").prop("disabled", true);
        $.ajax({
            url: "ConfirmProfileDirect",
            dataType: "text", // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            data: form_data,
            type: "post",
            beforeSend: function () {},
            success: function (data) {
                //console.log(response);
                if (data.response == "updated") {
                    location.reload();
                } else if (data.response == "dublicated") {
                    $(".errorsResults").show();
                    $(".errorsResults").html(
                        "<p class= 'alert alert-danger'    >Sorry, field  (" +
                            data.dublicateField +
                            ") already exists not allow dublicated </p>"
                    );
                }
            },
            error: function (data) {
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
            },
        });
    }
}
function getFormToChangePassword() {
    $(".result").show();
    $(".result_content").html(
        "<img   src='../images/loading.gif'  class='loaderImgPopup' />"
    );
    $.get("getFormToChangePassword", {}, function (data) {
        $(".result_content").html(data);
    });
}
function ConfirmchangePassword() {
    var currentPassword = $("#currentPassword").val();
    var newPassword = $("#newPassword").val();
    var repeatPassword = $("#repeatPassword").val();
    $.ajaxSetup({ headers: { "X-CSRF-TOKEN": $("#token").val() } });
    $.post(
        "ConfirmchangePassword",
        {
            oldpassword: currentPassword,
            password: newPassword,
            repeatPassword: repeatPassword,
        },
        function (data) {
            if (data.response == "NewPasswor_not_match_repeatPassword") {
                $("#changePasswordResult").html(
                    "<p class='alert alert-danger'>" + data.label + "</p>"
                );
            } else if (data.response == "CurrentPasswordNotMatch") {
                $("#changePasswordResult").html(
                    "<p class='alert alert-danger'>" + data.label + "</p>"
                );
            } else if (data.response == "updatedSuccessfully") {
                $("#changePasswordResult").html(
                    "<p class='alert alert-success'>" + data.label + "</p>"
                );
            } else if (data.response == "allFieldRequired") {
                $("#changePasswordResult").html(
                    "<p class='alert alert-danger'>" + data.label + "</p>"
                );
            }
        },
        "json"
    );
}
// laravel public function end
function toggleFilter() {
    $("#filterDialog").slideToggle();
    var valuebtn = $("#showFilter").val();
    if (valuebtn == "Show filter") {
        $("#showFilter").val("Hide filter");
        $("#showFilter").removeClass(" btn-success");
        $("#showFilter").addClass("btn btn-danger");
    } else {
        $("#showFilter").removeClass(" btn-danger");
        $("#showFilter").addClass("btn btn-success");
        $("#showFilter").val("Show filter");
    }
}
function login() {
    var email = $("#email").val();
    var password = $("#password").val();
    if (email === "" || password === "") {
        $("#login_btn").prop("disabled", false);
        $("#feedback").html(
            "<div class='alert alert-danger'>Sorry, email and password are required</div>"
        );
    } else {
        $("#login_btn").prop("disabled", true);
        $("#feedback").html(`
        <div class='alert alert-info' style='display: flex; justify-content: space-between; align-items: center;'>
            <div class='loader'></div>
            <div>Please wait, we are checking your data...</div>
        </div>
    `);
        $(".loader").addClass("fa-spinner fa-spin");
        $.ajax({
            url: "checklogin", // Update the URL to match your Laravel route
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                email: email,
                password: password,
                remember_me: $("#remember").is(":checked"),
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                $("#feedback").html(`
                <div class='alert alert-info' style='display: flex; justify-content: space-between; align-items: center;'>
                    <div>Authenticated successfully. We will redirect you.</div>
                </div>
            `);
                window.location.href = "adminPanel/dashboard";
            },
            error: function (xhr, status, error) {
                $("#login_btn").prop("disabled", false);
                console.log(xhr.responseJSON.status);
                if (xhr.responseJSON && xhr.responseJSON.status) {
                    var errors = xhr.responseJSON.message;
                    var errorHtml = "<ul>";
                    errorHtml +=
                        '<li class="alert alert-danger">' + errors + "</li>";
                    errorHtml += "</ul>";
                    $("#feedback").html(errorHtml);
                } else {
                    // Handle general error cases
                    var statusCode = xhr.status;
                    var errorMessage = "Error: " + statusCode + " " + error;
                    $("#feedback").text(errorMessage);
                }
            },
        });
    }
}
function logins() {
    var email = $("#email").val();
    var password = $("#password").val();
    if (email == "" || password == "") {
        $("#feedback").html(
            "<div class='alert alert-danger'>Sorry, email and password are required</div>"
        );
    } else {
        $("#feedback").html(
            "<div class='alert alert-info'>Please wait , we are checking you data...</div>"
        );
        $.ajaxSetup({ headers: { "X-CSRF-TOKEN": $("#token").val() } });
        $.post(
            "checklogin",
            {
                email: email,
                password: password,
            },
            function (data) {
                if (data.status == "success") {
                    window.location.href = "index.php";
                } else if (data.status == "passwordnotmatch") {
                    $("#result").html(
                        "<div class='alert alert-danger'>Sorry, email and password is not match</div>"
                    );
                } else if (data.status == "usernotfound") {
                    $("#result").html(
                        "<div class='alert alert-danger'>Sorry, email  is not found</div>"
                    );
                } else if (data.status == "user_not_active") {
                    $("#result").html(
                        "<div class='alert alert-danger'>Sorry, email  is not active</div>"
                    );
                }
            },
            "json"
        );
    }
}
$(document).keyup(function (e) {
    //if (e.keyCode === 13) $('#Save').click();     // enter need fix later
    if (e.keyCode === 27) $("#Close").click(); // esc
});


function changeLayoutUser(key,value){
    document.cookie = key + "=" + value + "; expires=Thu, 18 Dec 2030 12:00:00 UTC";
    location.reload();
}

function changeRowsPerPage(table){
    var rowsPerPage = $("#rowsPerPage").val();
    var key = table + "_pagination";
    document.cookie = key + "=" + rowsPerPage + "; expires=Thu, 18 Dec 2030 12:00:00 UTC";
    location.reload();
}