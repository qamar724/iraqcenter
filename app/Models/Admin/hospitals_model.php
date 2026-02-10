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
class hospitals_model extends Model
 {
  use LogsActivity;
  protected static $logName = "hospitals";
  public $table ="hospitals";
  protected $fillable = [
  "id", 
  "name", 
  "phone", 
  "email", 
  "city_id", 
  "created_by",
  "created_at",
  "updated_at",
  "updated_by",
  ];
  public static function rules($request){
    //proccess 1000050
 $request["city_id"]  = decrypt($request["city_id"]);
     return [
         "name"=>["required","string"],
         "phone"=>["required","string"],
         "email"=>["required","string"],
         "city_id"=>["exists:city,id","required","int"],
            ];
  }
  public function getActivitylogOptions(): LogOptions
  {
     return LogOptions::defaults()->useLogName("hospitals")->logOnly(["*"]);
  }
} 
