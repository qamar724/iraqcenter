<?php

use App\Http\Controllers\ThemeSetting;
use App\Http\Controllers\CheckEditor;
use App\Http\Controllers\AdminController\activitylog_controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController\Website;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\SystemController\LanguageController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\AdminController\users_controller;
use App\Http\Controllers\AdminController\tbl_users_type_controller;
use App\Http\Controllers\AdminController\genders_controller;
use App\Http\Controllers\AdminController\status_controller;
use App\Http\Controllers\AdminController\university_major_controller;
use App\Http\Controllers\AdminController\city_controller;
use App\Http\Controllers\AdminController\hospitals_controller;
use App\Http\Controllers\AdminController\specialties_controller;
use App\Http\Controllers\AdminController\hospitals_has_specialties_controller;
use App\Http\Controllers\AdminController\distributions_controller;
use App\Http\Controllers\AdminController\clinical_setting_controller;
use App\Http\Controllers\AdminController\monthly_evaluation_forms_controller;
use App\Http\Controllers\AdminController\assessment_criteria_controller;
use App\Http\Controllers\AdminController\monthly_evaluations_controller;
use App\Http\Controllers\AdminController\monthly_evaluations_details_controller;
use App\Http\Controllers\AdminController\Profileuser;
use App\Http\Controllers\AdminController\doctors_controller;
use App\Http\Controllers\AdminController\category_procedure_controller;
use App\Http\Controllers\AdminController\procedure_list_controller;
use App\Http\Controllers\UserImportController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This Route Page has been generated Automatically by generatesystems.com
*/

Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get("/adminPanel", function () {
        return view("auth.login");
    })->name("login"); // Define the login route and name it "login"
});



/* if you want administrator login to adminpanel please replace middleware like this :
   * "middleware"=>["auth:sanctum","is_admin"]
   */

Route::post("/checklogin", [AuthController::class, "loginWeb"])->name("checklogin");
Route::group(["prefix" => "adminPanel", "as" => "adminPanel.", "middleware" => ["auth:sanctum"]], function () {
    Route::get("/dashboard", function () {
        return view("adminDashboard.dashboard.mainPage");
    })->name("dashboard");
    Route::get("/mainPage", function () {
        return view("adminDashboard.dashboard.mainPage");
    })->name("mainPage");

    Route::get("changelanguage", [LanguageController::class, "changeLanguage"]);
    Route::get("getUpdateForm", [Profileuser::class, "getUpdateForm"]);
    Route::post("ConfirmProfile", [Profileuser::class, "ConfirmProfile"]);
    Route::post("ConfirmProfileDirect", [Profileuser::class, "ConfirmProfileDirect"]);
    Route::get("getFormToChangePassword", [Profileuser::class, "getFormToChangePassword"]);
    Route::post("ConfirmchangePassword", [Profileuser::class, "ConfirmchangePassword"]);
    Route::post("UsersChangePassword_form_users", [Profileuser::class, "UsersChangePassword_form_users"]);
    Route::post("ConfirmchangePasswordFromAdmin", [Profileuser::class, "ConfirmchangePasswordFromAdmin"]);
    Route::post("LockUnlockAccount_form_users", [Profileuser::class, "LockUnlockAccount_form_users"]);
    Route::get("activitylog", [activitylog_controller::class, "index"]);
    Route::post("activitylog", [activitylog_controller::class, "index"]);
    Route::get("logsystem_details", [activitylog_controller::class, "logsystem_details"]);



    /*****************users********************/
    Route::get("users", [users_controller::class, "index"]);
    Route::post("users", [users_controller::class, "index"]);
    Route::get("users_form_add", [users_controller::class, "users_form_add"]);
    Route::post("users_insert", [users_controller::class, "users_insert"]);
    Route::post("users_form_update", [users_controller::class, "users_form_update"]);
    Route::post("users_update", [users_controller::class, "users_update"]);
    Route::get("users_delete", [users_controller::class, "users_delete"]);
    Route::get("users_get_hospitals_by_city_id", [users_controller::class, "users_get_hospitals_by_city_id"]);
    /***************** End Routes belong to users********************/



    /*****************tbl_users_type********************/
    Route::get("tbl_users_type", [tbl_users_type_controller::class, "index"]);
    Route::post("tbl_users_type", [tbl_users_type_controller::class, "index"]);
    Route::get("tbl_users_type_form_add", [tbl_users_type_controller::class, "tbl_users_type_form_add"]);
    Route::post("tbl_users_type_insert", [tbl_users_type_controller::class, "tbl_users_type_insert"]);
    Route::post("tbl_users_type_form_update", [tbl_users_type_controller::class, "tbl_users_type_form_update"]);
    Route::post("tbl_users_type_update", [tbl_users_type_controller::class, "tbl_users_type_update"]);
    Route::get("tbl_users_type_delete", [tbl_users_type_controller::class, "tbl_users_type_delete"]);
    Route::get("permission_form_roles", [tbl_users_type_controller::class, "permission_form_roles"]);
    Route::post("insertPermissions", [tbl_users_type_controller::class, "insertPermissions"]);
    Route::post("removePermissions", [tbl_users_type_controller::class, "removePermissions"]);
    /***************** End Routes belong to tbl_users_type********************/



    /*****************genders********************/
    Route::get("genders", [genders_controller::class, "index"]);
    Route::post("genders", [genders_controller::class, "index"]);
    Route::get("genders_form_add", [genders_controller::class, "genders_form_add"]);
    Route::post("genders_insert", [genders_controller::class, "genders_insert"]);
    Route::post("genders_form_update", [genders_controller::class, "genders_form_update"]);
    Route::post("genders_update", [genders_controller::class, "genders_update"]);
    Route::get("genders_delete", [genders_controller::class, "genders_delete"]);
    /***************** End Routes belong to genders********************/



    /*****************category_procedure********************/
    Route::get("category_procedure", [category_procedure_controller::class, "index"]);
    Route::post("category_procedure", [category_procedure_controller::class, "index"]);
    Route::get("category_procedure_form_add", [category_procedure_controller::class, "category_procedure_form_add"]);
    Route::post("category_procedure_insert", [category_procedure_controller::class, "category_procedure_insert"]);
    Route::post("category_procedure_form_update", [category_procedure_controller::class, "category_procedure_form_update"]);
    Route::post("category_procedure_update", [category_procedure_controller::class, "category_procedure_update"]);
    Route::get("category_procedure_delete", [category_procedure_controller::class, "category_procedure_delete"]);
    /***************** End Routes belong to category_procedure********************/



    /*****************status********************/
    Route::get("status", [status_controller::class, "index"]);
    Route::post("status", [status_controller::class, "index"]);
    Route::get("status_form_add", [status_controller::class, "status_form_add"]);
    Route::post("status_insert", [status_controller::class, "status_insert"]);
    Route::post("status_form_update", [status_controller::class, "status_form_update"]);
    Route::post("status_update", [status_controller::class, "status_update"]);
    Route::get("status_delete", [status_controller::class, "status_delete"]);
    /***************** End Routes belong to status********************/



    /*****************university_major********************/
    Route::get("university_major", [university_major_controller::class, "index"]);
    Route::post("university_major", [university_major_controller::class, "index"]);
    Route::get("university_major_form_add", [university_major_controller::class, "university_major_form_add"]);
    Route::post("university_major_insert", [university_major_controller::class, "university_major_insert"]);
    Route::post("university_major_form_update", [university_major_controller::class, "university_major_form_update"]);
    Route::post("university_major_update", [university_major_controller::class, "university_major_update"]);
    Route::get("university_major_delete", [university_major_controller::class, "university_major_delete"]);
    /***************** End Routes belong to university_major********************/



    /*****************city********************/
    Route::get("city", [city_controller::class, "index"]);
    Route::post("city", [city_controller::class, "index"]);
    Route::get("city_form_add", [city_controller::class, "city_form_add"]);
    Route::post("city_insert", [city_controller::class, "city_insert"]);
    Route::post("city_form_update", [city_controller::class, "city_form_update"]);
    Route::post("city_update", [city_controller::class, "city_update"]);
    Route::get("city_delete", [city_controller::class, "city_delete"]);
    /***************** End Routes belong to city********************/



    /*****************hospitals********************/
    Route::get("hospitals", [hospitals_controller::class, "index"]);
    Route::post("hospitals", [hospitals_controller::class, "index"]);
    Route::get("hospitals_form_add", [hospitals_controller::class, "hospitals_form_add"]);
    Route::post("hospitals_insert", [hospitals_controller::class, "hospitals_insert"]);
    Route::post("hospitals_form_update", [hospitals_controller::class, "hospitals_form_update"]);
    Route::post("hospitals_update", [hospitals_controller::class, "hospitals_update"]);
    Route::get("hospitals_delete", [hospitals_controller::class, "hospitals_delete"]);
    /***************** End Routes belong to hospitals********************/



    /*****************specialties********************/
    Route::get("specialties", [specialties_controller::class, "index"]);
    Route::post("specialties", [specialties_controller::class, "index"]);
    Route::get("specialties_form_add", [specialties_controller::class, "specialties_form_add"]);
    Route::post("specialties_insert", [specialties_controller::class, "specialties_insert"]);
    Route::post("specialties_form_update", [specialties_controller::class, "specialties_form_update"]);
    Route::post("specialties_update", [specialties_controller::class, "specialties_update"]);
    Route::get("specialties_delete", [specialties_controller::class, "specialties_delete"]);
    /***************** End Routes belong to specialties********************/



    /*****************hospitals_has_specialties********************/
    Route::get("hospitals_has_specialties", [hospitals_has_specialties_controller::class, "index"]);
    Route::post("hospitals_has_specialties", [hospitals_has_specialties_controller::class, "index"]);
    Route::get("hospitals_has_specialties_form_add", [hospitals_has_specialties_controller::class, "hospitals_has_specialties_form_add"]);
    Route::post("hospitals_has_specialties_insert", [hospitals_has_specialties_controller::class, "hospitals_has_specialties_insert"]);
    Route::post("hospitals_has_specialties_form_update", [hospitals_has_specialties_controller::class, "hospitals_has_specialties_form_update"]);
    Route::post("hospitals_has_specialties_update", [hospitals_has_specialties_controller::class, "hospitals_has_specialties_update"]);
    Route::get("hospitals_has_specialties_delete", [hospitals_has_specialties_controller::class, "hospitals_has_specialties_delete"]);
    /***************** End Routes belong to hospitals_has_specialties********************/



    /*****************distributions********************/
    Route::get("distributions", [distributions_controller::class, "index"]);
    Route::post("distributions", [distributions_controller::class, "index"]);
    Route::get("distributions_form_add", [distributions_controller::class, "distributions_form_add"]);
    Route::post("distributions_insert", [distributions_controller::class, "distributions_insert"]);
    Route::post("distributions_form_update", [distributions_controller::class, "distributions_form_update"]);
    Route::post("distributions_update", [distributions_controller::class, "distributions_update"]);
    Route::get("distributions_delete", [distributions_controller::class, "distributions_delete"]);
    Route::get("distributions_get_hospitals_has_specialties_by_hospitals_id", [distributions_controller::class, "distributions_get_hospitals_has_specialties_by_hospitals_id"]);
    /***************** End Routes belong to distributions********************/



    /*****************clinical_setting********************/
    Route::get("clinical_setting", [clinical_setting_controller::class, "index"]);
    Route::post("clinical_setting", [clinical_setting_controller::class, "index"]);
    Route::get("clinical_setting_form_add", [clinical_setting_controller::class, "clinical_setting_form_add"]);
    Route::post("clinical_setting_insert", [clinical_setting_controller::class, "clinical_setting_insert"]);
    Route::post("clinical_setting_form_update", [clinical_setting_controller::class, "clinical_setting_form_update"]);
    Route::post("clinical_setting_update", [clinical_setting_controller::class, "clinical_setting_update"]);
    Route::get("clinical_setting_delete", [clinical_setting_controller::class, "clinical_setting_delete"]);
    /***************** End Routes belong to clinical_setting********************/



    /*****************monthly_evaluation_forms********************/
    Route::get("monthly_evaluation_forms", [monthly_evaluation_forms_controller::class, "index"]);
    Route::post("monthly_evaluation_forms", [monthly_evaluation_forms_controller::class, "index"]);
    Route::get("monthly_evaluation_forms_form_add", [monthly_evaluation_forms_controller::class, "monthly_evaluation_forms_form_add"]);
    Route::post("monthly_evaluation_forms_insert", [monthly_evaluation_forms_controller::class, "monthly_evaluation_forms_insert"]);
    Route::post("monthly_evaluation_forms_form_update", [monthly_evaluation_forms_controller::class, "monthly_evaluation_forms_form_update"]);
    Route::post("monthly_evaluation_forms_update", [monthly_evaluation_forms_controller::class, "monthly_evaluation_forms_update"]);
    Route::get("monthly_evaluation_forms_delete", [monthly_evaluation_forms_controller::class, "monthly_evaluation_forms_delete"]);
    /***************** End Routes belong to monthly_evaluation_forms********************/



    /*****************assessment_criteria********************/
    Route::get("assessment_criteria", [assessment_criteria_controller::class, "index"]);
    Route::post("assessment_criteria", [assessment_criteria_controller::class, "index"]);
    Route::get("assessment_criteria_form_add", [assessment_criteria_controller::class, "assessment_criteria_form_add"]);
    Route::post("assessment_criteria_insert", [assessment_criteria_controller::class, "assessment_criteria_insert"]);
    Route::post("assessment_criteria_form_update", [assessment_criteria_controller::class, "assessment_criteria_form_update"]);
    Route::post("assessment_criteria_update", [assessment_criteria_controller::class, "assessment_criteria_update"]);
    Route::get("assessment_criteria_delete", [assessment_criteria_controller::class, "assessment_criteria_delete"]);
    /***************** End Routes belong to assessment_criteria********************/



    /*****************monthly_evaluations********************/
    Route::get("monthly_evaluations", [monthly_evaluations_controller::class, "index"]);
    Route::post("monthly_evaluations", [monthly_evaluations_controller::class, "index"]);
    Route::get("monthly_evaluations_form_add", [monthly_evaluations_controller::class, "monthly_evaluations_form_add"]);
    Route::post("monthly_evaluations_insert", [monthly_evaluations_controller::class, "monthly_evaluations_insert"]);
    Route::post("monthly_evaluations_form_update", [monthly_evaluations_controller::class, "monthly_evaluations_form_update"]);
    Route::post("monthly_evaluations_update", [monthly_evaluations_controller::class, "monthly_evaluations_update"]);
    Route::get("monthly_evaluations_delete", [monthly_evaluations_controller::class, "monthly_evaluations_delete"]);
    Route::post("monthly_evaluations_info", [monthly_evaluations_controller::class, "monthly_evaluations_info"]);
  Route::post("get_evaluation_forms", [monthly_evaluations_controller::class, "get_evaluation_forms"]);
  Route::post("get_evaluation_form_template", [monthly_evaluations_controller::class, "get_evaluation_form_template"]);
  Route::post("get_evaluation_form_data", [monthly_evaluations_controller::class, "get_evaluation_form_data"]);
  Route::post("save_evaluation_form", [monthly_evaluations_controller::class, "save_evaluation_form"]);
  Route::get("print_evaluation_pdf", [monthly_evaluations_controller::class, "print_evaluation_pdf"]);
  /***************** End Routes belong to monthly_evaluations********************/



    /*****************monthly_evaluations_details********************/
    Route::get("monthly_evaluations_details", [monthly_evaluations_details_controller::class, "index"]);
    Route::post("monthly_evaluations_details", [monthly_evaluations_details_controller::class, "index"]);
    Route::get("monthly_evaluations_details_form_add", [monthly_evaluations_details_controller::class, "monthly_evaluations_details_form_add"]);
    Route::post("monthly_evaluations_details_insert", [monthly_evaluations_details_controller::class, "monthly_evaluations_details_insert"]);
    Route::post("monthly_evaluations_details_form_update", [monthly_evaluations_details_controller::class, "monthly_evaluations_details_form_update"]);
    Route::post("monthly_evaluations_details_update", [monthly_evaluations_details_controller::class, "monthly_evaluations_details_update"]);
    Route::get("monthly_evaluations_details_delete", [monthly_evaluations_details_controller::class, "monthly_evaluations_details_delete"]);
    /***************** End Routes belong to monthly_evaluations_details********************/



    /*****************doctors********************/
    Route::get("doctors", [doctors_controller::class, "index"]);
    Route::post("doctors", [doctors_controller::class, "index"]);
Route::post("doctors_import", [doctors_controller::class, "doctors_import"]);
    Route::get('doctors_import_add', [doctors_controller::class, 'doctors_import_add'])->name('doctors.import');
    Route::get('doctors_import_sample', [doctors_controller::class, 'doctors_import_sample'])->name('doctors.import.sample');
    Route::post("fileupload", [CheckEditor::class, "fileupload"]);
    Route::post("doctors_form_update", [doctors_controller::class, "doctors_form_update"]);
    Route::post("doctors_update", [doctors_controller::class, "doctors_update"]);
    Route::get("doctors_delete", [doctors_controller::class, "doctors_delete"]);

    /***************** End Routes belong to doctors********************/

    /*****************procedure list********************/
    Route::get("procedure_list", [procedure_list_controller::class, "index"]);
    Route::post("procedure_list", [procedure_list_controller::class, "index"]);
    Route::get("procedure_list_form_add", [procedure_list_controller::class, "procedure_list_form_add"]);
    Route::post("procedure_list_insert", [procedure_list_controller::class, "procedure_list_insert"]);
    Route::post("procedure_list_form_update", [procedure_list_controller::class, "procedure_list_form_update"]);
    Route::post("procedure_list_update", [procedure_list_controller::class, "procedure_list_update"]);
    Route::get("procedure_list_delete", [procedure_list_controller::class, "procedure_list_delete"]);

    /***************** End Routes belong to procedure_list********************/

});

//logout route
Route::get("/adminPanel/logout", function () {
    auth()->logout();
    Session()->flush();
    return Redirect::to("/adminPanel");
})->name("logout");

/******** Start write you website route here *********/
Route::get("/", [Website::class, "Home"]);
