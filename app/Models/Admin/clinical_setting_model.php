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
class clinical_setting_model extends Model
 {
  use LogsActivity;
  protected static $logName = "clinical_setting";
  public $table ="clinical_setting";
  protected $fillable = [
  "id", 
  "name", 
  "created_by",
  "created_at",
  "updated_at",
  "updated_by",
  ];
  public static function rules($request){
    //proccess 1000050
     return [
         "name"=>["required","string"],
            ];
  }
  public function getActivitylogOptions(): LogOptions
  {
     return LogOptions::defaults()->useLogName("clinical_setting")->logOnly(["*"]);
  }
} 
