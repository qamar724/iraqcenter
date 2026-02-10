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
use App\Models\Admin\monthly_evaluation_forms_model;
use App\Http\Controllers\AdminController\UserAuthController;
class monthly_evaluation_forms_controller extends Controller
{
 /*  
  This controller has been generated Automatically by generatesystems.com  
  */ 
/**************Start Table (monthly_evaluation_forms) Functionality **************/
function index(Request $request)
  {
  //  proccess 100000075
  $lang =app()->getLocale();   
  $host = request()->getHttpHost();   
  $hostUrl = "https://".$host."/uploads/documents/";  
  $data = monthly_evaluation_forms_model::select(    
                  "monthly_evaluation_forms.id   AS  id",
                  "monthly_evaluation_forms.name   AS  name"
                   )
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
                    $data=$data->where("monthly_evaluation_forms.$exp_key", "=", $value) ;
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
                    $data=$data->where("monthly_evaluation_forms.$exp_key", ">=", $value) ; 
                  }elseif($exp_key =="to_date"){ 
                    $exp_key = "created_at"; 
                    $value = $value." 23:59:59"; 
                    $data=$data->where("monthly_evaluation_forms.$exp_key", "<=", $value) ; 
                  } 
                }else{ 
                  $data=$data->where("monthly_evaluation_forms.$exp_key", "=", $value) ; 
                } 
 
               }
           }
       }
   }
}
 /********************************************************************/
 $data=$data->where("monthly_evaluation_forms.is_deleted","=",0);// 0 not deleted & 1 is deleted
if (Auth::user()["tbl_users_type_id"] ==1) { // super admin
    $permissions = array(
                         "insertNew"=>true,
                         "viewPage"=>true,
                         "delete"=>true,
                         "update"=>true,
                         );
} elseif(Auth::user()["tbl_users_type_id"] ==2){ // administrators
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"monthly_evaluation_forms"),
      "update"=>    Permission::CheckPermission(2,"monthly_evaluation_forms"),
      "insertNew"=> Permission::CheckPermission(3,"monthly_evaluation_forms"),
      "delete"=>    Permission::CheckPermission(4,"monthly_evaluation_forms"),
      );
}else {     
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"monthly_evaluation_forms"),
      "update"=>    Permission::CheckPermission(2,"monthly_evaluation_forms"),
      "insertNew"=> Permission::CheckPermission(3,"monthly_evaluation_forms"),
      "delete"=>    Permission::CheckPermission(4,"monthly_evaluation_forms"),
      );
} 
  $pagination= env("PAGINATION");
  if (isset($_COOKIE["monthly_evaluation_forms_pagination"])) {
    $pagination = $_COOKIE["monthly_evaluation_forms_pagination"];
  }
  
 $data=$data->paginate($pagination);
 $layout ="table";
  if (isset($_COOKIE["monthly_evaluation_forms"])) { 
    $layout = $_COOKIE["monthly_evaluation_forms"];
  }
  
  
  
       $array = array(
                     "records"=>$data,
                     "folderName"=>"settings",
                     "table"=>"monthly_evaluation_forms",
                     "permissions"=>$permissions,
                     "lang"=>$lang,
                     "layout"=>$layout,
                     "pagination"=>$pagination,
                    );
    return view("adminDashboard.settings.monthly_evaluation_forms.monthly_evaluation_forms" ,$array);
  }
function  monthly_evaluation_forms_delete(Request $request){
  //  proccess 10000008 - delete controller
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
   $permissions = array( "delete"=>true   );
   }else{
   $permissions = array( "delete"=> Permission::CheckPermission(4,"monthly_evaluation_forms")); 
  }
  
  //check if current user has permission
  if($permissions["delete"] == false){
      return response()->json(array("response"=>"no_permission","message"=> __("public.noPermission_to_delete_record"),));
   }
  
 $id=decrypt($request->input("id"));
 $table="monthly_evaluation_forms";
 $id_name = $table . "_id";
 if(Delete::checkRow($id_name,$id)){  // this function to check if this record has been related with another tables
      return response()->json( array("response"=>"not_allow","message"=> __("public.not_allow_to_delete_record"),) );
 }else{
$monthly_evaluation_forms = monthly_evaluation_forms_model::find($id);
$deleted = monthly_evaluation_forms_model::where("id", $id)->update(["is_deleted" => 1]);
    if($deleted){                    
    activity("monthly_evaluation_forms") 
    ->performedOn($monthly_evaluation_forms) 
    ->causedBy(Auth::user()) 
    ->withProperties([ 
      "attributes" => json_encode($monthly_evaluation_forms, JSON_UNESCAPED_UNICODE), 
    ]) 
    ->log("deleted"); 
      return response()->json(  array("response"=>"deleted","message"=> __("public.success_deleted_record"),) );    
                       
  } 
      return response()->json(array("response"=>"error", "message"=> __("public.error_server")));  
  }
}
function  monthly_evaluation_forms_form_add(){
  //  proccess 100000057 -add form
   $lang =app()->getLocale();
   
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
    $permissions = array( "insertNew"=>true   );
   }else{
    $permissions = array( "insertNew"=> Permission::CheckPermission(3,"monthly_evaluation_forms")); 
   }
   
   $array = array(
      "folderName"=>"settings",
      "table"=>"monthly_evaluation_forms",
      "permissions"=>$permissions,
      "lang"=>$lang,
   );
       return view("adminDashboard.settings.monthly_evaluation_forms.ajax.monthly_evaluation_forms_form_add",$array);
  }
function  monthly_evaluation_forms_insert(Request $request){
  //  proccess 10000004 - confirm insert
   $request->validate(monthly_evaluation_forms_model::rules($request)); 
   $data=array(); 
   $data["name"]=  $request->input()["name"] ; 
$data["created_by"]=Auth::user()->id;
$insert = monthly_evaluation_forms_model::create($data);
if($insert){
  Session::flash("success_update",  __("public.flashMsg_SuccessInsert"));
     return response()->json(["response" => "inserted"]);
 }else{
   return response()->json(["response" => "error"]); 
 }
}
function monthly_evaluation_forms_form_update(Request $request){
  // proccess 100000013 - update form
$id =decrypt($request->input("id"));
$records = monthly_evaluation_forms_model::findOrFail($id);
$lang =app()->getLocale();
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
      $permissions = array("update"=>true );
   }else{
      $permissions = array( "update"=> Permission::CheckPermission(2,"monthly_evaluation_forms") ); 
   }



$array = array(
              "folderName"=>"settings",
              "table"=>"employees",
              "records"=>$records ,
              "permissions"=>$permissions,
              "lang"=>$lang,
);

    return view("adminDashboard.settings.monthly_evaluation_forms.ajax.monthly_evaluation_forms_form_update",$array);
}
function  monthly_evaluation_forms_update(Request $request){
  // proccess 1000000266
  $settings_monthly_evaluation_forms = monthly_evaluation_forms_model::findOrFail(  decrypt($request->input("id")) );
  $oldData = $settings_monthly_evaluation_forms->getOriginal();
  //$request->validate(monthly_evaluation_forms_model::rules());;
  $data = array();
  $data["name"]= $request->input()["name"] ; 
  $data["updated_by"]=Auth::user()["id"];
  $data["updated_at"]=date("Y-m-d H:i:s" );
  $updated = monthly_evaluation_forms_model::where("id","=", decrypt($request->input("id")) )->update($data);
  if($updated){ 
  $newData = $data;
  activity("monthly_evaluation_forms")
  ->performedOn($settings_monthly_evaluation_forms)
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
         
         
         
 /****************End Table (monthly_evaluation_forms) Functionality******************/
         
         
         
  
  
 }
