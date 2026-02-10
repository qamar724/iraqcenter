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
use App\Models\Admin\category_procedure_model;
use App\Models\Admin\procedure_list_model;
use App\Http\Controllers\AdminController\UserAuthController;
class category_procedure_controller extends Controller
{
/**************Start Table (category_procedure) Functionality **************/
function index(Request $request)
  {
  $lang =app()->getLocale();   
  $host = request()->getHttpHost();   
  $hostUrl = "https://".$host."/uploads/documents/";  
  $data = category_procedure_model::select(    
                  "category_procedure.id   AS  id",
                  "category_procedure.name   AS  name"
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
                    $data=$data->where("category_procedure.$exp_key", "=", $value) ;
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
                    $data=$data->where("category_procedure.$exp_key", ">=", $value) ; 
                  }elseif($exp_key =="to_date"){ 
                    $exp_key = "created_at"; 
                    $value = $value." 23:59:59"; 
                    $data=$data->where("category_procedure.$exp_key", "<=", $value) ; 
                  } 
                }else{ 
                  $data=$data->where("category_procedure.$exp_key", "=", $value) ; 
                } 
 
               }
           }
       }
   }
}
 /********************************************************************/
 $data=$data->where("category_procedure.is_deleted","=",0);// 0 not deleted & 1 is deleted
if (Auth::user()["tbl_users_type_id"] ==1) { // super admin
    $permissions = array(
                         "insertNew"=>true,
                         "viewPage"=>true,
                         "delete"=>true,
                         "update"=>true,
                         );
} elseif(Auth::user()["tbl_users_type_id"] ==2){ // administrators
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"category_procedure"),
      "update"=>    Permission::CheckPermission(2,"category_procedure"),
      "insertNew"=> Permission::CheckPermission(3,"category_procedure"),
      "delete"=>    Permission::CheckPermission(4,"category_procedure"),
      );
}else {     
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"category_procedure"),
      "update"=>    Permission::CheckPermission(2,"category_procedure"),
      "insertNew"=> Permission::CheckPermission(3,"category_procedure"),
      "delete"=>    Permission::CheckPermission(4,"category_procedure"),
      );
} 
  $pagination= env("PAGINATION");
  if (isset($_COOKIE["category_procedure_pagination"])) {
    $pagination = $_COOKIE["category_procedure_pagination"];
  }
  
 $data=$data->paginate($pagination);
 $layout ="table";
  if (isset($_COOKIE["category_procedure"])) { 
    $layout = $_COOKIE["category_procedure"];
  }
  
       $array = array(
                     "records"=>$data,
                     "folderName"=>"settings",
                     "table"=>"category_procedure",
                     "permissions"=>$permissions,
                     "lang"=>$lang,
                     "layout"=>$layout,
                     "pagination"=>$pagination,
                    );
    return view("adminDashboard.settings.category_procedure.category_procedure" ,$array);
  }
function  category_procedure_delete(Request $request){
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
   $permissions = array( "delete"=>true   );
   }else{
   $permissions = array( "delete"=> Permission::CheckPermission(4,"category_procedure")); 
  }
  
  //check if current user has permission
  if($permissions["delete"] == false){
      return response()->json(array("response"=>"no_permission","message"=> __("public.noPermission_to_delete_record"),));
   }
  
 $id=decrypt($request->input("id"));
 $table="category_procedure";
 $id_name = $table . "_id";
 
 // Check if any procedure_list records reference this category
 $procedureListCount = procedure_list_model::where("category_procedure_id", $id)
   ->where("is_deleted", 0)
   ->count();
 
 if($procedureListCount > 0){
   return response()->json(array("response"=>"not_allow","message"=> __("public.cannot_delete_category_has_procedures")));
 }
 
 if(Delete::checkRow($id_name,$id)){  // this function to check if this record has been related with another tables
      return response()->json( array("response"=>"not_allow","message"=> __("public.not_allow_to_delete_record"),) );
 }else{
$category_procedure = category_procedure_model::find($id);
$deleted = category_procedure_model::where("id", $id)->update(["is_deleted" => 1]);
    if($deleted){                    
    activity("category_procedure") 
    ->performedOn($category_procedure) 
    ->causedBy(Auth::user()) 
    ->withProperties([ 
      "attributes" => json_encode($category_procedure, JSON_UNESCAPED_UNICODE), 
    ]) 
    ->log("deleted"); 
      return response()->json(  array("response"=>"deleted","message"=> __("public.success_deleted_record"),) );    
                       
  } 
      return response()->json(array("response"=>"error", "message"=> __("public.error_server")));  
  }
}
function  category_procedure_form_add(){
   $lang =app()->getLocale();
   
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
    $permissions = array( "insertNew"=>true   );
   }else{
    $permissions = array( "insertNew"=> Permission::CheckPermission(3,"category_procedure")); 
   }
   
   $array = array(
      "folderName"=>"settings",
      "table"=>"category_procedure",
      "permissions"=>$permissions,
      "lang"=>$lang,
   );
       return view("adminDashboard.settings.category_procedure.ajax.category_procedure_form_add",$array);
  }
function  category_procedure_insert(Request $request){
   $request->validate(category_procedure_model::rules($request)); 
   $data=array(); 
   $data["name"]=  $request->input()["name"] ; 
$data["created_by"]=Auth::user()->id;
$insert = category_procedure_model::create($data);
if($insert){
  Session::flash("success_update",  __("public.flashMsg_SuccessInsert"));
     return response()->json(["response" => "inserted"]);
 }else{
   return response()->json(["response" => "error"]); 
 }
}
function category_procedure_form_update(Request $request){
$id =decrypt($request->input("id"));
$records = category_procedure_model::findOrFail($id);
$lang =app()->getLocale();
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
      $permissions = array("update"=>true );
   }else{
      $permissions = array( "update"=> Permission::CheckPermission(2,"category_procedure") ); 
   }

$array = array(
              "folderName"=>"settings",
              "table"=>"category_procedure",
              "records"=>$records ,
              "permissions"=>$permissions,
              "lang"=>$lang,
);

    return view("adminDashboard.settings.category_procedure.ajax.category_procedure_form_update",$array);
}
function  category_procedure_update(Request $request){
  $settings_category_procedure = category_procedure_model::findOrFail(  decrypt($request->input("id")) );
  $oldData = $settings_category_procedure->getOriginal();
  $data = array();
  $data["name"]= $request->input()["name"] ; 
  $data["updated_by"]=Auth::user()["id"];
  $data["updated_at"]=date("Y-m-d H:i:s" );
  $updated = category_procedure_model::where("id","=", decrypt($request->input("id")) )->update($data);
  if($updated){ 
  $newData = $data;
  activity("category_procedure")
  ->performedOn($settings_category_procedure)
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
         
 /****************End Table (category_procedure) Functionality******************/
  
 }
