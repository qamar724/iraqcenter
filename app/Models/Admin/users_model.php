<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Cookies;  
use Illuminate\Contracts\Validation\Rule;  
use Spatie\Activitylog\Traits\LogsActivity;  
use Spatie\Activitylog\LogOptions;  
//7878454545  
class users_model extends Model
 {
  use LogsActivity;
  protected static $logName = "users";
  public $table ="users";
  protected $fillable = [
  "id", 
  "name", 
  "email", 
  "profile_photo_path", 
  "tbl_users_type_id", 
  "phone", 
  "genders_id", 
  "city_id", 
  "specialties_id", 
  "hospitals_id", 
  "tbl_users_type_id", 
  "active_status_id", 
  "password",
  "created_by",
  "created_at",
  "updated_at",
  "updated_by",
  ];
  public static function rules($request){
    //proccess 1000050
 $request["tbl_users_type_id"]  = decrypt($request["tbl_users_type_id"]);
 $request["genders_id"]  = decrypt($request["genders_id"]);
 $request["city_id"]  = decrypt($request["city_id"]);
 $request["specialties_id"]  = decrypt($request["specialties_id"]);
 $request["hospitals_id"]  = decrypt($request["hospitals_id"]);
     return [
         "name"=>["required","string"],
         "email"=>["required","string"],
         "profile_photo_path"=>["nullable","mimes:bmp,jpg,jpeg,gif,png","max:50000"],
         "tbl_users_type_id"=>["exists:tbl_users_type,id","required","int"],
         "phone"=>["required","string"],
         "genders_id"=>["exists:genders,id","required","int"],
         "city_id"=>["exists:city,id","nullable","int"],
         "specialties_id"=>["exists:specialties,id","nullable","int"],
         "hospitals_id"=>["exists:hospitals,id","nullable","int"],
            ];
  }
  public function getActivitylogOptions(): LogOptions
  {
     return LogOptions::defaults()->useLogName("users")->logOnly(["*"]);
  }
} 
