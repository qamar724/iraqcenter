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
class distributions_model extends Model
 {
  use LogsActivity;
  protected static $logName = "distributions";
  public $table ="distributions";
  protected $fillable = [
  "id", 
  "users_id", 
  "hospitals_id", 
  "hospitals_has_specialties_id", 
  "status_id", 
  "created_by",
  "created_at",
  "updated_at",
  "updated_by",
  ];
  public static function rules($request){
    //proccess 1000050
 $request["users_id"]  = decrypt($request["users_id"]);
 $request["hospitals_id"]  = decrypt($request["hospitals_id"]);
 $request["hospitals_has_specialties_id"]  = decrypt($request["hospitals_has_specialties_id"]);
 $request["status_id"]  = decrypt($request["status_id"]);
     return [
         "users_id"=>["exists:users,id","required","int"],
         "hospitals_id"=>["exists:hospitals,id","required","int"],
         "hospitals_has_specialties_id"=>["exists:hospitals_has_specialties,id","required","int"],
         "status_id"=>["exists:status,id","required","int"],
            ];
  }
  public function getActivitylogOptions(): LogOptions
  {
     return LogOptions::defaults()->useLogName("distributions")->logOnly(["*"]);
  }
} 
