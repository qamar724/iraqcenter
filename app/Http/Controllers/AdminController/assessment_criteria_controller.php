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
use App\Models\Admin\assessment_criteria_model;
use App\Models\Admin\monthly_evaluation_forms_model;
use App\Http\Controllers\AdminController\UserAuthController;
class assessment_criteria_controller extends Controller
{
 /*  
  This controller has been generated Automatically by generatesystems.com  
  */ 
/**************Start Table (assessment_criteria) Functionality **************/
function index(Request $request)
  {
  //  proccess 100000075
  $lang =app()->getLocale();   
  $host = request()->getHttpHost();   
  $hostUrl = "https://".$host."/uploads/documents/";  
  $data = assessment_criteria_model::select(    
                  "assessment_criteria.id   AS  id",
                  "monthly_evaluation_forms.name    AS  monthly_evaluation_forms_id_name",
                  "assessment_criteria.monthly_evaluation_forms_id   AS  monthly_evaluation_forms_id",
                  "assessment_criteria.question   AS  question"
                   )
                 ->join ( 'monthly_evaluation_forms as monthly_evaluation_forms' ,'assessment_criteria.monthly_evaluation_forms_id', '=', 'monthly_evaluation_forms.id'  )
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
                    $data=$data->where("assessment_criteria.$exp_key", "=", $value) ;
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
                    $data=$data->where("assessment_criteria.$exp_key", ">=", $value) ; 
                  }elseif($exp_key =="to_date"){ 
                    $exp_key = "created_at"; 
                    $value = $value." 23:59:59"; 
                    $data=$data->where("assessment_criteria.$exp_key", "<=", $value) ; 
                  } 
                }else{ 
                  $data=$data->where("assessment_criteria.$exp_key", "=", $value) ; 
                } 
 
               }
           }
       }
   }
}
 /********************************************************************/
 $data=$data->where("assessment_criteria.is_deleted","=",0);// 0 not deleted & 1 is deleted
if (Auth::user()["tbl_users_type_id"] ==1) { // super admin
    $permissions = array(
                         "insertNew"=>true,
                         "viewPage"=>true,
                         "delete"=>true,
                         "update"=>true,
                         );
} elseif(Auth::user()["tbl_users_type_id"] ==2){ // administrators
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"assessment_criteria"),
      "update"=>    Permission::CheckPermission(2,"assessment_criteria"),
      "insertNew"=> Permission::CheckPermission(3,"assessment_criteria"),
      "delete"=>    Permission::CheckPermission(4,"assessment_criteria"),
      );
}else {     
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"assessment_criteria"),
      "update"=>    Permission::CheckPermission(2,"assessment_criteria"),
      "insertNew"=> Permission::CheckPermission(3,"assessment_criteria"),
      "delete"=>    Permission::CheckPermission(4,"assessment_criteria"),
      );
} 
  $pagination= env("PAGINATION");
  if (isset($_COOKIE["assessment_criteria_pagination"])) {
    $pagination = $_COOKIE["assessment_criteria_pagination"];
  }
  
 $data=$data->paginate($pagination);
 $layout ="table";
  if (isset($_COOKIE["assessment_criteria"])) { 
    $layout = $_COOKIE["assessment_criteria"];
  }
 /****** foreign key filters start ******/ 
      $data_monthly_evaluation_forms = monthly_evaluation_forms_model::where("is_deleted",0)->get(); 
 /****** foreign key filters end ******/ 
  
  
  
       $array = array(
                     "records"=>$data,
                     "folderName"=>"settings",
                     "table"=>"assessment_criteria",
                     "permissions"=>$permissions,
                     "lang"=>$lang,
                     "layout"=>$layout,
                     "pagination"=>$pagination,
                     "data_monthly_evaluation_forms"=>$data_monthly_evaluation_forms,
                    );
    return view("adminDashboard.settings.assessment_criteria.assessment_criteria" ,$array);
  }
function  assessment_criteria_delete(Request $request){
  //  proccess 10000008 - delete controller
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
   $permissions = array( "delete"=>true   );
   }else{
   $permissions = array( "delete"=> Permission::CheckPermission(4,"assessment_criteria")); 
  }
  
  //check if current user has permission
  if($permissions["delete"] == false){
      return response()->json(array("response"=>"no_permission","message"=> __("public.noPermission_to_delete_record"),));
   }
  
 $id=decrypt($request->input("id"));
 $table="assessment_criteria";
 $id_name = $table . "_id";
 if(Delete::checkRow($id_name,$id)){  // this function to check if this record has been related with another tables
      return response()->json( array("response"=>"not_allow","message"=> __("public.not_allow_to_delete_record"),) );
 }else{
$assessment_criteria = assessment_criteria_model::find($id);
$deleted = assessment_criteria_model::where("id", $id)->update(["is_deleted" => 1]);
    if($deleted){                    
    activity("assessment_criteria") 
    ->performedOn($assessment_criteria) 
    ->causedBy(Auth::user()) 
    ->withProperties([ 
      "attributes" => json_encode($assessment_criteria, JSON_UNESCAPED_UNICODE), 
    ]) 
    ->log("deleted"); 
      return response()->json(  array("response"=>"deleted","message"=> __("public.success_deleted_record"),) );    
                       
  } 
      return response()->json(array("response"=>"error", "message"=> __("public.error_server")));  
  }
}
function  assessment_criteria_form_add(){
  //  proccess 100000057 -add form
   $lang =app()->getLocale();
   
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
    $permissions = array( "insertNew"=>true   );
   }else{
    $permissions = array( "insertNew"=> Permission::CheckPermission(3,"assessment_criteria")); 
   }
   
 /****** foreign key filters start ******/ 
      $data_monthly_evaluation_forms = monthly_evaluation_forms_model::where("is_deleted",0)->get(); 
 /****** foreign key filters end ******/ 
   $array = array(
      "folderName"=>"settings",
      "table"=>"assessment_criteria",
      "permissions"=>$permissions,
      "lang"=>$lang,
      "data_monthly_evaluation_forms"=>$data_monthly_evaluation_forms,
   );
       return view("adminDashboard.settings.assessment_criteria.ajax.assessment_criteria_form_add",$array);
  }
function  assessment_criteria_insert(Request $request){
  //  proccess 10000004 - confirm insert
   $request->validate(assessment_criteria_model::rules($request)); 
   $data=array(); 
   $data["monthly_evaluation_forms_id"]=  $request->input()["monthly_evaluation_forms_id"] ; 
   $data["question"]=  $request->input()["question"] ; 
$data["created_by"]=Auth::user()->id;
$insert = assessment_criteria_model::create($data);
if($insert){
  Session::flash("success_update",  __("public.flashMsg_SuccessInsert"));
     return response()->json(["response" => "inserted"]);
 }else{
   return response()->json(["response" => "error"]); 
 }
}
function assessment_criteria_form_update(Request $request){
  // proccess 100000013 - update form
$id =decrypt($request->input("id"));
$records = assessment_criteria_model::findOrFail($id);
$lang =app()->getLocale();
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
      $permissions = array("update"=>true );
   }else{
      $permissions = array( "update"=> Permission::CheckPermission(2,"assessment_criteria") ); 
   }


 /****** foreign key filters start ******/ 
      $data_monthly_evaluation_forms = monthly_evaluation_forms_model::where("is_deleted",0)->get(); 
 /****** foreign key filters end ******/ 

$array = array(
              "folderName"=>"settings",
              "table"=>"employees",
              "records"=>$records ,
              "permissions"=>$permissions,
              "lang"=>$lang,
              "data_monthly_evaluation_forms"=>$data_monthly_evaluation_forms,
);

    return view("adminDashboard.settings.assessment_criteria.ajax.assessment_criteria_form_update",$array);
}
function  assessment_criteria_update(Request $request){
  // proccess 1000000266
  $settings_assessment_criteria = assessment_criteria_model::findOrFail(  decrypt($request->input("id")) );
  $oldData = $settings_assessment_criteria->getOriginal();
  //$request->validate(assessment_criteria_model::rules());;
  $data = array();
    $data["monthly_evaluation_forms_id"]= decrypt($request->input()["monthly_evaluation_forms_id"]) ; 
  $data["question"]= $request->input()["question"] ; 
  $data["updated_by"]=Auth::user()["id"];
  $data["updated_at"]=date("Y-m-d H:i:s" );
  $updated = assessment_criteria_model::where("id","=", decrypt($request->input("id")) )->update($data);
  if($updated){ 
  $newData = $data;
  activity("assessment_criteria")
  ->performedOn($settings_assessment_criteria)
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
         
         
         
 /****************End Table (assessment_criteria) Functionality******************/
         
         
         
  
  
 }
