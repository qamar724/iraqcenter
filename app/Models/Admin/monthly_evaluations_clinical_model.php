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
class monthly_evaluations_clinical_model extends Model
{
  use LogsActivity;
  protected static $logName = "monthly_evaluations_clinical";
  public $table = "monthly_evaluations_clinical";
  public $timestamps = false;
  
  protected $fillable = [
    "id", 
    "monthly_evaluations_details_id", 
    "clinical_setting_id",
  ];
  
  public static function rules($request){
    return [
      "monthly_evaluations_details_id"=>["required","int"],
      "clinical_setting_id"=>["required","int"],
    ];
  }
  
  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()->useLogName("monthly_evaluations_clinical")->logOnly(["*"]);
  }
}
