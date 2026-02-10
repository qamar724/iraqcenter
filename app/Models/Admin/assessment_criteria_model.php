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
class assessment_criteria_model extends Model
 {
  use LogsActivity;
  protected static $logName = "assessment_criteria";
  public $table ="assessment_criteria";
  protected $fillable = [
  "id", 
  "monthly_evaluation_forms_id", 
  "question", 
  "created_by",
  "created_at",
  "updated_at",
  "updated_by",
  ];
  public static function rules($request){
    //proccess 1000050
 $request["monthly_evaluation_forms_id"]  = decrypt($request["monthly_evaluation_forms_id"]);
     return [
         "monthly_evaluation_forms_id"=>["exists:monthly_evaluation_forms,id","required","int"],
         "question"=>["required","string"],
            ];
  }
  public function getActivitylogOptions(): LogOptions
  {
     return LogOptions::defaults()->useLogName("assessment_criteria")->logOnly(["*"]);
  }
} 
