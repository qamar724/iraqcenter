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
class genders_model extends Model
 {
  use LogsActivity;
  protected static $logName = "genders";
  public $table ="genders";
  protected $fillable = [
  "id", 
  "name_en", 
  "name_ar", 
  "created_by",
  "created_at",
  "updated_at",
  "updated_by",
  ];
  public static function rules($request){
    //proccess 1000050
     return [
         "name_en"=>["required","string"],
         "name_ar"=>["required","string"],
            ];
  }
  public function getActivitylogOptions(): LogOptions
  {
     return LogOptions::defaults()->useLogName("genders")->logOnly(["*"]);
  }
} 
