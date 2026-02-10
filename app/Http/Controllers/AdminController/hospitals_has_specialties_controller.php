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
use App\Models\Admin\hospitals_has_specialties_model;
use App\Models\Admin\specialties_model;
use App\Models\Admin\hospitals_model;
use App\Http\Controllers\AdminController\UserAuthController;
class hospitals_has_specialties_controller extends Controller
{
 /*  
  This controller has been generated Automatically by generatesystems.com  
  */ 
/**************Start Table (hospitals_has_specialties) Functionality **************/
 
 public static function checkDuplicate_hospitals_has_specialties($hospitals_id,$specialties_id){
 
  //  proccess 100000012
 $data = array( 
 "hospitals_id"=> $hospitals_id,
 "specialties_id"=> $specialties_id
 ); 
 $records = DB::table("hospitals_has_specialties")->where($data)->get(); 
  if( count($records) > 0){
    // found data
    return true;
   }
  return false;
 }
function index(Request $request)
  {
  //  proccess 100000075
  $lang =app()->getLocale();   
  $host = request()->getHttpHost();   
  $hostUrl = "https://".$host."/uploads/documents/";  
  $data = hospitals_has_specialties_model::select(    
                  "hospitals_has_specialties.id   AS  id",
                  "specialties.name_$lang    AS  specialties_id_name_en",
                  "hospitals_has_specialties.specialties_id   AS  specialties_id",
                  "hospitals.name    AS  hospitals_id_name",
                  "hospitals_has_specialties.hospitals_id   AS  hospitals_id"
                   )
                 ->join ( 'specialties as specialties' ,'hospitals_has_specialties.specialties_id', '=', 'specialties.id'  )
                 ->join ( 'hospitals as hospitals' ,'hospitals_has_specialties.hospitals_id', '=', 'hospitals.id'  )
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
                    $data=$data->where("hospitals_has_specialties.$exp_key", "=", $value) ;
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
                    $data=$data->where("hospitals_has_specialties.$exp_key", ">=", $value) ; 
                  }elseif($exp_key =="to_date"){ 
                    $exp_key = "created_at"; 
                    $value = $value." 23:59:59"; 
                    $data=$data->where("hospitals_has_specialties.$exp_key", "<=", $value) ; 
                  } 
                }else{ 
                  $data=$data->where("hospitals_has_specialties.$exp_key", "=", $value) ; 
                } 
 
               }
           }
       }
   }
}
 /********************************************************************/
 $data=$data->where("hospitals_has_specialties.is_deleted","=",0);// 0 not deleted & 1 is deleted
if (Auth::user()["tbl_users_type_id"] ==1) { // super admin
    $permissions = array(
                         "insertNew"=>true,
                         "viewPage"=>true,
                         "delete"=>true,
                         "update"=>true,
                         );
} elseif(Auth::user()["tbl_users_type_id"] ==2){ // administrators
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"hospitals_has_specialties"),
      "update"=>    Permission::CheckPermission(2,"hospitals_has_specialties"),
      "insertNew"=> Permission::CheckPermission(3,"hospitals_has_specialties"),
      "delete"=>    Permission::CheckPermission(4,"hospitals_has_specialties"),
      );
}else {     
    $permissions = array(
      "viewPage"=>  Permission::CheckPermission(1,"hospitals_has_specialties"),
      "update"=>    Permission::CheckPermission(2,"hospitals_has_specialties"),
      "insertNew"=> Permission::CheckPermission(3,"hospitals_has_specialties"),
      "delete"=>    Permission::CheckPermission(4,"hospitals_has_specialties"),
      );
} 
  $pagination= env("PAGINATION");
  if (isset($_COOKIE["hospitals_has_specialties_pagination"])) {
    $pagination = $_COOKIE["hospitals_has_specialties_pagination"];
  }
  
 $data=$data->paginate($pagination);
 $layout ="table";
  if (isset($_COOKIE["hospitals_has_specialties"])) { 
    $layout = $_COOKIE["hospitals_has_specialties"];
  }
 /****** foreign key filters start ******/ 
      $data_specialties = specialties_model::where("is_deleted",0)->get(); 
      $data_hospitals = hospitals_model::where("is_deleted",0)->get(); 
 /****** foreign key filters end ******/ 
  
  
  
       $array = array(
                     "records"=>$data,
                     "folderName"=>"settings",
                     "table"=>"hospitals_has_specialties",
                     "permissions"=>$permissions,
                     "lang"=>$lang,
                     "layout"=>$layout,
                     "pagination"=>$pagination,
                     "data_specialties"=>$data_specialties,
                     "data_hospitals"=>$data_hospitals,
                    );
    return view("adminDashboard.settings.hospitals_has_specialties.hospitals_has_specialties" ,$array);
  }
function  hospitals_has_specialties_delete(Request $request){
  //  proccess 10000008 - delete controller
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
   $permissions = array( "delete"=>true   );
   }else{
   $permissions = array( "delete"=> Permission::CheckPermission(4,"hospitals_has_specialties")); 
  }
  
  //check if current user has permission
  if($permissions["delete"] == false){
      return response()->json(array("response"=>"no_permission","message"=> __("public.noPermission_to_delete_record"),));
   }
  
 $id=decrypt($request->input("id"));
 $table="hospitals_has_specialties";
 $id_name = $table . "_id";
 if(Delete::checkRow($id_name,$id)){  // this function to check if this record has been related with another tables
      return response()->json( array("response"=>"not_allow","message"=> __("public.not_allow_to_delete_record"),) );
 }else{
$hospitals_has_specialties = hospitals_has_specialties_model::find($id);
$deleted = hospitals_has_specialties_model::where("id", $id)->update(["is_deleted" => 1]);
    if($deleted){                    
    activity("hospitals_has_specialties") 
    ->performedOn($hospitals_has_specialties) 
    ->causedBy(Auth::user()) 
    ->withProperties([ 
      "attributes" => json_encode($hospitals_has_specialties, JSON_UNESCAPED_UNICODE), 
    ]) 
    ->log("deleted"); 
      return response()->json(  array("response"=>"deleted","message"=> __("public.success_deleted_record"),) );    
                       
  } 
      return response()->json(array("response"=>"error", "message"=> __("public.error_server")));  
  }
}
function  hospitals_has_specialties_form_add(){
  //  proccess 100000057 -add form
   $lang =app()->getLocale();
   
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
    $permissions = array( "insertNew"=>true   );
   }else{
    $permissions = array( "insertNew"=> Permission::CheckPermission(3,"hospitals_has_specialties")); 
   }
   
 /****** foreign key filters start ******/ 
      $data_specialties = specialties_model::where("is_deleted",0)->get(); 
      $data_hospitals = hospitals_model::where("is_deleted",0)->get(); 
 /****** foreign key filters end ******/ 
   $array = array(
      "folderName"=>"settings",
      "table"=>"hospitals_has_specialties",
      "permissions"=>$permissions,
      "lang"=>$lang,
      "data_specialties"=>$data_specialties,
      "data_hospitals"=>$data_hospitals,
   );
       return view("adminDashboard.settings.hospitals_has_specialties.ajax.hospitals_has_specialties_form_add",$array);
  }
function  hospitals_has_specialties_insert(Request $request){
  //  proccess 10000004 - confirm insert
   $request->validate(hospitals_has_specialties_model::rules($request)); 
   $data=array(); 
   $data["specialties_id"]=  $request->input()["specialties_id"] ; 
   $data["hospitals_id"]=  $request->input()["hospitals_id"] ; 
 if(self::checkDuplicate_hospitals_has_specialties($request->input("hospitals_id"),$request->input("specialties_id") )){                        
    $arr = array("errors"=>"dublicated","label"=>__("public.duplicated_field"));
     return response()->json($arr);
 }else{
     $data["created_by"]=Auth::user()["id"];
     $insert = hospitals_has_specialties_model::create($data);
     if($insert){
      Session::flash("success_update",  __("public.flashMsg_SuccessInsert"));
       return response()->json(["response" => "inserted"]);
     }else{
     return response()->json(["response" => "error"]);
   }
   }
}
function hospitals_has_specialties_form_update(Request $request){
  // proccess 100000013 - update form
$id =decrypt($request->input("id"));
$records = hospitals_has_specialties_model::findOrFail($id);
$lang =app()->getLocale();
   if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
      $permissions = array("update"=>true );
   }else{
      $permissions = array( "update"=> Permission::CheckPermission(2,"hospitals_has_specialties") ); 
   }


 /****** foreign key filters start ******/ 
      $data_specialties = specialties_model::where("is_deleted",0)->get(); 
      $data_hospitals = hospitals_model::where("is_deleted",0)->get(); 
 /****** foreign key filters end ******/ 

$array = array(
              "folderName"=>"settings",
              "table"=>"employees",
              "records"=>$records ,
              "permissions"=>$permissions,
              "lang"=>$lang,
              "data_specialties"=>$data_specialties,
              "data_hospitals"=>$data_hospitals,
);

    return view("adminDashboard.settings.hospitals_has_specialties.ajax.hospitals_has_specialties_form_update",$array);
}
function  hospitals_has_specialties_update(Request $request){
  // proccess 1000000266
  $settings_hospitals_has_specialties = hospitals_has_specialties_model::findOrFail(  decrypt($request->input("id")) );
  $oldData = $settings_hospitals_has_specialties->getOriginal();
  //$request->validate(hospitals_has_specialties_model::rules());;
  $data = array();
    $data["specialties_id"]= decrypt($request->input()["specialties_id"]) ; 
    $data["hospitals_id"]= decrypt($request->input()["hospitals_id"]) ; 
  $data["updated_by"]=Auth::user()["id"];
  $data["updated_at"]=date("Y-m-d H:i:s" );
  $updated = hospitals_has_specialties_model::where("id","=", decrypt($request->input("id")) )->update($data);
  if($updated){ 
  $newData = $data;
  activity("hospitals_has_specialties")
  ->performedOn($settings_hospitals_has_specialties)
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
         
         
         
 /****************End Table (hospitals_has_specialties) Functionality******************/
         
         
         
  
  
 }
