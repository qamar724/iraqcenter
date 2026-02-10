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
use App\Models\Admin\users_model;
use App\Models\Admin\tbl_users_type_model;
use App\Models\Admin\genders_model;
use App\Models\Admin\city_model;
use App\Models\Admin\specialties_model;
use App\Models\Admin\hospitals_model;
use App\Http\Controllers\AdminController\UserAuthController;
class users_controller extends Controller
{
 /*  
  This controller has been generated Automatically by generatesystems.com  
  */ 
/**************Start Table (users) Functionality **************/
function index(Request $request)
  {
  //  proccess 100000075
  $lang =app()->getLocale();   
  $host = request()->getHttpHost();   
  $hostUrl = "https://".$host."/uploads/documents/";  
  $data = users_model::select(    
"users.active_status_id AS active_status_id",
"users.tbl_users_type_id AS tbl_users_type_id",
                  "users.id   AS  id",
                  "users.name   AS  name",
                  "users.email   AS  email",
                  "users.profile_photo_path   AS  profile_photo_path",
                  DB::raw("concat('$hostUrl',users.profile_photo_path)   AS  profile_photo_path_url"),
                  "tbl_users_type.name    AS  tbl_users_type_id_name",
                  "users.tbl_users_type_id   AS  tbl_users_type_id",
                  "users.phone   AS  phone",
                  "genders.name_$lang    AS  genders_id_name_en",
                  "users.genders_id   AS  genders_id",
                  "city.name_$lang    AS  city_id_name_en",
                  "users.city_id   AS  city_id",
                  "specialties.name_$lang    AS  specialties_id_name_en",
                  "users.specialties_id   AS  specialties_id",
                  "hospitals.name    AS  hospitals_id_name",
                  "users.hospitals_id   AS  hospitals_id"
                   )
                 ->join ( 'tbl_users_type as tbl_users_type' ,'users.tbl_users_type_id', '=', 'tbl_users_type.id'  )
                 ->leftjoin ( 'genders as genders' ,'users.genders_id', '=', 'genders.id'  )
                 ->leftjoin ( 'city as city' ,'users.city_id', '=', 'city.id'  )
                 ->leftjoin ( 'specialties as specialties' ,'users.specialties_id', '=', 'specialties.id'  )
                 ->leftjoin ( 'hospitals as hospitals' ,'users.hospitals_id', '=', 'hospitals.id'  )
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
                    $data=$data->where("users.$exp_key", "=", $value) ;
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
                    $data=$data->where("users.$exp_key", ">=", $value) ; 
                  }elseif($exp_key =="to_date"){ 
                    $exp_key = "created_at"; 
                    $value = $value." 23:59:59"; 
                    $data=$data->where("users.$exp_key", "<=", $value) ; 
                  } 
                }else{ 
                  $data=$data->where("users.$exp_key", "=", $value) ; 
                } 
 
               }
           }
       }
   }
}
 /********************************************************************/
 $data=$data->where("users.is_deleted","=",0)
 ->where("users.tbl_users_type_id", "<>", 4);;// 0 not deleted & 1 is deleted
if (Auth::user()["tbl_users_type_id"] ==1) { // super admin
    $permissions = array(
                         "insertNew"=>true,
                         "viewPage"=>true,
                         "delete"=>true,
                         "update"=>true,
                         );
} elseif(Auth::user()["tbl_users_type_id"] ==2){ // administrators
    $data = $data->orWhere("users.email", Auth::user()["email"]);
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"users"),
      "update"=>    Permission::CheckPermission(2,"users"),
      "insertNew"=> Permission::CheckPermission(3,"users"),
      "delete"=>    Permission::CheckPermission(4,"users"),
      );
}else {     
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"users"),
      "update"=>    Permission::CheckPermission(2,"users"),
      "insertNew"=> Permission::CheckPermission(3,"users"),
      "delete"=>    Permission::CheckPermission(4,"users"),
      );
} 
  $pagination= env("PAGINATION");
  if (isset($_COOKIE["users_pagination"])) {
    $pagination = $_COOKIE["users_pagination"];
  }
  
 $data=$data->paginate($pagination);
 $layout ="table";
  if (isset($_COOKIE["users"])) { 
    $layout = $_COOKIE["users"];
  }
 /****** foreign key filters start ******/ 
      $data_tbl_users_type = tbl_users_type_model::where("is_deleted",0)
        ->where("id", "<>", 4)
        ->get(); 
      $data_genders = genders_model::where("is_deleted",0)->get(); 
      $data_city = city_model::where("is_deleted",0)->get(); 
      $data_specialties = specialties_model::where("is_deleted",0)->get(); 
      $data_hospitals = hospitals_model::where("is_deleted",0)->get(); 
 /****** foreign key filters end ******/ 
  
  
  
       $array = array(
                     "records"=>$data,
                     "folderName"=>"administrator",
                     "table"=>"users",
                     "permissions"=>$permissions,
                     "lang"=>$lang,
                     "layout"=>$layout,
                     "pagination"=>$pagination,
                     "data_tbl_users_type"=>$data_tbl_users_type,
                     "data_genders"=>$data_genders,
                     "data_city"=>$data_city,
                     "data_specialties"=>$data_specialties,
                     "data_hospitals"=>$data_hospitals,
                    );
    return view("adminDashboard.administrator.users.users" ,$array);
  }
function  users_delete(Request $request){
  //  proccess 10000008 - delete controller
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
   $permissions = array( "delete"=>true   );
   }else{
   $permissions = array( "delete"=> Permission::CheckPermission(4,"users")); 
  }
  
  //check if current user has permission
  if($permissions["delete"] == false){
      return response()->json(array("response"=>"no_permission","message"=> __("public.noPermission_to_delete_record"),));
   }
  
 $id=decrypt($request->input("id"));
 $table="users";
 $id_name = $table . "_id";
 if(Delete::checkRow($id_name,$id)){  // this function to check if this record has been related with another tables
      return response()->json( array("response"=>"not_allow","message"=> __("public.not_allow_to_delete_record"),) );
 }else{
$users = users_model::find($id);
$deleted = users_model::where("id", $id)->update(["is_deleted" => 1]);
    if($deleted){                    
    activity("users") 
    ->performedOn($users) 
    ->causedBy(Auth::user()) 
    ->withProperties([ 
      "attributes" => json_encode($users, JSON_UNESCAPED_UNICODE), 
    ]) 
    ->log("deleted"); 
      return response()->json(  array("response"=>"deleted","message"=> __("public.success_deleted_record"),) );    
                       
  } 
      return response()->json(array("response"=>"error", "message"=> __("public.error_server")));  
  }
}
function  users_form_add(){
  //  proccess 100000057 -add form
   $lang =app()->getLocale();
   
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
    $permissions = array( "insertNew"=>true   );
   }else{
    $permissions = array( "insertNew"=> Permission::CheckPermission(3,"users")); 
   }
   
 /****** foreign key filters start ******/ 
      $data_tbl_users_type = tbl_users_type_model::where("is_deleted",0)
        ->where("id", "<>", 4)
        ->get(); 
      $data_genders = genders_model::where("is_deleted",0)->get(); 
      $data_city = city_model::where("is_deleted",0)->get(); 
      $data_specialties = specialties_model::where("is_deleted",0)->get(); 
      $data_hospitals = hospitals_model::where("is_deleted",0)->get(); 
 /****** foreign key filters end ******/ 
   $array = array(
      "folderName"=>"administrator",
      "table"=>"users",
      "permissions"=>$permissions,
      "lang"=>$lang,
      "data_tbl_users_type"=>$data_tbl_users_type,
      "data_genders"=>$data_genders,
      "data_city"=>$data_city,
      "data_specialties"=>$data_specialties,
      "data_hospitals"=>$data_hospitals,
   );
       return view("adminDashboard.administrator.users.ajax.users_form_add",$array);
  }
function  users_insert(Request $request){
  //  proccess 10000004 - confirm insert
   $request->validate(users_model::rules($request)); 
   $data=array(); 
   $data["name"]= $request->input()["name"] ; 
   $data["email"]= $request->input()["email"] ; 
   $data["tbl_users_type_id"]=  $request->input()["tbl_users_type_id"]  ; 
   $data["phone"]= $request->input()["phone"] ; 
   $data["genders_id"]=  $request->input()["genders_id"]  ; 
   $data["city_id"]=  $request->input()["city_id"]  ; 
   $data["specialties_id"]=  $request->input()["specialties_id"]  ; 
   $data["hospitals_id"]=  $request->input()["hospitals_id"]  ; 
if ($request->hasFile("profile_photo_path")) {
        $file = $request->file("profile_photo_path");
        $path  = $file->store("documents",["disk" => "uploads"]);
        $data["profile_photo_path"]= $path ; 
    }
  $data["active_status_id"]= 1; 
  $data["password"]=  Hash::make(123456)  ; 
$data["created_by"]=Auth::user()->id;
$insert = users_model::create($data);
if($insert){
  Session::flash("success_update",  __("public.flashMsg_SuccessInsert"));
     return response()->json(["response" => "inserted"]);
 }else{
   return response()->json(["response" => "error"]); 
 }
}
function users_form_update(Request $request){
  // proccess 100000013 - update form
$id =decrypt($request->input("id"));
$records = users_model::findOrFail($id);
$lang =app()->getLocale();
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
      $permissions = array("update"=>true );
   }else{
      $permissions = array( "update"=> Permission::CheckPermission(2,"users") ); 
   }


 /****** foreign key filters start ******/ 
      $data_tbl_users_type = tbl_users_type_model::where("is_deleted",0)
        ->where("id", "<>", 4)
        ->get(); 
      $data_genders = genders_model::where("is_deleted",0)->get(); 
      $data_city = city_model::where("is_deleted",0)->get(); 
      $data_specialties = specialties_model::where("is_deleted",0)->get(); 
      $data_hospitals = hospitals_model::where("is_deleted",0)->get(); 
 /****** foreign key filters end ******/ 

$array = array(
              "folderName"=>"settings",
              "table"=>"employees",
              "records"=>$records ,
              "permissions"=>$permissions,
              "lang"=>$lang,
              "data_tbl_users_type"=>$data_tbl_users_type,
              "data_genders"=>$data_genders,
              "data_city"=>$data_city,
              "data_specialties"=>$data_specialties,
              "data_hospitals"=>$data_hospitals,
);

    return view("adminDashboard.administrator.users.ajax.users_form_update",$array);
}
function  users_update(Request $request){
  // proccess 1000000266
  $administrator_users = users_model::findOrFail(  decrypt($request->input("id")) );
  $oldData = $administrator_users->getOriginal();
  //$request->validate(users_model::rules());;
  $data = array();
  $data["name"]= $request->input()["name"] ; 
  $data["email"]= $request->input()["email"] ; 
  $data["tbl_users_type_id"]= decrypt($request->input()["tbl_users_type_id"]) ; 
  $data["phone"]= $request->input()["phone"] ; 
  $data["genders_id"]= decrypt($request->input()["genders_id"]) ; 
  $data["city_id"]= decrypt($request->input()["city_id"]) ; 
  $data["specialties_id"]= decrypt($request->input()["specialties_id"]) ; 
  $data["hospitals_id"]= decrypt($request->input()["hospitals_id"]) ; 
 if ($request->hasFile("profile_photo_path")) {
    // remove old photo from Storage
     if( $administrator_users->profile_photo_path != ""){
      Storage::disk("uploads")->delete($administrator_users->profile_photo_path);
     }
        $file = $request->file("profile_photo_path");
        $path  = $file->store("documents",["disk" => "uploads"]);
        $data["profile_photo_path"]= $path ; 
                } 
  $data["updated_by"]=Auth::user()["id"];
  $data["updated_at"]=date("Y-m-d H:i:s" );
  $updated = users_model::where("id","=", decrypt($request->input("id")) )->update($data);
  if($updated){ 
  $newData = $data;
  activity("users")
  ->performedOn($administrator_users)
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
         
         
         
 function users_get_hospitals_by_city_id(){ 
 // PROCCESS 30002155
    return view("adminDashboard.administrator.users.ajax.users_get_hospitals_by_city_id"); 
 } 
 /****************End Table (users) Functionality******************/
         
         
         
  
  
 }
