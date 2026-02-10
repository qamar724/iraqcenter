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
class monthly_evaluations_answers_model extends Model
{
  use LogsActivity;
  protected static $logName = "monthly_evaluations_answers";
  public $table = "monthly_evaluations_answers";
  public $timestamps = false;
  
  protected $fillable = [
    "id", 
    "monthly_evaluations_details_id", 
    "assessment_criteria_id",
    "n_a", 
    "below_standard", 
    "meets_standard", 
    "above_standard",
  ];
  
  public static function rules($request){
    return [
      "monthly_evaluations_details_id"=>["required","int"],
      "assessment_criteria_id"=>["required","int"],
      "n_a"=>["nullable","int"],
      "below_standard"=>["nullable","int"],
      "meets_standard"=>["nullable","int"],
      "above_standard"=>["nullable","int"],
    ];
  }
  
  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()->useLogName("monthly_evaluations_answers")->logOnly(["*"]);
  }
}
