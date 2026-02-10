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
use App\Models\Admin\genders_model;
use App\Http\Controllers\AdminController\UserAuthController;
class genders_controller extends Controller
{
 /*  
  This controller has been generated Automatically by generatesystems.com  
  */ 
/**************Start Table (genders) Functionality **************/
function index(Request $request)
  {
  //  proccess 100000075
  $lang =app()->getLocale();   
  $host = request()->getHttpHost();   
  $hostUrl = "https://".$host."/uploads/documents/";  
  $data = genders_model::select(    
                  "genders.id   AS  id",
                  "genders.name_en   AS  name_en",
                  "genders.name_ar   AS  name_ar"
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
                    $data=$data->where("genders.$exp_key", "=", $value) ;
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
                    $data=$data->where("genders.$exp_key", ">=", $value) ; 
                  }elseif($exp_key =="to_date"){ 
                    $exp_key = "created_at"; 
                    $value = $value." 23:59:59"; 
                    $data=$data->where("genders.$exp_key", "<=", $value) ; 
                  } 
                }else{ 
                  $data=$data->where("genders.$exp_key", "=", $value) ; 
                } 
 
               }
           }
       }
   }
}
 /********************************************************************/
 $data=$data->where("genders.is_deleted","=",0);// 0 not deleted & 1 is deleted
if (Auth::user()["tbl_users_type_id"] ==1) { // super admin
    $permissions = array(
                         "insertNew"=>true,
                         "viewPage"=>true,
                         "delete"=>true,
                         "update"=>true,
                         );
} elseif(Auth::user()["tbl_users_type_id"] ==2){ // administrators
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"genders"),
      "update"=>    Permission::CheckPermission(2,"genders"),
      "insertNew"=> Permission::CheckPermission(3,"genders"),
      "delete"=>    Permission::CheckPermission(4,"genders"),
      );
}else {     
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"genders"),
      "update"=>    Permission::CheckPermission(2,"genders"),
      "insertNew"=> Permission::CheckPermission(3,"genders"),
      "delete"=>    Permission::CheckPermission(4,"genders"),
      );
} 
  $pagination= env("PAGINATION");
  if (isset($_COOKIE["genders_pagination"])) {
    $pagination = $_COOKIE["genders_pagination"];
  }
  
 $data=$data->paginate($pagination);
 $layout ="table";
  if (isset($_COOKIE["genders"])) { 
    $layout = $_COOKIE["genders"];
  }
  
  
  
       $array = array(
                     "records"=>$data,
                     "folderName"=>"settings",
                     "table"=>"genders",
                     "permissions"=>$permissions,
                     "lang"=>$lang,
                     "layout"=>$layout,
                     "pagination"=>$pagination,
                    );
    return view("adminDashboard.settings.genders.genders" ,$array);
  }
function  genders_delete(Request $request){
  //  proccess 10000008 - delete controller
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
   $permissions = array( "delete"=>true   );
   }else{
   $permissions = array( "delete"=> Permission::CheckPermission(4,"genders")); 
  }
  
  //check if current user has permission
  if($permissions["delete"] == false){
      return response()->json(array("response"=>"no_permission","message"=> __("public.noPermission_to_delete_record"),));
   }
  
 $id=decrypt($request->input("id"));
 $table="genders";
 $id_name = $table . "_id";
 if(Delete::checkRow($id_name,$id)){  // this function to check if this record has been related with another tables
      return response()->json( array("response"=>"not_allow","message"=> __("public.not_allow_to_delete_record"),) );
 }else{
$genders = genders_model::find($id);
$deleted = genders_model::where("id", $id)->update(["is_deleted" => 1]);
    if($deleted){                    
    activity("genders") 
    ->performedOn($genders) 
    ->causedBy(Auth::user()) 
    ->withProperties([ 
      "attributes" => json_encode($genders, JSON_UNESCAPED_UNICODE), 
    ]) 
    ->log("deleted"); 
      return response()->json(  array("response"=>"deleted","message"=> __("public.success_deleted_record"),) );    
                       
  } 
      return response()->json(array("response"=>"error", "message"=> __("public.error_server")));  
  }
}
function  genders_form_add(){
  //  proccess 100000057 -add form
   $lang =app()->getLocale();
   
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
    $permissions = array( "insertNew"=>true   );
   }else{
    $permissions = array( "insertNew"=> Permission::CheckPermission(3,"genders")); 
   }
   
   $array = array(
      "folderName"=>"settings",
      "table"=>"genders",
      "permissions"=>$permissions,
      "lang"=>$lang,
   );
       return view("adminDashboard.settings.genders.ajax.genders_form_add",$array);
  }
function  genders_insert(Request $request){
  //  proccess 10000004 - confirm insert
   $request->validate(genders_model::rules($request)); 
   $data=array(); 
   $data["name_en"]=  $request->input()["name_en"] ; 
   $data["name_ar"]=  $request->input()["name_ar"] ; 
$data["created_by"]=Auth::user()->id;
$insert = genders_model::create($data);
if($insert){
  Session::flash("success_update",  __("public.flashMsg_SuccessInsert"));
     return response()->json(["response" => "inserted"]);
 }else{
   return response()->json(["response" => "error"]); 
 }
}
function genders_form_update(Request $request){
  // proccess 100000013 - update form
$id =decrypt($request->input("id"));
$records = genders_model::findOrFail($id);
$lang =app()->getLocale();
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
      $permissions = array("update"=>true );
   }else{
      $permissions = array( "update"=> Permission::CheckPermission(2,"genders") ); 
   }



$array = array(
              "folderName"=>"settings",
              "table"=>"employees",
              "records"=>$records ,
              "permissions"=>$permissions,
              "lang"=>$lang,
);

    return view("adminDashboard.settings.genders.ajax.genders_form_update",$array);
}
function  genders_update(Request $request){
  // proccess 1000000266
  $settings_genders = genders_model::findOrFail(  decrypt($request->input("id")) );
  $oldData = $settings_genders->getOriginal();
  //$request->validate(genders_model::rules());;
  $data = array();
  $data["name_en"]= $request->input()["name_en"] ; 
  $data["name_ar"]= $request->input()["name_ar"] ; 
  $data["updated_by"]=Auth::user()["id"];
  $data["updated_at"]=date("Y-m-d H:i:s" );
  $updated = genders_model::where("id","=", decrypt($request->input("id")) )->update($data);
  if($updated){ 
  $newData = $data;
  activity("genders")
  ->performedOn($settings_genders)
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
         
         
         
 /****************End Table (genders) Functionality******************/
         
         
         
  
  
 }
