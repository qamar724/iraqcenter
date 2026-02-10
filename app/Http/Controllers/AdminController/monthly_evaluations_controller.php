<?php 
namespace App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SystemController\Delete;
use App\Http\Controllers\SystemController\Permission;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\monthly_evaluations_model;
use App\Models\Admin\monthly_evaluations_details_model;
use App\Models\Admin\monthly_evaluations_answers_model;
use App\Models\Admin\monthly_evaluations_clinical_model;
use App\Models\Admin\users_model;
use App\Models\Admin\hospitals_has_specialties_model;
use App\Models\Admin\monthly_evaluation_forms_model;
use App\Models\Admin\procedure_list_model;
use App\Models\Admin\category_procedure_model;
use App\Http\Controllers\AdminController\UserAuthController;
class monthly_evaluations_controller extends Controller
{
 /*  
  This controller has been generated Automatically by generatesystems.com  
  */ 
/**************Start Table (monthly_evaluations) Functionality **************/
function index(Request $request)
  {
  //  proccess 100000075
  $lang =app()->getLocale();   
  $host = request()->getHttpHost();   
  $hostUrl = "https://".$host."/uploads/documents/";  
  $data = monthly_evaluations_model::select(    
                  "monthly_evaluations.id   AS  id",
                  "users.name    AS  users_id_name",
                  "monthly_evaluations.users_id   AS  users_id",
                  "specialties.name_$lang    AS  specialties_name",
                  "monthly_evaluations.hospitals_has_specialties_id   AS  hospitals_has_specialties_id"
                   )
                 ->join ( 'users as users' ,'monthly_evaluations.users_id', '=', 'users.id'  )
                 ->join ( 'hospitals_has_specialties as hospitals_has_specialties' ,'monthly_evaluations.hospitals_has_specialties_id', '=', 'hospitals_has_specialties.id'  )
                 ->join ( 'specialties as specialties' ,'hospitals_has_specialties.specialties_id', '=', 'specialties.id'  )
                   ;

/***********This area refer to search and paginate  ****************/
/******************** Dont modify this code ************************/
if (count($request->input()) >=1) {
   foreach ($request->input() as $key=>$value) {
       if ($key != "_token" || $key !="page") {
           if (strpos($key, "key_") !== false) {
               $exp_key = explode("key_", $key);
               $exp_key = $exp_key[1];
               $value =decrypt($value);
               if ($value != null && $value != ""  && $value > 0) {
                    $data=$data->where("monthly_evaluations.$exp_key", "=", $value) ;
               }
           }
           if (strpos($key, "id_") !== false) {
               $exp_key = explode("id_", $key);
               $exp_key = $exp_key[1];
               if ($value != null && $value != ""  && $value > 0) {
                if($exp_key == "from_date" || $exp_key == "to_date"){ 
                  if($exp_key =="from_date" ){ 
                    $exp_key = "created_at"; 
                    $value = $value." 00:00:00"; 
                    $data=$data->where("monthly_evaluations.$exp_key", ">=", $value) ; 
                  }elseif($exp_key =="to_date"){ 
                    $exp_key = "created_at"; 
                    $value = $value." 23:59:59"; 
                    $data=$data->where("monthly_evaluations.$exp_key", "<=", $value) ; 
                  } 
                }else{ 
                  $data=$data->where("monthly_evaluations.$exp_key", "=", $value) ; 
                } 
 
               }
           }
       }
   }
}
 /********************************************************************/
 $data=$data->where("monthly_evaluations.is_deleted","=",0);// 0 not deleted & 1 is deleted

/****** Start User Type Based Filtering ******/
$currentUser = Auth::user();
$userTypeId = $currentUser["tbl_users_type_id"];

// Disable Add, Edit, Delete for all users - View only page
$permissions = array(
    "insertNew"=>false,
    "viewPage"=>true,
    "delete"=>false,
    "update"=>false,
);

if ($userTypeId == 1) { // Super admin - see all evaluations
    // No additional filter needed
} elseif($userTypeId == 2){ // Syndicate Users - see all evaluations
    // No additional filter needed
} elseif($userTypeId == 3){ // Hospital User - see evaluations for doctors in same hospital & specialty
    // Filter by hospital user's hospital and specialty
    $userHospitalId = $currentUser["hospitals_id"];
    $userSpecialtyId = $currentUser["specialties_id"];
    
    // Get hospitals_has_specialties_id that matches user's hospital and specialty
    $hospitalSpecialty = hospitals_has_specialties_model::where("hospitals_id", $userHospitalId)
                          ->where("specialties_id", $userSpecialtyId)
                          ->where("is_deleted", 0)
                          ->first();
    
    if ($hospitalSpecialty) {
        $data = $data->where("monthly_evaluations.hospitals_has_specialties_id", "=", $hospitalSpecialty->id);
    } else {
        // No matching hospital-specialty combination, show no records
        $data = $data->where("monthly_evaluations.id", "=", 0);
    }
} elseif($userTypeId == 4){ // Doctor User - see only their own evaluations
    // Filter to show only evaluations for this doctor
    $data = $data->where("monthly_evaluations.users_id", "=", $currentUser["id"]);
}
/****** End User Type Based Filtering ******/ 
  $pagination= env("PAGINATION");
  if (isset($_COOKIE["monthly_evaluations_pagination"])) {
    $pagination = $_COOKIE["monthly_evaluations_pagination"];
  }
  
 $data=$data->paginate($pagination);
 $layout ="table";
  if (isset($_COOKIE["monthly_evaluations"])) { 
    $layout = $_COOKIE["monthly_evaluations"];
  }
 /****** foreign key filters start ******/ 
      $data_users = users_model::where("is_deleted",0)->get(); 
      $data_hospitals_has_specialties = hospitals_has_specialties_model::where("is_deleted",0)->get(); 
 /****** foreign key filters end ******/ 
  
  
  
       $array = array(
                     "records"=>$data,
                     "folderName"=>"evaluations",
                     "table"=>"monthly_evaluations",
                     "permissions"=>$permissions,
                     "lang"=>$lang,
                     "layout"=>$layout,
                     "pagination"=>$pagination,
                     "data_users"=>$data_users,
                     "data_hospitals_has_specialties"=>$data_hospitals_has_specialties,
                    );
    return view("adminDashboard.evaluations.monthly_evaluations.monthly_evaluations" ,$array);
  }
function  monthly_evaluations_delete(Request $request){
  //  proccess 10000008 - delete controller
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
   $permissions = array( "delete"=>true   );
   }else{
   $permissions = array( "delete"=> Permission::CheckPermission(4,"monthly_evaluations")); 
  }
  
  //check if current user has permission
  if($permissions["delete"] == false){
      return response()->json(array("response"=>"no_permission","message"=> __("public.noPermission_to_delete_record"),));
   }
  
 $id=decrypt($request->input("id"));
 $table="monthly_evaluations";
 $id_name = $table . "_id";
 if(Delete::checkRow($id_name,$id)){  // this function to check if this record has been related with another tables
      return response()->json( array("response"=>"not_allow","message"=> __("public.not_allow_to_delete_record"),) );
 }else{
$monthly_evaluations = monthly_evaluations_model::find($id);
$deleted = monthly_evaluations_model::where("id", $id)->update(["is_deleted" => 1]);
    if($deleted){                    
    activity("monthly_evaluations") 
    ->performedOn($monthly_evaluations) 
    ->causedBy(Auth::user()) 
    ->withProperties([ 
      "attributes" => json_encode($monthly_evaluations, JSON_UNESCAPED_UNICODE), 
    ]) 
    ->log("deleted"); 
      return response()->json(  array("response"=>"deleted","message"=> __("public.success_deleted_record"),) );    
                       
  } 
      return response()->json(array("response"=>"error", "message"=> __("public.error_server")));  
  }
}
function  monthly_evaluations_form_add(){
  //  proccess 100000057 -add form
   $lang =app()->getLocale();
   
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
    $permissions = array( "insertNew"=>true   );
   }else{
    $permissions = array( "insertNew"=> Permission::CheckPermission(3,"monthly_evaluations")); 
   }
   
 /****** foreign key filters start ******/ 
      $data_users = users_model::where("is_deleted",0)->get(); 
      $data_hospitals_has_specialties = hospitals_has_specialties_model::where("is_deleted",0)->get(); 
 /****** foreign key filters end ******/ 
   $array = array(
      "folderName"=>"evaluations",
      "table"=>"monthly_evaluations",
      "permissions"=>$permissions,
      "lang"=>$lang,
      "data_users"=>$data_users,
      "data_hospitals_has_specialties"=>$data_hospitals_has_specialties,
   );
       return view("adminDashboard.evaluations.monthly_evaluations.ajax.monthly_evaluations_form_add",$array);
  }
function  monthly_evaluations_insert(Request $request){
  //  proccess 10000004 - confirm insert
   $request->validate(monthly_evaluations_model::rules($request)); 
   $data=array(); 
   $data["users_id"]=  $request->input()["users_id"] ; 
   $data["hospitals_has_specialties_id"]=  $request->input()["hospitals_has_specialties_id"] ; 
$data["created_by"]=Auth::user()->id;
$insert = monthly_evaluations_model::create($data);
if($insert){
  Session::flash("success_update",  __("public.flashMsg_SuccessInsert"));
     return response()->json(["response" => "inserted"]);
 }else{
   return response()->json(["response" => "error"]); 
 }
}
function monthly_evaluations_form_update(Request $request){
  // proccess 100000013 - update form
$id =decrypt($request->input("id"));
$records = monthly_evaluations_model::findOrFail($id);
$lang =app()->getLocale();
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
      $permissions = array("update"=>true );
   }else{
      $permissions = array( "update"=> Permission::CheckPermission(2,"monthly_evaluations") ); 
   }


 /****** foreign key filters start ******/ 
      $data_users = users_model::where("is_deleted",0)->get(); 
      $data_hospitals_has_specialties = hospitals_has_specialties_model::where("is_deleted",0)->get(); 
 /****** foreign key filters end ******/ 

$array = array(
              "folderName"=>"settings",
              "table"=>"employees",
              "records"=>$records ,
              "permissions"=>$permissions,
              "lang"=>$lang,
              "data_users"=>$data_users,
              "data_hospitals_has_specialties"=>$data_hospitals_has_specialties,
);

    return view("adminDashboard.evaluations.monthly_evaluations.ajax.monthly_evaluations_form_update",$array);
}
function  monthly_evaluations_update(Request $request){
  // proccess 1000000266
  $evaluations_monthly_evaluations = monthly_evaluations_model::findOrFail(  decrypt($request->input("id")) );
  $oldData = $evaluations_monthly_evaluations->getOriginal();
  //$request->validate(monthly_evaluations_model::rules());;
  $data = array();
    $data["users_id"]= decrypt($request->input()["users_id"]) ; 
    $data["hospitals_has_specialties_id"]= decrypt($request->input()["hospitals_has_specialties_id"]) ; 
  $data["updated_by"]=Auth::user()["id"];
  $data["updated_at"]=date("Y-m-d H:i:s" );
  $updated = monthly_evaluations_model::where("id","=", decrypt($request->input("id")) )->update($data);
  if($updated){ 
  $newData = $data;
  activity("monthly_evaluations")
  ->performedOn($evaluations_monthly_evaluations)
  ->causedBy(Auth::user())
  ->withProperties([
      "old" => $oldData,
      "attributes" => $newData,
  ])
  ->log("updated");
     Session::flash("success_update",  __("public.flashMsg_SuccessUpdate"));
     return response()->json(array("response"=>"updated"));
   }else{
    return response()->json(array("response"=>"error")); 
   }
}

function monthly_evaluations_info(Request $request){
  // Info popup - view evaluation details
  $id = decrypt($request->input("id"));
  $lang = app()->getLocale();
  
  $record = monthly_evaluations_model::select(
    "monthly_evaluations.id AS id",
    "monthly_evaluations.created_at AS created_at",
    "users.name AS users_id_name",
    "users.email AS users_email",
    "users.phone AS users_phone",
    "hospitals.name AS hospitals_name",
    "specialties.name_$lang AS specialties_name"
  )
  ->join('users', 'monthly_evaluations.users_id', '=', 'users.id')
  ->join('hospitals_has_specialties', 'monthly_evaluations.hospitals_has_specialties_id', '=', 'hospitals_has_specialties.id')
  ->join('hospitals', 'hospitals_has_specialties.hospitals_id', '=', 'hospitals.id')
  ->join('specialties', 'hospitals_has_specialties.specialties_id', '=', 'specialties.id')
  ->where('monthly_evaluations.id', $id)
  ->first();

  // Get existing evaluations for this doctor (monthly_evaluation)
  $evaluations = monthly_evaluations_details_model::select(
    "monthly_evaluations_details.id AS id",
    "monthly_evaluations_details.monthly_evaluation_forms_id AS form_id",
    "monthly_evaluations_details.created_at AS submitted_date",
    "monthly_evaluations_details.created_by AS created_by",
    "monthly_evaluation_forms.name AS form_name",
    "users.name AS assessor_name"
  )
  ->join('monthly_evaluation_forms', 'monthly_evaluations_details.monthly_evaluation_forms_id', '=', 'monthly_evaluation_forms.id')
  ->leftJoin('users', 'monthly_evaluations_details.created_by', '=', 'users.id')
  ->where('monthly_evaluations_details.monthly_evaluations_id', $id)
  ->where('monthly_evaluations_details.is_deleted', 0)
  ->orderBy('monthly_evaluations_details.created_at', 'desc')
  ->get();

  // Get current user ID for edit permission check
  $currentUserId = Auth::user() ? Auth::user()->id : null;

  $array = array(
    "record" => $record,
    "evaluations" => $evaluations,
    "currentUserId" => $currentUserId,
    "lang" => $lang,
  );

  return view("adminDashboard.evaluations.monthly_evaluations.ajax.monthly_evaluations_info", $array);
}

// Get all evaluation forms for dropdown
function get_evaluation_forms(Request $request){
  $forms = monthly_evaluation_forms_model::where('is_deleted', 0)
    ->select('id', 'name')
    ->get();
  
  return response()->json(array(
    "success" => true,
    "forms" => $forms
  ));
}

// Get the form template HTML based on form type and mode (add/edit/view)
function get_evaluation_form_template(Request $request){
  $formIdInput = $request->input("form_id");
  $mode = $request->input("mode", "add"); // add, edit, or view
  
  // Try to decrypt form_id (if encrypted), otherwise use as plain
  try {
    $formId = decrypt($formIdInput);
  } catch (\Exception $e) {
    $formId = $formIdInput;
  }
  
  // Get form name to determine type
  $form = monthly_evaluation_forms_model::find($formId);
  $formName = $form ? strtolower($form->name) : '';
  
  // Determine form type
  $formType = 'cbd'; // default
  if (strpos($formName, 'dops') !== false) {
    $formType = 'dops';
  } elseif (strpos($formName, 'mini-cex') !== false || strpos($formName, 'minicex') !== false || strpos($formName, 'mini cex') !== false) {
    $formType = 'minicex';
  }
  
  // Validate mode
  if (!in_array($mode, ['add', 'edit', 'view'])) {
    $mode = 'add';
  }
  
  // Return the appropriate form template from the mode subfolder
  $viewPath = "adminDashboard.evaluations.monthly_evaluations.ajax.forms.{$mode}.{$formType}_form";
  
  return view($viewPath);
}

// Get evaluation form data with criteria and trainee info
function get_evaluation_form_data(Request $request){
  $formIdInput = $request->input("form_id");
  
  // Try to decrypt form_id (if encrypted), otherwise use as plain
  try {
    $formId = decrypt($formIdInput);
  } catch (\Exception $e) {
    $formId = $formIdInput;
  }
  
  $monthlyEvaluationId = decrypt($request->input("monthly_evaluation_id"));
  $isNewRecord = $request->input("is_new_record", false); // Flag to force new record mode
  $detailsId = $request->input("details_id") ? decrypt($request->input("details_id")) : null; // Specific evaluation ID for viewing
  $lang = app()->getLocale();
  
  // Get form name
  $form = monthly_evaluation_forms_model::find($formId);
  
  // Get trainee (doctor) info from monthly_evaluations
  $trainee = monthly_evaluations_model::select(
    "users.name AS trainee_name",
    "users.email AS trainee_email",
    "users.phone AS trainee_phone",
    "hospitals.name AS hospital_name",
    "specialties.name_$lang AS specialty_name"
  )
  ->join('users', 'monthly_evaluations.users_id', '=', 'users.id')
  ->join('hospitals_has_specialties', 'monthly_evaluations.hospitals_has_specialties_id', '=', 'hospitals_has_specialties.id')
  ->join('hospitals', 'hospitals_has_specialties.hospitals_id', '=', 'hospitals.id')
  ->join('specialties', 'hospitals_has_specialties.specialties_id', '=', 'specialties.id')
  ->where('monthly_evaluations.id', $monthlyEvaluationId)
  ->first();
  
  // Get assessor - if existing evaluation, get from created_by; otherwise current logged in user
  $assessor = Auth::user();
  $assessorName = $assessor ? $assessor->name : '';
  $assessorEmail = $assessor ? $assessor->email : '';
  $assessmentDateValue = date('Y-m-d');
  
  // Load existing data based on context
  $existingDetails = null;
  if ($detailsId) {
    // If details_id is provided, load that specific record (for viewing)
    $existingDetails = monthly_evaluations_details_model::where('id', $detailsId)
      ->where('is_deleted', 0)
      ->first();
  } elseif (!$isNewRecord) {
    // For backward compatibility - search by monthly_evaluation AND form (not used when adding new)
    $existingDetails = monthly_evaluations_details_model::where('monthly_evaluations_id', $monthlyEvaluationId)
      ->where('monthly_evaluation_forms_id', $formId)
      ->where('is_deleted', 0)
      ->first();
  }
  
  // If existing evaluation, get the actual assessor who last saved it
  if ($existingDetails) {
    // If updated_by exists, use that (the person who last updated); otherwise use created_by
    $assessorUserId = $existingDetails->updated_by ? $existingDetails->updated_by : $existingDetails->created_by;
    $originalAssessor = users_model::find($assessorUserId);
    if ($originalAssessor) {
      $assessorName = $originalAssessor->name;
      $assessorEmail = $originalAssessor->email;
    }
    // Use the last save date as assessment date (updated_at if updated, otherwise created_at)
    if ($existingDetails->updated_at && $existingDetails->updated_by) {
      $assessmentDateValue = date('Y-m-d', strtotime($existingDetails->updated_at));
    } elseif ($existingDetails->created_at) {
      $assessmentDateValue = date('Y-m-d', strtotime($existingDetails->created_at));
    }
  }
  
  // Get clinical settings
  $clinicalSettings = DB::table('clinical_setting')
    ->where('is_deleted', 0)
    ->select('id', 'name')
    ->get();
  
  // Get procedure list grouped by category for DOPS form
  $procedureList = DB::table('procedure_list')
    ->join('category_procedure', 'procedure_list.category_procedure_id', '=', 'category_procedure.id')
    ->where('procedure_list.is_deleted', 0)
    ->where('category_procedure.is_deleted', 0)
    ->select('procedure_list.id', 'procedure_list.name as procedure_name', 'category_procedure.name as category_name', 'procedure_list.category_procedure_id')
    ->orderBy('category_procedure.id')
    ->orderBy('procedure_list.name')
    ->get();
  
  // Get assessment criteria for this form
  $assessmentCriteria = DB::table('assessment_criteria')
    ->where('monthly_evaluation_forms_id', $formId)
    ->where('is_deleted', 0)
    ->select('id', 'question')
    ->get();
  
  $existingData = null;
  $existingAnswers = [];
  $existingClinicalSettings = [];
  
  if ($existingDetails) {
    // Look up category name if procedure_list_id exists
    $categoryName = null;
    if ($existingDetails->procedure_list_id) {
      $procedureInfo = DB::table('procedure_list')
        ->join('category_procedure', 'procedure_list.category_procedure_id', '=', 'category_procedure.id')
        ->where('procedure_list.id', $existingDetails->procedure_list_id)
        ->select('category_procedure.name as category_name')
        ->first();
      if ($procedureInfo) {
        $categoryName = $procedureInfo->category_name;
      }
    }
    
    $existingData = [
      'id' => encrypt($existingDetails->id),
      // CBD fields
      'cbd_title' => $existingDetails->cbd_title,
      // Common fields (CBD & DOPS) - using actual DB column names
      'aspects_done_well' => $existingDetails->aspects,
      'suggested_improvement' => $existingDetails->suggested,
      // CBD Time fields
      'time_discussion' => $existingDetails->feedback_discussion,
      'time_feedback' => $existingDetails->feedback,
      // DOPS fields
      'procedure_name' => $existingDetails->procedure_name,
      'procedure_list_id' => $existingDetails->procedure_list_id,
      'procedure_name_other' => $existingDetails->procedure_name_other,
      'category_name' => $categoryName,
      'agreed_action_plan' => $existingDetails->agree_action_plan,
      // DOPS Independent Practice checkboxes
      'unable_perform_procedure' => $existingDetails->unable_perform_procedure,
      'able_perform_procedure' => $existingDetails->able_perform_procedure,
      'trained_and_competent' => $existingDetails->trained_and_competent,
      'able_perform_procedure_limited' => $existingDetails->able_perform_procedure_limited,
      'competent_perform_procedure_unsupervised' => $existingDetails->competent_perform_procedure_unsupervised,
      // Mini-CEX fields
      'clinical_problem' => $existingDetails->clinical_problem,
      'assessor_comments' => $existingDetails->assessor_comments,
      'patient_age' => $existingDetails->patient_age,
      'patient_sex' => $existingDetails->patient_sex,
      // Mini-CEX 7 columns
      'minicex_observing_mins' => $existingDetails->minicex_observing_mins,
      'minicex_feedback_mins' => $existingDetails->minicex_feedback_mins,
      'complexity_low' => $existingDetails->complexity_low,
      'complexity_moderate' => $existingDetails->complexity_moderate,
      'complexity_high' => $existingDetails->complexity_high,
      'not_competent' => $existingDetails->not_competent,
      'competent' => $existingDetails->competent,
    ];
    
    // Get existing answers
    $answers = monthly_evaluations_answers_model::where('monthly_evaluations_details_id', $existingDetails->id)->get();
    foreach ($answers as $answer) {
      $existingAnswers[$answer->assessment_criteria_id] = [
        'n_a' => $answer->n_a,
        'below_standard' => $answer->below_standard,
        'meets_standard' => $answer->meets_standard,
        'above_standard' => $answer->above_standard,
      ];
    }
    
    // Get existing clinical settings
    $clinicals = monthly_evaluations_clinical_model::where('monthly_evaluations_details_id', $existingDetails->id)->get();
    foreach ($clinicals as $clinical) {
      $existingClinicalSettings[] = $clinical->clinical_setting_id;
    }
  }
  
  // Check if current user can edit (only the creator can edit)
  $currentUserId = Auth::user() ? Auth::user()->id : null;
  $canEdit = true; // Default: can edit (for new forms)
  if ($existingDetails) {
    // Only the original creator can edit
    $canEdit = ($existingDetails->created_by == $currentUserId);
  }
  
  return response()->json(array(
    "success" => true,
    "form_id" => $formId,
    "form_name" => $form ? $form->name : '',
    "trainee_name" => $trainee ? $trainee->trainee_name : '',
    "trainee_specialty" => $trainee ? $trainee->specialty_name : '',
    "hospital_name" => $trainee ? $trainee->hospital_name : '',
    "assessor_name" => $assessorName,
    "assessor_email" => $assessorEmail,
    "assessment_date" => $assessmentDateValue,
    "clinical_settings" => $clinicalSettings,
    "procedure_list" => $procedureList,
    "assessment_criteria" => $assessmentCriteria,
    "existing_data" => $existingData,
    "existing_answers" => $existingAnswers,
    "existing_clinical_settings" => $existingClinicalSettings,
    "can_edit" => $canEdit,
  ));
}

// Save or Update evaluation form
function save_evaluation_form(Request $request){
  try {
    $monthlyEvaluationId = decrypt($request->input("monthly_evaluation_id"));
    $formIdInput = $request->input("form_id");
    
    // Try to decrypt form_id (if encrypted), otherwise use as plain
    try {
      $formId = decrypt($formIdInput);
    } catch (\Exception $e) {
      $formId = $formIdInput;
    }
    
    // Try to decrypt details_id (if provided and encrypted)
    $detailsIdInput = $request->input("details_id");
    $detailsId = null;
    if ($detailsIdInput && $detailsIdInput !== '' && $detailsIdInput !== 'null') {
      try {
        $detailsId = decrypt($detailsIdInput);
      } catch (\Exception $e) {
        // If decryption fails, try using it as plain ID
        if (is_numeric($detailsIdInput)) {
          $detailsId = $detailsIdInput;
        }
      }
    }
    
    $formType = $request->input("form_type", "cbd");
    
    $userId = Auth::user()["id"];
    
    DB::beginTransaction();
    
    // Check if updating or inserting
    if ($detailsId) {
      // UPDATE existing record
      $details = monthly_evaluations_details_model::find($detailsId);
      if (!$details) {
        throw new \Exception("Record not found");
      }
      
      // Security check: Only the original creator can update
      if ($details->created_by != $userId) {
        throw new \Exception("You are not authorized to update this evaluation. Only the original assessor can edit.");
      }
      
      // CBD-specific fields
      if ($formType === 'cbd') {
        $details->cbd_title = $request->input("cbd_title");
        $details->aspects = $request->input("aspects_done_well");
        $details->suggested = $request->input("suggested_improvement");
        $details->feedback_discussion = $request->input("time_discussion");
        $details->feedback = $request->input("time_feedback");
      }
      
      // DOPS-specific fields
      if ($formType === 'dops') {
        $procedureListId = $request->input("procedure_list_id");
        $details->procedure_list_id = $procedureListId && $procedureListId !== 'other' ? $procedureListId : null;
        $details->procedure_name_other = $procedureListId === 'other' ? $request->input("procedure_name_other") : null;
        // Keep procedure_name for backward compatibility
        if ($procedureListId && $procedureListId !== 'other') {
          $procedure = DB::table('procedure_list')->where('id', $procedureListId)->first();
          $details->procedure_name = $procedure ? $procedure->name : '';
        } else {
          $details->procedure_name = $request->input("procedure_name_other");
        }
        $details->aspects = $request->input("aspects_done_well");
        $details->suggested = $request->input("suggested_improvement");
        $details->agree_action_plan = $request->input("agreed_action_plan");
        // Independent practice checkboxes
        $details->unable_perform_procedure = $request->input("unable_perform_procedure");
        $details->able_perform_procedure = $request->input("able_perform_procedure");
        $details->trained_and_competent = $request->input("trained_and_competent");
        $details->able_perform_procedure_limited = $request->input("able_perform_procedure_limited");
        $details->competent_perform_procedure_unsupervised = $request->input("competent_perform_procedure_unsupervised");
      }
      
      // Mini-CEX-specific fields
      if ($formType === 'minicex') {
        $details->clinical_problem = $request->input("clinical_problem");
        $details->assessor_comments = $request->input("assessor_comments");
        $details->patient_age = $request->input("patient_age");
        $details->patient_sex = $request->input("patient_sex");
        $details->minicex_observing_mins = $request->input("minicex_observing_mins");
        $details->minicex_feedback_mins = $request->input("minicex_feedback_mins");
        $details->complexity_low = $request->input("complexity_low");
        $details->complexity_moderate = $request->input("complexity_moderate");
        $details->complexity_high = $request->input("complexity_high");
        $details->not_competent = $request->input("not_competent");
        $details->competent = $request->input("competent");
      }
      
      $details->updated_by = $userId;
      $details->updated_at = date("Y-m-d H:i:s");
      $details->save();
      
    } else {
      // INSERT new record
      $details = new monthly_evaluations_details_model();
      $details->monthly_evaluations_id = $monthlyEvaluationId;
      $details->monthly_evaluation_forms_id = $formId;
      
      // CBD-specific fields
      if ($formType === 'cbd') {
        $details->cbd_title = $request->input("cbd_title");
        $details->aspects = $request->input("aspects_done_well");
        $details->suggested = $request->input("suggested_improvement");
        $details->feedback_discussion = $request->input("time_discussion");
        $details->feedback = $request->input("time_feedback");
      }
      
      // DOPS-specific fields
      if ($formType === 'dops') {
        $procedureListId = $request->input("procedure_list_id");
        $details->procedure_list_id = $procedureListId && $procedureListId !== 'other' ? $procedureListId : null;
        $details->procedure_name_other = $procedureListId === 'other' ? $request->input("procedure_name_other") : null;
        // Keep procedure_name for backward compatibility
        if ($procedureListId && $procedureListId !== 'other') {
          $procedure = DB::table('procedure_list')->where('id', $procedureListId)->first();
          $details->procedure_name = $procedure ? $procedure->name : '';
        } else {
          $details->procedure_name = $request->input("procedure_name_other");
        }
        $details->aspects = $request->input("aspects_done_well");
        $details->suggested = $request->input("suggested_improvement");
        $details->agree_action_plan = $request->input("agreed_action_plan");
        // Independent practice checkboxes
        $details->unable_perform_procedure = $request->input("unable_perform_procedure");
        $details->able_perform_procedure = $request->input("able_perform_procedure");
        $details->trained_and_competent = $request->input("trained_and_competent");
        $details->able_perform_procedure_limited = $request->input("able_perform_procedure_limited");
        $details->competent_perform_procedure_unsupervised = $request->input("competent_perform_procedure_unsupervised");
      }
      
      // Mini-CEX-specific fields
      if ($formType === 'minicex') {
        $details->clinical_problem = $request->input("clinical_problem");
        $details->assessor_comments = $request->input("assessor_comments");
        $details->patient_age = $request->input("patient_age");
        $details->patient_sex = $request->input("patient_sex");
        $details->minicex_observing_mins = $request->input("minicex_observing_mins");
        $details->minicex_feedback_mins = $request->input("minicex_feedback_mins");
        $details->complexity_low = $request->input("complexity_low");
        $details->complexity_moderate = $request->input("complexity_moderate");
        $details->complexity_high = $request->input("complexity_high");
        $details->not_competent = $request->input("not_competent");
        $details->competent = $request->input("competent");
      }
      
      $details->created_by = $userId;
      $details->created_at = date("Y-m-d H:i:s");
      $details->save();
      
      $detailsId = $details->id;
    }
    
    // Save/Update answers (assessment criteria responses)
    $answers = $request->input("answers", []);
    foreach ($answers as $criteriaId => $answer) {
      // Check if answer already exists
      $existingAnswer = monthly_evaluations_answers_model::where('monthly_evaluations_details_id', $detailsId)
        ->where('assessment_criteria_id', $criteriaId)
        ->first();
      
      if ($existingAnswer) {
        // UPDATE existing record
        $existingAnswer->n_a = isset($answer['n_a']) ? $answer['n_a'] : null;
        $existingAnswer->below_standard = isset($answer['below_standard']) ? $answer['below_standard'] : null;
        $existingAnswer->meets_standard = isset($answer['meets_standard']) ? $answer['meets_standard'] : null;
        $existingAnswer->above_standard = isset($answer['above_standard']) ? $answer['above_standard'] : null;
        $existingAnswer->save();
      } else {
        // INSERT new record
        $answerRecord = new monthly_evaluations_answers_model();
        $answerRecord->monthly_evaluations_details_id = $detailsId;
        $answerRecord->assessment_criteria_id = $criteriaId;
        $answerRecord->n_a = isset($answer['n_a']) ? $answer['n_a'] : null;
        $answerRecord->below_standard = isset($answer['below_standard']) ? $answer['below_standard'] : null;
        $answerRecord->meets_standard = isset($answer['meets_standard']) ? $answer['meets_standard'] : null;
        $answerRecord->above_standard = isset($answer['above_standard']) ? $answer['above_standard'] : null;
        $answerRecord->save();
      }
    }
    
    // Save/Update clinical settings
    $clinicalSettings = $request->input("clinical_settings", []);
    
    // Get existing clinical setting IDs for this details record
    $existingClinicalIds = monthly_evaluations_clinical_model::where('monthly_evaluations_details_id', $detailsId)
      ->pluck('clinical_setting_id')
      ->toArray();
    
    // Add new clinical settings (ones that don't exist yet)
    foreach ($clinicalSettings as $clinicalSettingId) {
      if (!in_array($clinicalSettingId, $existingClinicalIds)) {
        $clinicalRecord = new monthly_evaluations_clinical_model();
        $clinicalRecord->monthly_evaluations_details_id = $detailsId;
        $clinicalRecord->clinical_setting_id = $clinicalSettingId;
        $clinicalRecord->save();
      }
    }
    
    // Remove unchecked clinical settings (ones that exist but are not in the new list)
    foreach ($existingClinicalIds as $existingId) {
      if (!in_array($existingId, $clinicalSettings)) {
        monthly_evaluations_clinical_model::where('monthly_evaluations_details_id', $detailsId)
          ->where('clinical_setting_id', $existingId)
          ->delete();
      }
    }
    
    DB::commit();
    
    return response()->json(array(
      "success" => true,
      "message" => "Evaluation saved successfully",
      "details_id" => encrypt($detailsId)
    ));
    
  } catch (\Exception $e) {
    DB::rollBack();
    return response()->json(array(
      "success" => false,
      "message" => "Error saving evaluation: " . $e->getMessage()
    ));
  }
}

// Print Evaluation Form as PDF
function print_evaluation_pdf(Request $request) {
  try {
    $detailsIdInput = $request->input("details_id");
    $formIdInput = $request->input("form_id");
    
    // Try to decrypt details_id (if encrypted), otherwise use as plain
    try {
      $detailsId = decrypt($detailsIdInput);
    } catch (\Exception $e) {
      $detailsId = $detailsIdInput;
    }
    
    // Try to decrypt form_id (if encrypted), otherwise use as plain
    try {
      $formId = decrypt($formIdInput);
    } catch (\Exception $e) {
      $formId = $formIdInput;
    }
    
    // Get evaluation details
    $details = monthly_evaluations_details_model::find($detailsId);
    if (!$details) {
      return "Record not found";
    }
    
    // Get monthly evaluation record
    $monthlyEvaluation = monthly_evaluations_model::find($details->monthly_evaluations_id);
    if (!$monthlyEvaluation) {
      return "Monthly evaluation not found";
    }
    
    // Get form info
    $form = monthly_evaluation_forms_model::find($formId);
    $formName = $form ? $form->name : 'Evaluation Form';
    
    // Determine form type
    $formType = 'cbd';
    $formNameLower = strtolower($formName);
    if (strpos($formNameLower, 'dops') !== false) {
      $formType = 'dops';
    } elseif (strpos($formNameLower, 'mini-cex') !== false || strpos($formNameLower, 'minicex') !== false || strpos($formNameLower, 'mini cex') !== false) {
      $formType = 'minicex';
    }
    
    // Get trainee info (users_id is the trainee)
    $trainee = users_model::find($monthlyEvaluation->users_id);
    $traineeName = $trainee ? $trainee->name : '';
    $traineeIma = $trainee ? ($trainee->ima_number ?? '') : '';
    
    // Get assessor info - use updated_by if exists, otherwise created_by
    $assessorUserId = $details->updated_by ? $details->updated_by : $details->created_by;
    $assessor = users_model::find($assessorUserId);
    $assessorName = $assessor ? $assessor->name : '';
    $assessorEmail = $assessor ? $assessor->email : '';
    $assessorPhone = $assessor ? ($assessor->phone ?? '') : '';
    
    // Get hospital/specialty info
    $hospitalHasSpecialty = hospitals_has_specialties_model::where('id', $monthlyEvaluation->hospitals_has_specialties_id)->first();
    $hospitalName = '';
    $traineeSpecialty = '';
    if ($hospitalHasSpecialty) {
      $hospital = DB::table('hospitals')->where('id', $hospitalHasSpecialty->hospitals_id)->first();
      $specialty = DB::table('specialties')->where('id', $hospitalHasSpecialty->specialties_id)->first();
      $hospitalName = $hospital ? $hospital->name : '';
      $traineeSpecialty = $specialty ? ($specialty->name_en ?? $specialty->name ?? '') : '';
    }
    
    // Assessment date - use updated_at if updated, otherwise created_at
    if ($details->updated_at && $details->updated_by) {
      $assessmentDate = date('Y-m-d', strtotime($details->updated_at));
    } else {
      $assessmentDate = $details->created_at ? date('Y-m-d', strtotime($details->created_at)) : '';
    }
    
    // Get assessment criteria with answers
    $assessmentCriteria = DB::table('assessment_criteria')
      ->where('monthly_evaluation_forms_id', $formId)
      ->where('is_deleted', 0)
      ->get();
    
    // Get answers
    $answers = monthly_evaluations_answers_model::where('monthly_evaluations_details_id', $detailsId)->get();
    $answersMap = [];
    foreach ($answers as $answer) {
      $answersMap[$answer->assessment_criteria_id] = $answer;
    }
    
    // Get clinical settings
    $clinicalSettingsData = monthly_evaluations_clinical_model::where('monthly_evaluations_details_id', $detailsId)->get();
    $clinicalSettings = [];
    foreach ($clinicalSettingsData as $cs) {
      $setting = DB::table('clinical_setting')->where('id', $cs->clinical_setting_id)->first();
      if ($setting) {
        $clinicalSettings[] = $setting->name;
      }
    }
    
    // Look up category name for DOPS form if procedure_list_id exists
    $categoryName = '';
    if ($details->procedure_list_id) {
      $procedureInfo = DB::table('procedure_list')
        ->join('category_procedure', 'procedure_list.category_procedure_id', '=', 'category_procedure.id')
        ->where('procedure_list.id', $details->procedure_list_id)
        ->select('category_procedure.name as category_name')
        ->first();
      if ($procedureInfo) {
        $categoryName = $procedureInfo->category_name;
      }
    }
    
    // Build HTML for PDF
    $html = $this->buildPdfHtml($formName, $formType, $details, $traineeName, $assessorName, $assessorEmail, $hospitalName, $traineeSpecialty, $assessmentDate, $assessmentCriteria, $answersMap, $clinicalSettings, $assessorPhone, $traineeIma, $categoryName);
    
    // Generate PDF using MPDF
    $mpdf = new \Mpdf\Mpdf([
      'mode' => 'utf-8',
      'format' => 'A4',
      'margin_left' => 10,
      'margin_right' => 10,
      'margin_top' => 10,
      'margin_bottom' => 10,
    ]);
    
    $mpdf->WriteHTML($html);
    
    // Output PDF
    return $mpdf->Output($formName . '.pdf', 'I'); // 'I' = inline (view in browser)
    
  } catch (\Exception $e) {
    return "Error generating PDF: " . $e->getMessage();
  }
}

// Build HTML for PDF
private function buildPdfHtml($formName, $formType, $details, $traineeName, $assessorName, $assessorEmail, $hospitalName, $traineeSpecialty, $assessmentDate, $assessmentCriteria, $answersMap, $clinicalSettings, $assessorPhone = '', $traineeIma = '', $categoryName = '') {
  $clinicalSettingsStr = implode(', ', $clinicalSettings);
  
  $html = '
  <style>
    body { font-family: Arial, sans-serif; font-size: 11px; line-height: 1.4; }
    .header { background-color: #6f42c1; color: white; padding: 15px; text-align: center; margin-bottom: 15px; }
    .header h1 { margin: 0; font-size: 18px; }
    .header h2 { margin: 5px 0 0 0; font-size: 14px; }
    .header h3 { margin: 5px 0 0 0; font-size: 12px; }
    .info-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
    .info-table td { padding: 8px 10px; border: 1px solid #ddd; vertical-align: top; }
    .info-table .label { font-weight: bold; width: 200px; background-color: #f8f9fa; }
    .criteria-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
    .criteria-table th { background-color: #6f42c1; color: white; padding: 8px; text-align: center; font-size: 10px; }
    .criteria-table td { padding: 8px; border: 1px solid #ddd; }
    .criteria-table .question { text-align: left; }
    .criteria-table .answer { text-align: center; width: 70px; }
    .radio-circle { font-size: 16px; color: #007bff; }
    .radio-empty { font-size: 16px; color: #ccc; }
    .section-title { background-color: #f0f0f0; padding: 10px; font-weight: bold; margin: 15px 0 10px 0; border: 1px solid #ddd; }
    .text-section { margin-bottom: 15px; }
    .text-section label { font-weight: bold; font-size: 12px; display: block; margin-bottom: 8px; }
    .text-section .hint { font-size: 10px; color: #6c757d; margin-bottom: 5px; font-weight: normal; }
    .text-section .text-box { border: 1px solid #ddd; padding: 10px; min-height: 50px; background-color: #fff; }
    .checkbox-item { margin: 8px 0; padding: 5px 0; }
    .checkbox-checked { color: #28a745; font-weight: bold; }
    .signature-section { margin-top: 30px; }
    .signature-table { width: 100%; border-collapse: collapse; }
    .signature-table th { background-color: #f8f9fa; padding: 10px; border: 1px solid #ddd; font-weight: bold; }
    .signature-table td { padding: 10px; border: 1px solid #ddd; height: 60px; vertical-align: bottom; }
    .instructions { background-color: #f8f9fa; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; font-size: 10px; }
    .complexity-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
    .complexity-table td { padding: 10px; border: 1px solid #ddd; }
    .complexity-header { font-weight: bold; background-color: #f8f9fa; width: 100px; }
    .competency-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
    .competency-table th { padding: 10px; border: 1px solid #ddd; background-color: #f8f9fa; width: 50%; text-align: center; }
    .competency-table td { padding: 10px; border: 1px solid #ddd; text-align: center; }
    .global-rating { background-color: #f8f9fa; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; }
    .minicex-info { background-color: #f8f9fa; padding: 15px; margin-top: 20px; border: 1px solid #ddd; font-size: 10px; color: #000; }
    .minicex-info h4 { margin-top: 0; color: #000; font-weight: bold; }
    .criteria-name { color: #000; font-weight: bold; }
    .independent-practice { padding: 10px; border: 1px solid #ddd; background-color: #fff; }
    .independent-practice-section { page-break-inside: avoid; }
    .feedback-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
    .feedback-table td { padding: 10px; border: 1px solid #ddd; }
    .feedback-label { width: 200px; font-weight: bold; background-color: #e7f3ff; color: #000; }
  </style>
  
  <div class="header">
    <h1>' . htmlspecialchars($formName) . '</h1>
    <h2>Workplace – Based Assessment</h2>
    <h3>IMIP</h3>
  </div>
  
  <!-- Common Info Table -->
  <table class="info-table">
    <tr><td class="label">Trainee\'s Name:</td><td>' . htmlspecialchars($traineeName) . '</td></tr>
    <tr><td class="label">Trainee\'s IMA Number:</td><td>' . htmlspecialchars($traineeIma) . '</td></tr>
    <tr><td class="label">Date of Assessment:</td><td>' . htmlspecialchars($assessmentDate) . '</td></tr>
    <tr><td class="label">Trainee\'s ROTA:</td><td>' . htmlspecialchars($traineeSpecialty) . '</td></tr>
    <tr><td class="label">Assessor\'s Name:</td><td>' . htmlspecialchars($assessorName) . '</td></tr>
    <tr><td class="label">Assessor\'s Email Address:</td><td>' . htmlspecialchars($assessorEmail) . '</td></tr>
    <tr><td class="label">Assessor\'s Number:</td><td></td></tr>
    <tr><td class="label">Hospital Name:</td><td>' . htmlspecialchars($hospitalName) . '</td></tr>
    <tr><td class="label">Clinical Setting:</td><td>' . htmlspecialchars($clinicalSettingsStr) . '</td></tr>';
  
  // Form-specific header fields
  if ($formType === 'cbd') {
    $html .= '<tr><td class="label" style="color: #dc3545; font-weight: bold;">CBD Title:</td><td>' . htmlspecialchars($details->cbd_title ?? '') . '</td></tr>';
  } elseif ($formType === 'dops') {
    // Display "Category Name | Procedure Name" or "Other Procedure Name (Other)" for DOPS
    $procedureDisplayValue = '';
    if ($details->procedure_list_id && $categoryName) {
      $procedureDisplayValue = $categoryName . ' | ' . ($details->procedure_name ?? '');
    } elseif ($details->procedure_name_other) {
      $procedureDisplayValue = $details->procedure_name_other . ' (Other)';
    } else {
      $procedureDisplayValue = $details->procedure_name ?? '';
    }
    $html .= '<tr><td class="label" style="color: #dc3545; font-weight: bold;">Procedure Name:</td><td>' . htmlspecialchars($procedureDisplayValue) . '</td></tr>';
  } elseif ($formType === 'minicex') {
    // Patient Data for Mini-CEX
    $patientAge = $details->patient_age ?? '';
    $patientSex = $details->patient_sex ?? '';
    $html .= '<tr><td class="label">Patient Data:</td><td>Age: ' . htmlspecialchars($patientAge) . ' &nbsp;&nbsp; Sex: ' . htmlspecialchars($patientSex) . '</td></tr>';
    $html .= '<tr><td class="label" style="color: #dc3545; font-weight: bold;">Clinical Problem:</td><td>' . htmlspecialchars($details->clinical_problem ?? '') . '</td></tr>';
  }
  
  $html .= '</table>';
  
  // Instructions
  $html .= '
  <div class="instructions">
    <strong>Please score the trainee on the scale shown.</strong> Please note that your scoring should reflect the performance of the trainee against which you would reasonably expect at their stage of training and level of experience. Please mark \'Not applicable\' if the domain is not applicable: <strong>Assessment Criteria:</strong> (this is the Likert scale grading – put X in relevant box)
  </div>';
  
  // Assessment Criteria Table
  $html .= '
  <table class="criteria-table">
    <tr>
      <th style="text-align: left; width: auto;">Assessment Criteria</th>
      <th>N/A</th>
      <th>Below standard</th>
      <th>Meets standard</th>
      <th>Above standard</th>
    </tr>';
  
  foreach ($assessmentCriteria as $criteria) {
    $answer = isset($answersMap[$criteria->id]) ? $answersMap[$criteria->id] : null;
    $naChecked = ($answer && $answer->n_a == 1) ? '<span class="radio-circle">●</span>' : '<span class="radio-empty">○</span>';
    $belowChecked = ($answer && $answer->below_standard == 1) ? '<span class="radio-circle">●</span>' : '<span class="radio-empty">○</span>';
    $meetsChecked = ($answer && $answer->meets_standard == 1) ? '<span class="radio-circle">●</span>' : '<span class="radio-empty">○</span>';
    $aboveChecked = ($answer && $answer->above_standard == 1) ? '<span class="radio-circle">●</span>' : '<span class="radio-empty">○</span>';
    
    $boldStyle = (isset($criteria->is_bold) && $criteria->is_bold) ? 'font-weight: bold;' : '';
    
    $html .= '
    <tr>
      <td class="question" style="' . $boldStyle . '">' . htmlspecialchars($criteria->question) . '</td>
      <td class="answer">' . $naChecked . '</td>
      <td class="answer">' . $belowChecked . '</td>
      <td class="answer">' . $meetsChecked . '</td>
      <td class="answer">' . $aboveChecked . '</td>
    </tr>';
  }
  
  $html .= '</table>';
  
  // =============================================
  // DOPS SPECIFIC: Independent Practice Rating
  // =============================================
  if ($formType === 'dops') {
    $html .= '
    <div class="independent-practice-section">
      <div class="instructions">
        <strong>Based on this observation please now rate the level of independent practice the trainee has shown for this procedure:</strong>
      </div>
      <div class="independent-practice">';
    
    $checkboxes = [
      ['field' => 'unable_perform_procedure', 'label' => 'Unable to perform procedure'],
      ['field' => 'able_perform_procedure', 'label' => 'Able to perform the procedure under direct supervision/assistance'],
      ['field' => 'trained_and_competent', 'label' => 'Trained and competent in skills lab (this does not equate to clinical competence)'],
      ['field' => 'able_perform_procedure_limited', 'label' => 'Able to perform the procedure with limited supervision/assistance'],
      ['field' => 'competent_perform_procedure_unsupervised', 'label' => 'Competent to perform the procedure unsupervised and deal with complications'],
    ];
    
    foreach ($checkboxes as $cb) {
      $isChecked = isset($details->{$cb['field']}) && $details->{$cb['field']} == 1;
      $checkmark = $isChecked ? '☑' : '☐';
      $class = $isChecked ? 'checkbox-checked' : '';
      $html .= '<div class="checkbox-item ' . $class . '">' . $checkmark . ' ' . htmlspecialchars($cb['label']) . '</div>';
    }
    
    $html .= '</div>
    </div>';
  }
  
  // =============================================
  // MINI-CEX SPECIFIC: Time, Complexity, Global Rating
  // =============================================
  if ($formType === 'minicex') {
    // Time section
    $html .= '
    <table class="info-table" style="margin-top: 15px;">
      <tr>
        <td class="label">Mini-CEX time - Observing:</td>
        <td>' . htmlspecialchars($details->minicex_observing_mins ?? '') . ' Mins</td>
        <td class="label">Providing Feedback:</td>
        <td>' . htmlspecialchars($details->minicex_feedback_mins ?? '') . ' Mins</td>
      </tr>
    </table>';
    
    // Complexity
    $lowChecked = (isset($details->complexity_low) && $details->complexity_low == 1) ? '●' : '○';
    $modChecked = (isset($details->complexity_moderate) && $details->complexity_moderate == 1) ? '●' : '○';
    $highChecked = (isset($details->complexity_high) && $details->complexity_high == 1) ? '●' : '○';
    
    $html .= '
    <table class="complexity-table">
      <tr>
        <td class="complexity-header">Complexity</td>
        <td>' . $lowChecked . ' Low</td>
        <td>' . $modChecked . ' Moderate</td>
        <td>' . $highChecked . ' High</td>
      </tr>
    </table>';
    
    // Global Rating
    $notCompetentChecked = (isset($details->not_competent) && $details->not_competent == 1) ? '●' : '○';
    $competentChecked = (isset($details->competent) && $details->competent == 1) ? '●' : '○';
    
    $html .= '
    <div style="page-break-inside: avoid;">
      <div class="global-rating">
        <strong>Global rating</strong> An overall rating of this doctor\'s performance and professionalism in all areas. The global rating is not an algorithmic calculation of the candidate assessment criteria ratings but a judgement about the overall performance of the candidate.
      </div>
      <table class="competency-table">
        <tr>
          <th>Not-Competent</th>
          <th>Competent</th>
        </tr>
        <tr>
          <td>' . $notCompetentChecked . '</td>
          <td>' . $competentChecked . '</td>
        </tr>
      </table>
    </div>';
    
    // Assessor Comments
    $html .= '
    <div class="text-section">
      <label>Comments of assessor:</label>
      <p class="hint">Please describe what was effective, what could be improved and your overall impression. If required, please specify suggested actions for improvement and a timeline.</p>
      <div class="text-box">' . nl2br(htmlspecialchars($details->assessor_comments ?? '')) . '</div>
    </div>';
  }
  
  // =============================================
  // CBD SPECIFIC: Feedback Section (Before Signatures)
  // =============================================
  if ($formType === 'cbd') {
    $html .= '
    <div class="section-title">Feedback</div>
    <table class="feedback-table">
      <tr>
        <td class="feedback-label">Time taken for discussion:</td>
        <td>' . htmlspecialchars($details->feedback_discussion ?? '') . '</td>
      </tr>
      <tr>
        <td class="feedback-label">Time taken for feedback:</td>
        <td>' . htmlspecialchars($details->feedback ?? '') . '</td>
      </tr>
    </table>
    
    <div class="text-section">
      <label>Which aspects of the encounter were done well?</label>
      <div class="text-box">' . nl2br(htmlspecialchars($details->aspects ?? '')) . '</div>
    </div>
    
    <div class="text-section">
      <label>Suggested areas for improvement:</label>
      <p class="hint">If a trainee receives a rating which is unsatisfactory, the assessor must complete this section.</p>
      <div class="text-box">' . nl2br(htmlspecialchars($details->suggested ?? '')) . '</div>
    </div>';
  }
  
  // =============================================
  // SIGNATURES SECTION (All Forms)
  // =============================================
  $html .= '
  <div class="signature-section">
    <table class="signature-table">
      <tr>
        <th>Assessor\'s Signature</th>
        <th>Trainee\'s Signature</th>
      </tr>
      <tr>
        <td></td>
        <td></td>
      </tr>
    </table>
  </div>';
  
  // =============================================
  // DOPS SPECIFIC: Feedback After Signatures
  // =============================================
  if ($formType === 'dops') {
    $html .= '
    <div class="text-section" style="margin-top: 20px;">
      <label>Which aspects of the encounter were done well?</label>
      <div class="text-box">' . nl2br(htmlspecialchars($details->aspects ?? '')) . '</div>
    </div>
    
    <div class="text-section">
      <label>Suggested areas for improvement:</label>
      <p class="hint">If a trainee receives a rating which is unsatisfactory, the assessor must complete this section.</p>
      <div class="text-box">' . nl2br(htmlspecialchars($details->suggested ?? '')) . '</div>
    </div>
    
    <div class="text-section">
      <label>Agreed action plan:</label>
      <div class="text-box">' . nl2br(htmlspecialchars($details->agree_action_plan ?? '')) . '</div>
    </div>';
  }
  
  // =============================================
  // MINI-CEX SPECIFIC: Description Section After Signatures
  // =============================================
  if ($formType === 'minicex') {
    $html .= '
    <div class="minicex-info">
      <h4>The Mini-Clinical Evaluation Exercise (Mini-CEX)</h4>
      <p>is a 10- to 20-minute, workplace-based assessment tool where a faculty member observes a trainee-patient interaction to provide immediate, constructive feedback. It evaluates key clinical skills like history-taking, physical exam, and professionalism.</p>
      
      <p>The mini-clinical evaluation exercise is the process of directly observing a doctor in a focused patient encounter for the purposes of assessment. It entails observing a candidate perform a focused task with a real patient such as taking a history, examining or counselling a patient. The assessor records judgments of the candidate\'s performance on a rating form and conducts a feedback session on the candidate\'s performance.</p>
      
      <h4>Descriptors of criteria assessed during Mini-CEX</h4>
      
      <p><strong class="criteria-name">Medical Interviewing and Communication Skills</strong><br>
      Facilitates patient\'s telling of story and explores the patient\'s problem(s) using plain English.<br>
      Effectively listens and uses questions/directions to obtain accurate/adequate information needed<br>
      Responds appropriately to affect non-verbal cues, establishes rapport.</p>
      
      <p><strong class="criteria-name">Professional/humanistic skills</strong><br>
      Is aware of safety issues; washes hands; maintains a professional approach to patient; demonstrates an understanding of the role of teams in patient care; attends to the patient\'s needs of comfort and any disabilities; and is respectful of colleagues Is open honest, empathetic and compassionate.</p>
      
      <p><strong class="criteria-name">Organisation/efficiency</strong><br>
      Makes efficient use of time and resources; is practised and well-organised.</p>
      
      <p><strong class="criteria-name">History taking skills</strong><br>
      Uses questions effectively to obtain an accurate, adequate history with necessary information; clearly identifies presenting problem and other active problems; identifies relevant features of past, social and family history.</p>
      
      <p><strong class="criteria-name">Physical examination skills</strong><br>
      Follows an efficient and logical sequence; performs an accurate and relevant clinical examination; explains process to patient; correctly interprets any significant abnormal clinical signs.</p>
      
      <p><strong class="criteria-name">Counselling, education and management skills</strong><br>
      Demonstrates an understanding of different cultural beliefs, values and priorities regarding their health and health care provision, and communicates effectively; manages informed consent; appropriate level of information provided; ability to use available educational resources; provides accurate information according to best practice guidelines; recommends sources of quality information.</p>
      
      <p><strong class="criteria-name">Clinical judgement/clinical reasoning</strong><br>
      Integrates and interprets findings from the history and/or examination to arrive at an initial assessment, including a relevant differential diagnosis; interprets clinical information accurately; and counselling takes account of the patient\'s socio-economic and psychosocial circumstances. Considers patient safety as a priority</p>
      
      <p><strong class="criteria-name">Global rating:</strong><br>
      <strong>An overall judgement of performance at the expected level at the end of IMIP.</strong></p>
    </div>';
  }
  
  return $html;
}
         
         
         
 /****************End Table (monthly_evaluations) Functionality******************/
         
         
         
  
  
 }
