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
use App\Models\Admin\procedure_list_model;
use App\Models\Admin\category_procedure_model;
use App\Models\Admin\monthly_evaluations_details_model;
use App\Http\Controllers\AdminController\UserAuthController;
class procedure_list_controller extends Controller
{
 
/**************Start Table (procedure_list) Functionality **************/
function index(Request $request)
  {
  //  proccess 100000075
  $lang =app()->getLocale();   
  $host = request()->getHttpHost();   
  $hostUrl = "https://".$host."/uploads/documents/";  
  $data = procedure_list_model::select(    
                  "procedure_list.id   AS  id",
                  "procedure_list.name   AS  name",
                 "category_procedure.name AS  category_procedure_name",
                  "procedure_list.category_procedure_id   AS  category_procedure_id"
                   )
                 ->join ( 'category_procedure as category_procedure' ,'procedure_list.category_procedure_id', '=', 'category_procedure.id'  )
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
                    $data=$data->where("procedure_list.$exp_key", "=", $value) ;
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
                    $data=$data->where("procedure_list.$exp_key", ">=", $value) ; 
                  }elseif($exp_key =="to_date"){ 
                    $exp_key = "created_at"; 
                    $value = $value." 23:59:59"; 
                    $data=$data->where("procedure_list.$exp_key", "<=", $value) ; 
                  } 
                }else{ 
                  $data=$data->where("procedure_list.$exp_key", "=", $value) ; 
                } 
 
               }
           }
       }
   }
}
 /********************************************************************/
 $data=$data->where("procedure_list.is_deleted","=",0);// 0 not deleted & 1 is deleted
if (Auth::user()["tbl_users_type_id"] ==1) { // super admin
    $permissions = array(
                         "insertNew"=>true,
                         "viewPage"=>true,
                         "delete"=>true,
                         "update"=>true,
                         );
} elseif(Auth::user()["tbl_users_type_id"] ==2){ // administrators
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"procedure_list"),
      "update"=>    Permission::CheckPermission(2,"procedure_list"),
      "insertNew"=> Permission::CheckPermission(3,"procedure_list"),
      "delete"=>    Permission::CheckPermission(4,"procedure_list"),
      );
}else {     
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"procedure_list"),
      "update"=>    Permission::CheckPermission(2,"procedure_list"),
      "insertNew"=> Permission::CheckPermission(3,"procedure_list"),
      "delete"=>    Permission::CheckPermission(4,"procedure_list"),
      );
} 
  $pagination= env("PAGINATION");
  if (isset($_COOKIE["procedure_list_pagination"])) {
    $pagination = $_COOKIE["procedure_list_pagination"];
  }
  
 $data=$data->paginate($pagination);
 $layout ="table";
  if (isset($_COOKIE["procedure_list"])) { 
    $layout = $_COOKIE["procedure_list"];
  }
 /****** foreign key filters start ******/ 
      $data_category_procedure = category_procedure_model::where("is_deleted",0)->get(); 
 /****** foreign key filters end ******/ 
  
  
  
       $array = array(
                     "records"=>$data,
                     "folderName"=>"settings",
                     "table"=>"procedure_list",
                     "permissions"=>$permissions,
                     "lang"=>$lang,
                     "layout"=>$layout,
                     "pagination"=>$pagination,
                     "data_category_procedure"=>$data_category_procedure,
                    );
    return view("adminDashboard.settings.procedure_list.procedure_list" ,$array);
  }

function  procedure_list_delete(Request $request){
  //  proccess 10000008 - delete controller
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
   $permissions = array( "delete"=>true   );
   }else{
   $permissions = array( "delete"=> Permission::CheckPermission(4,"procedure_list")); 
  }
  
  //check if current user has permission
  if($permissions["delete"] == false){
      return response()->json(array("response"=>"no_permission","message"=> __("public.noPermission_to_delete_record"),));
   }
  
 $id=decrypt($request->input("id"));
 $table="procedure_list";
 $id_name = $table . "_id";
 
 // Check if any monthly_evaluations_details records reference this procedure
 $evaluationsCount = monthly_evaluations_details_model::where("procedure_list_id", $id)
   ->where("is_deleted", 0)
   ->count();
 
 if($evaluationsCount > 0){
   return response()->json(array("response"=>"not_allow","message"=> __("public.cannot_delete_procedure_has_evaluations")));
 }
 
 if(Delete::checkRow($id_name,$id)){  // this function to check if this record has been related with another tables
      return response()->json( array("response"=>"not_allow","message"=> __("public.not_allow_to_delete_record"),) );
 }else{
$procedure_list = procedure_list_model::find($id);
$deleted = procedure_list_model::where("id", $id)->update(["is_deleted" => 1]);
    if($deleted){                    
    activity("procedure_list") 
    ->performedOn($procedure_list) 
    ->causedBy(Auth::user()) 
    ->withProperties([ 
      "attributes" => json_encode($procedure_list, JSON_UNESCAPED_UNICODE), 
    ]) 
    ->log("deleted"); 
      return response()->json(  array("response"=>"deleted","message"=> __("public.success_deleted_record"),) );    
                       
  } 
      return response()->json(array("response"=>"error", "message"=> __("public.error_server")));  
  }
}
function  procedure_list_form_add(){
  //  proccess 100000057 -add form
   $lang =app()->getLocale();
   
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
    $permissions = array( "insertNew"=>true   );
   }else{
    $permissions = array( "insertNew"=> Permission::CheckPermission(3,"procedure_list")); 
   }

   $data_category_procedure = category_procedure_model::where("is_deleted",0)->get(); 
   
   $array = array(
      "folderName"=>"settings",
      "table"=>"procedure_list",
      "permissions"=>$permissions,
      "lang"=>$lang,
      "data_category_procedure"=>$data_category_procedure
   );
       return view("adminDashboard.settings.procedure_list.ajax.procedure_list_form_add",$array);
  }
function  procedure_list_insert(Request $request){
  //  proccess 10000004 - confirm insert
   $request->validate(procedure_list_model::rules($request)); 
   $data=array(); 
   $data["name"]=  $request->input()["name"] ; 
$categoryEncrypted = $request->input("category_procedure_id");
$data["category_procedure_id"] = null;
   if (!is_null($categoryEncrypted) && $categoryEncrypted !== "") {
       try {
           $categoryId = decrypt($categoryEncrypted);
           $data["category_procedure_id"] = $categoryId > 0 ? $categoryId : null;
       } catch (\Exception $e) {
           $data["category_procedure_id"] = null;
       }
   }
$data["created_by"]=Auth::user()->id;
$insert = procedure_list_model::create($data);
if($insert){
  Session::flash("success_update",  __("public.flashMsg_SuccessInsert"));
     return response()->json(["response" => "inserted"]);
 }else{
   return response()->json(["response" => "error"]); 
 }
}
function procedure_list_form_update(Request $request){
  // proccess 100000013 - update form
$id =decrypt($request->input("id"));
$records = procedure_list_model::findOrFail($id);
$lang =app()->getLocale();
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
      $permissions = array("update"=>true );
   }else{
      $permissions = array( "update"=> Permission::CheckPermission(2,"procedure_list") ); 
   }

   $data_category_procedure = category_procedure_model::where("is_deleted",0)->get(); 
   
$array = array(
              "folderName"=>"settings",
              "table"=>"procedure_list",
              "records"=>$records ,
              "permissions"=>$permissions,
              "lang"=>$lang,
              "data_category_procedure"=> category_procedure_model::where("is_deleted",0)->get(),
);

    return view("adminDashboard.settings.procedure_list.ajax.procedure_list_form_update",$array);
}
function  procedure_list_update(Request $request){
  // proccess 1000000266
  $settings_procedure_list = procedure_list_model::findOrFail(  decrypt($request->input("id")) );
  $oldData = $settings_procedure_list->getOriginal();
  //$request->validate(procedure_list_model::rules());;
  $data = array();
  $data["name"]= $request->input()["name"] ; 
  $categoryEncrypted = $request->input("category_procedure_id");
  $data["updated_by"]=Auth::user()["id"];
  $data["updated_at"]=date("Y-m-d H:i:s" );
  $updated = procedure_list_model::where("id","=", decrypt($request->input("id")) )->update($data);
  if($updated){ 
  $newData = $data;
  activity("procedure_list")
  ->performedOn($settings_procedure_list)
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
         
         
         
 /****************End Table (procedure_list) Functionality******************/
         
         
         
  
  
 }
