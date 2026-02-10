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
use App\Models\Admin\activitylog_model;
use App\Http\Controllers\AdminController\UserAuthController;
class activitylog_controller extends Controller
{
 /*  
  This controller has been generated Automatically by generatesystems.com  
  */ 
/**************Start Table (activity_log) Functionality **************/
function index(Request $request)
  {
  //  proccess 100000075
  $lang =app()->getLocale();   
  $host = request()->getHttpHost();   
  $hostUrl = "https://".$host."/uploads/documents/";  
  $data = activitylog_model::select(    
                  "activity_log.id   AS  id",
                  "activity_log.log_name   AS  log_name",
                  "activity_log.description   AS  description",
                  "activity_log.subject_type   AS  subject_type",
                  "activity_log.causer_type   AS  causer_type",
                  "activity_log.properties   AS  properties",
                  "activity_log.causer_id as byUser" ,
                  "activity_log.created_at as created_at" ,
                  "users.name as user_name"
                   )
                   ->join ( 'users as users' ,'users.id', '=', 'activity_log.causer_id'  )
                
                   ->orderBy("activity_log.id", "DESC")
                   ;

/***********This area refer to search and paginate  ****************/
/******************** Dont modify this code ************************/
if (count($request->input()) >=1) {
   foreach ($request->input() as $key=>$value) {
       if ($key != "_token" || $key !="page") {
           if (strpos($key, "key_") !== false) {
               $exp_key = explode("key_", $key);
               $exp_key = $exp_key[1];
               if ($value != null && $value != ""  && $value > 0) {
                    $data=$data->where("activity_log.$exp_key", "=", $value) ;
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
                    $data=$data->where("activity_log.$exp_key", ">=", $value) ; 
                  }elseif($exp_key =="to_date"){ 
                    $exp_key = "created_at"; 
                    $value = $value." 23:59:59"; 
                    $data=$data->where("activity_log.$exp_key", "<=", $value) ; 
                  } 
                }else{ 
                  $data=$data->where("activity_log.$exp_key", "=", $value) ; 
                } 
 
               }
           }
       }
   }
}
 /********************************************************************/
 
        if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
            $permissions = array(
                                 "insertNew"=>true,
                                 "viewPage"=>true,
                                 "delete"=>true,
                                 "update"=>true,
                                 );
           } else {     
            $permissions = array(
                                 "viewPage"=>  Permission::CheckPermission(1,"activity_log"),
                                 "update"=>    Permission::CheckPermission(2,"activity_log"),
                                 "insertNew"=> Permission::CheckPermission(3,"activity_log"),
                                 "delete"=>    Permission::CheckPermission(4,"activity_log"),
                                 );
   } 
   
 $data=$data->paginate(100);
       $array = array(
                     "records"=>$data,
                     "folderName"=>"administrator",
                     "table"=>"activity_log",
                     "permissions"=>$permissions,
                     "lang"=>$lang,
                    );
    return view("adminDashboard.administrator.activitylog.activitylog" ,$array);
  }

   //  proccess 10000006
 function logsystem_details(){
  return view("adminDashboard.administrator.activitylog.ajax.activitylog_details");
}
 
         
  
  
 }
