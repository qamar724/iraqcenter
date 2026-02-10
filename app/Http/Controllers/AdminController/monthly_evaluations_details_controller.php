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
use App\Models\Admin\monthly_evaluations_details_model;
use App\Models\Admin\monthly_evaluations_model;
use App\Models\Admin\assessment_criteria_model;
use App\Http\Controllers\AdminController\UserAuthController;
class monthly_evaluations_details_controller extends Controller
{
 /*  
  This controller has been generated Automatically by generatesystems.com  
  */ 
/**************Start Table (monthly_evaluations_details) Functionality **************/
function index(Request $request)
  {
  //  proccess 100000075
  $lang =app()->getLocale();   
  $host = request()->getHttpHost();   
  $hostUrl = "https://".$host."/uploads/documents/";  
  $data = monthly_evaluations_details_model::select(    
                  "monthly_evaluations_details.id   AS  id",
                  "monthly_evaluations.id    AS  monthly_evaluations_id_id",
                  "monthly_evaluations_details.monthly_evaluations_id   AS  monthly_evaluations_id",
                  "assessment_criteria.question    AS  assessment_criteria_id_question",
                  "monthly_evaluations_details.assessment_criteria_id   AS  assessment_criteria_id",
                  "monthly_evaluations_details.n_a   AS  n_a",
                  "monthly_evaluations_details.below_standard   AS  below_standard",
                  "monthly_evaluations_details.meets_standard   AS  meets_standard",
                  "monthly_evaluations_details.above_standard   AS  above_standard",
                  "monthly_evaluations_details.feedback_discussion   AS  feedback_discussion",
                  "monthly_evaluations_details.feedback   AS  feedback",
                  "monthly_evaluations_details.aspects   AS  aspects",
                  "monthly_evaluations_details.suggested   AS  suggested",
                  "monthly_evaluations_details.able_perform_procedure   AS  able_perform_procedure",
                  "monthly_evaluations_details.unable_perform_procedure   AS  unable_perform_procedure",
                  "monthly_evaluations_details.trained_and_competent   AS  trained_and_competent",
                  "monthly_evaluations_details.able_perform_procedure_limited   AS  able_perform_procedure_limited",
                  "monthly_evaluations_details.competent_perform_procedure_unsupervised   AS  competent_perform_procedure_unsupervised",
                  "monthly_evaluations_details.agree_action_plan   AS  agree_action_plan"
                   )
                 ->join ( 'monthly_evaluations as monthly_evaluations' ,'monthly_evaluations_details.monthly_evaluations_id', '=', 'monthly_evaluations.id'  )
                 ->join ( 'assessment_criteria as assessment_criteria' ,'monthly_evaluations_details.assessment_criteria_id', '=', 'assessment_criteria.id'  )
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
                    $data=$data->where("monthly_evaluations_details.$exp_key", "=", $value) ;
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
                    $data=$data->where("monthly_evaluations_details.$exp_key", ">=", $value) ; 
                  }elseif($exp_key =="to_date"){ 
                    $exp_key = "created_at"; 
                    $value = $value." 23:59:59"; 
                    $data=$data->where("monthly_evaluations_details.$exp_key", "<=", $value) ; 
                  } 
                }else{ 
                  $data=$data->where("monthly_evaluations_details.$exp_key", "=", $value) ; 
                } 
 
               }
           }
       }
   }
}
 /********************************************************************/
 $data=$data->where("monthly_evaluations_details.is_deleted","=",0);// 0 not deleted & 1 is deleted
if (Auth::user()["tbl_users_type_id"] ==1) { // super admin
    $permissions = array(
                         "insertNew"=>true,
                         "viewPage"=>true,
                         "delete"=>true,
                         "update"=>true,
                         );
} elseif(Auth::user()["tbl_users_type_id"] ==2){ // administrators
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"monthly_evaluations_details"),
      "update"=>    Permission::CheckPermission(2,"monthly_evaluations_details"),
      "insertNew"=> Permission::CheckPermission(3,"monthly_evaluations_details"),
      "delete"=>    Permission::CheckPermission(4,"monthly_evaluations_details"),
      );
}else {     
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"monthly_evaluations_details"),
      "update"=>    Permission::CheckPermission(2,"monthly_evaluations_details"),
      "insertNew"=> Permission::CheckPermission(3,"monthly_evaluations_details"),
      "delete"=>    Permission::CheckPermission(4,"monthly_evaluations_details"),
      );
} 
  $pagination= env("PAGINATION");
  if (isset($_COOKIE["monthly_evaluations_details_pagination"])) {
    $pagination = $_COOKIE["monthly_evaluations_details_pagination"];
  }
  
 $data=$data->paginate($pagination);
 $layout ="table";
  if (isset($_COOKIE["monthly_evaluations_details"])) { 
    $layout = $_COOKIE["monthly_evaluations_details"];
  }
 /****** foreign key filters start ******/ 
      $data_monthly_evaluations = monthly_evaluations_model::where("is_deleted",0)->get(); 
      $data_assessment_criteria = assessment_criteria_model::where("is_deleted",0)->get(); 
 /****** foreign key filters end ******/ 
  
  
  
       $array = array(
                     "records"=>$data,
                     "folderName"=>"evaluations",
                     "table"=>"monthly_evaluations_details",
                     "permissions"=>$permissions,
                     "lang"=>$lang,
                     "layout"=>$layout,
                     "pagination"=>$pagination,
                     "data_monthly_evaluations"=>$data_monthly_evaluations,
                     "data_assessment_criteria"=>$data_assessment_criteria,
                    );
    return view("adminDashboard.evaluations.monthly_evaluations_details.monthly_evaluations_details" ,$array);
  }
function  monthly_evaluations_details_delete(Request $request){
  //  proccess 10000008 - delete controller
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
   $permissions = array( "delete"=>true   );
   }else{
   $permissions = array( "delete"=> Permission::CheckPermission(4,"monthly_evaluations_details")); 
  }
  
  //check if current user has permission
  if($permissions["delete"] == false){
      return response()->json(array("response"=>"no_permission","message"=> __("public.noPermission_to_delete_record"),));
   }
  
 $id=decrypt($request->input("id"));
 $table="monthly_evaluations_details";
 $id_name = $table . "_id";
 if(Delete::checkRow($id_name,$id)){  // this function to check if this record has been related with another tables
      return response()->json( array("response"=>"not_allow","message"=> __("public.not_allow_to_delete_record"),) );
 }else{
$monthly_evaluations_details = monthly_evaluations_details_model::find($id);
$deleted = monthly_evaluations_details_model::where("id", $id)->update(["is_deleted" => 1]);
    if($deleted){                    
    activity("monthly_evaluations_details") 
    ->performedOn($monthly_evaluations_details) 
    ->causedBy(Auth::user()) 
    ->withProperties([ 
      "attributes" => json_encode($monthly_evaluations_details, JSON_UNESCAPED_UNICODE), 
    ]) 
    ->log("deleted"); 
      return response()->json(  array("response"=>"deleted","message"=> __("public.success_deleted_record"),) );    
                       
  } 
      return response()->json(array("response"=>"error", "message"=> __("public.error_server")));  
  }
}
function  monthly_evaluations_details_form_add(){
  //  proccess 100000057 -add form
   $lang =app()->getLocale();
   
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
    $permissions = array( "insertNew"=>true   );
   }else{
    $permissions = array( "insertNew"=> Permission::CheckPermission(3,"monthly_evaluations_details")); 
   }
   
 /****** foreign key filters start ******/ 
      $data_monthly_evaluations = monthly_evaluations_model::where("is_deleted",0)->get(); 
      $data_assessment_criteria = assessment_criteria_model::where("is_deleted",0)->get(); 
 /****** foreign key filters end ******/ 
   $array = array(
      "folderName"=>"evaluations",
      "table"=>"monthly_evaluations_details",
      "permissions"=>$permissions,
      "lang"=>$lang,
      "data_monthly_evaluations"=>$data_monthly_evaluations,
      "data_assessment_criteria"=>$data_assessment_criteria,
   );
       return view("adminDashboard.evaluations.monthly_evaluations_details.ajax.monthly_evaluations_details_form_add",$array);
  }
function  monthly_evaluations_details_insert(Request $request){
  //  proccess 10000004 - confirm insert
   $request->validate(monthly_evaluations_details_model::rules($request)); 
   $data=array(); 
   $data["monthly_evaluations_id"]=  $request->input()["monthly_evaluations_id"] ; 
   $data["assessment_criteria_id"]=  $request->input()["assessment_criteria_id"] ; 
   $data["n_a"]=  $request->input()["n_a"] ; 
   $data["below_standard"]=  $request->input()["below_standard"] ; 
   $data["meets_standard"]=  $request->input()["meets_standard"] ; 
   $data["above_standard"]=  $request->input()["above_standard"] ; 
   $data["feedback_discussion"]=  $request->input()["feedback_discussion"] ; 
   $data["feedback"]=  $request->input()["feedback"] ; 
   $data["aspects"]=  $request->input()["aspects"] ; 
   $data["suggested"]=  $request->input()["suggested"] ; 
   $data["able_perform_procedure"]=  $request->input()["able_perform_procedure"] ; 
   $data["unable_perform_procedure"]=  $request->input()["unable_perform_procedure"] ; 
   $data["trained_and_competent"]=  $request->input()["trained_and_competent"] ; 
   $data["able_perform_procedure_limited"]=  $request->input()["able_perform_procedure_limited"] ; 
   $data["competent_perform_procedure_unsupervised"]=  $request->input()["competent_perform_procedure_unsupervised"] ; 
   $data["agree_action_plan"]=  $request->input()["agree_action_plan"] ; 
$data["created_by"]=Auth::user()->id;
$insert = monthly_evaluations_details_model::create($data);
if($insert){
  Session::flash("success_update",  __("public.flashMsg_SuccessInsert"));
     return response()->json(["response" => "inserted"]);
 }else{
   return response()->json(["response" => "error"]); 
 }
}
function monthly_evaluations_details_form_update(Request $request){
  // proccess 100000013 - update form
$id =decrypt($request->input("id"));
$records = monthly_evaluations_details_model::findOrFail($id);
$lang =app()->getLocale();
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
      $permissions = array("update"=>true );
   }else{
      $permissions = array( "update"=> Permission::CheckPermission(2,"monthly_evaluations_details") ); 
   }


 /****** foreign key filters start ******/ 
      $data_monthly_evaluations = monthly_evaluations_model::where("is_deleted",0)->get(); 
      $data_assessment_criteria = assessment_criteria_model::where("is_deleted",0)->get(); 
 /****** foreign key filters end ******/ 

$array = array(
              "folderName"=>"settings",
              "table"=>"employees",
              "records"=>$records ,
              "permissions"=>$permissions,
              "lang"=>$lang,
              "data_monthly_evaluations"=>$data_monthly_evaluations,
              "data_assessment_criteria"=>$data_assessment_criteria,
);

    return view("adminDashboard.evaluations.monthly_evaluations_details.ajax.monthly_evaluations_details_form_update",$array);
}
function  monthly_evaluations_details_update(Request $request){
  // proccess 1000000266
  $evaluations_monthly_evaluations_details = monthly_evaluations_details_model::findOrFail(  decrypt($request->input("id")) );
  $oldData = $evaluations_monthly_evaluations_details->getOriginal();
  //$request->validate(monthly_evaluations_details_model::rules());;
  $data = array();
    $data["monthly_evaluations_id"]= decrypt($request->input()["monthly_evaluations_id"]) ; 
    $data["assessment_criteria_id"]= decrypt($request->input()["assessment_criteria_id"]) ; 
  $data["n_a"]= $request->input()["n_a"] ; 
  $data["below_standard"]= $request->input()["below_standard"] ; 
  $data["meets_standard"]= $request->input()["meets_standard"] ; 
  $data["above_standard"]= $request->input()["above_standard"] ; 
  $data["feedback_discussion"]= $request->input()["feedback_discussion"] ; 
  $data["feedback"]= $request->input()["feedback"] ; 
  $data["aspects"]= $request->input()["aspects"] ; 
  $data["suggested"]= $request->input()["suggested"] ; 
  $data["able_perform_procedure"]= $request->input()["able_perform_procedure"] ; 
  $data["unable_perform_procedure"]= $request->input()["unable_perform_procedure"] ; 
  $data["trained_and_competent"]= $request->input()["trained_and_competent"] ; 
  $data["able_perform_procedure_limited"]= $request->input()["able_perform_procedure_limited"] ; 
  $data["competent_perform_procedure_unsupervised"]= $request->input()["competent_perform_procedure_unsupervised"] ; 
  $data["agree_action_plan"]= $request->input()["agree_action_plan"] ; 
  $data["updated_by"]=Auth::user()["id"];
  $data["updated_at"]=date("Y-m-d H:i:s" );
  $updated = monthly_evaluations_details_model::where("id","=", decrypt($request->input("id")) )->update($data);
  if($updated){ 
  $newData = $data;
  activity("monthly_evaluations_details")
  ->performedOn($evaluations_monthly_evaluations_details)
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
         
         
         
 /****************End Table (monthly_evaluations_details) Functionality******************/
         
         
         
  
  
 }
