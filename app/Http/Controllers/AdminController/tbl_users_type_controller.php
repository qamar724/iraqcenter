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
use App\Models\Admin\tbl_users_type_model;
use App\Http\Controllers\AdminController\UserAuthController;
class tbl_users_type_controller extends Controller
{
 /*  
  This controller has been generated Automatically by generatesystems.com  
  */ 
/**************Start Table (tbl_users_type) Functionality **************/
/************* View Permission ***************/
 
    public function permission_form_roles(Request $request) 
    { 
  //  proccess 100000011
       return view("adminDashboard.administrator.tbl_users_type.ajax.permission_form_roles", ["tbl_users_type_id"=>decrypt($request->tbl_users_type_id)]);
    }
 
/************* Set Permission ***************/
    public function insertPermissions(Request $request)
    {
  //  proccess 100000010
        $data=array(
          "tbl_users_type_id"=>$request->input("tbl_users_type_id"),
          "tbl_adv_menu_id"=>$request->input("tbl_adv_menu_id"),
          "tbl_adv_menu_sub_id"=>$request->input("tbl_adv_menu_sub_id"),
          "tbl_actions_id"=>$request->input("tbl_action_id"),
          "users_id"=> Auth::user()["id"], );
        if (DB::table("tbl_permissions")->insert($data)) {
            return response([
                "message"=>"inserted",
                ]);
        } else {
            return response([
                "message"=>"error"
                ]);
        }
    }

/************* Remove Permission ***************/
    public function removePermissions(Request $request)
    {
  //  proccess 10000009
       $data =  DB::table("tbl_permissions")->where([
          ["tbl_users_type_id", "=", $request->input("tbl_users_type_id")],
          ["tbl_adv_menu_id", "=", $request->input("tbl_adv_menu_id")],
          ["tbl_adv_menu_sub_id", "=",$request->input("tbl_adv_menu_sub_id")],
          ["tbl_actions_id", "=", $request->input("tbl_action_id")]
      ])->delete();
        if ($data) {
            return response([
                "message"=>"removed",
                ]);
        } else {
            return response([
                "message"=>"error"
                ]);
        }
    }
function index(Request $request)
  {
  //  proccess 100000075
  $lang =app()->getLocale();   
  $host = request()->getHttpHost();   
  $hostUrl = "https://".$host."/uploads/documents/";  
  $data = tbl_users_type_model::select(    
                  "tbl_users_type.id   AS  id",
                  "tbl_users_type.name   AS  name"
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
                    $data=$data->where("tbl_users_type.$exp_key", "=", $value) ;
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
                    $data=$data->where("tbl_users_type.$exp_key", ">=", $value) ; 
                  }elseif($exp_key =="to_date"){ 
                    $exp_key = "created_at"; 
                    $value = $value." 23:59:59"; 
                    $data=$data->where("tbl_users_type.$exp_key", "<=", $value) ; 
                  } 
                }else{ 
                  $data=$data->where("tbl_users_type.$exp_key", "=", $value) ; 
                } 
 
               }
           }
       }
   }
}
 /********************************************************************/
 $data=$data->where("tbl_users_type.is_deleted","=",0);// 0 not deleted & 1 is deleted
if (Auth::user()["tbl_users_type_id"] ==1) { // super admin
    $permissions = array(
                         "insertNew"=>true,
                         "viewPage"=>true,
                         "delete"=>true,
                         "update"=>true,
                         );
} elseif(Auth::user()["tbl_users_type_id"] ==2){ // administrators
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"tbl_users_type"),
      "update"=>    Permission::CheckPermission(2,"tbl_users_type"),
      "insertNew"=> Permission::CheckPermission(3,"tbl_users_type"),
      "delete"=>    Permission::CheckPermission(4,"tbl_users_type"),
      );
}else {     
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"tbl_users_type"),
      "update"=>    Permission::CheckPermission(2,"tbl_users_type"),
      "insertNew"=> Permission::CheckPermission(3,"tbl_users_type"),
      "delete"=>    Permission::CheckPermission(4,"tbl_users_type"),
      );
} 
  $pagination= env("PAGINATION");
  if (isset($_COOKIE["tbl_users_type_pagination"])) {
    $pagination = $_COOKIE["tbl_users_type_pagination"];
  }
  
 $data=$data->paginate($pagination);
 $layout ="table";
  if (isset($_COOKIE["tbl_users_type"])) { 
    $layout = $_COOKIE["tbl_users_type"];
  }
  
  
  
       $array = array(
                     "records"=>$data,
                     "folderName"=>"administrator",
                     "table"=>"tbl_users_type",
                     "permissions"=>$permissions,
                     "lang"=>$lang,
                     "layout"=>$layout,
                     "pagination"=>$pagination,
                    );
    return view("adminDashboard.administrator.tbl_users_type.tbl_users_type" ,$array);
  }
function  tbl_users_type_delete(Request $request){
  //  proccess 10000008 - delete controller
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
   $permissions = array( "delete"=>true   );
   }else{
   $permissions = array( "delete"=> Permission::CheckPermission(4,"tbl_users_type")); 
  }
  
  //check if current user has permission
  if($permissions["delete"] == false){
      return response()->json(array("response"=>"no_permission","message"=> __("public.noPermission_to_delete_record"),));
   }
  
 $id=decrypt($request->input("id"));
 $table="tbl_users_type";
 $id_name = $table . "_id";
 if(Delete::checkRow($id_name,$id)){  // this function to check if this record has been related with another tables
      return response()->json( array("response"=>"not_allow","message"=> __("public.not_allow_to_delete_record"),) );
 }else{
$tbl_users_type = tbl_users_type_model::find($id);
$deleted = tbl_users_type_model::where("id", $id)->update(["is_deleted" => 1]);
    if($deleted){                    
    activity("tbl_users_type") 
    ->performedOn($tbl_users_type) 
    ->causedBy(Auth::user()) 
    ->withProperties([ 
      "attributes" => json_encode($tbl_users_type, JSON_UNESCAPED_UNICODE), 
    ]) 
    ->log("deleted"); 
      return response()->json(  array("response"=>"deleted","message"=> __("public.success_deleted_record"),) );    
                       
  } 
      return response()->json(array("response"=>"error", "message"=> __("public.error_server")));  
  }
}
function  tbl_users_type_form_add(){
  //  proccess 100000057 -add form
   $lang =app()->getLocale();
   
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
    $permissions = array( "insertNew"=>true   );
   }else{
    $permissions = array( "insertNew"=> Permission::CheckPermission(3,"tbl_users_type")); 
   }
   
   $array = array(
      "folderName"=>"administrator",
      "table"=>"tbl_users_type",
      "permissions"=>$permissions,
      "lang"=>$lang,
   );
       return view("adminDashboard.administrator.tbl_users_type.ajax.tbl_users_type_form_add",$array);
  }
function  tbl_users_type_insert(Request $request){
  //  proccess 10000004 - confirm insert
   $request->validate(tbl_users_type_model::rules($request)); 
   $data=array(); 
   $data["name"]=  $request->input()["name"] ; 
$data["created_by"]=Auth::user()->id;
$insert = tbl_users_type_model::create($data);
if($insert){
  Session::flash("success_update",  __("public.flashMsg_SuccessInsert"));
     return response()->json(["response" => "inserted"]);
 }else{
   return response()->json(["response" => "error"]); 
 }
}
function tbl_users_type_form_update(Request $request){
  // proccess 100000013 - update form
$id =decrypt($request->input("id"));
$records = tbl_users_type_model::findOrFail($id);
$lang =app()->getLocale();
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
      $permissions = array("update"=>true );
   }else{
      $permissions = array( "update"=> Permission::CheckPermission(2,"tbl_users_type") ); 
   }



$array = array(
              "folderName"=>"settings",
              "table"=>"employees",
              "records"=>$records ,
              "permissions"=>$permissions,
              "lang"=>$lang,
);

    return view("adminDashboard.administrator.tbl_users_type.ajax.tbl_users_type_form_update",$array);
}
function  tbl_users_type_update(Request $request){
  // proccess 1000000266
  $administrator_tbl_users_type = tbl_users_type_model::findOrFail(  decrypt($request->input("id")) );
  $oldData = $administrator_tbl_users_type->getOriginal();
  //$request->validate(tbl_users_type_model::rules());;
  $data = array();
  $data["name"]= $request->input()["name"] ; 
  $data["updated_by"]=Auth::user()["id"];
  $data["updated_at"]=date("Y-m-d H:i:s" );
  $updated = tbl_users_type_model::where("id","=", decrypt($request->input("id")) )->update($data);
  if($updated){ 
  $newData = $data;
  activity("tbl_users_type")
  ->performedOn($administrator_tbl_users_type)
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
         
         
         
 /****************End Table (tbl_users_type) Functionality******************/
         
         
         
  
  
 }
