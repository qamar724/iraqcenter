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
class hospitals_has_specialties_model extends Model
 {
  use LogsActivity;
  protected static $logName = "hospitals_has_specialties";
  public $table ="hospitals_has_specialties";
  protected $fillable = [
  "id", 
  "hospitals_id", 
  "specialties_id", 
  "created_by",
  "created_at",
  "updated_at",
  "updated_by",
  ];
  public static function rules($request){
    //proccess 1000050
 $request["hospitals_id"]  = decrypt($request["hospitals_id"]);
 $request["specialties_id"]  = decrypt($request["specialties_id"]);
     return [
         "hospitals_id"=>["exists:hospitals,id","required","int"],
         "specialties_id"=>["exists:specialties,id","required","int"],
            ];
  }
  public function getActivitylogOptions(): LogOptions
  {
     return LogOptions::defaults()->useLogName("hospitals_has_specialties")->logOnly(["*"]);
  }
} 
