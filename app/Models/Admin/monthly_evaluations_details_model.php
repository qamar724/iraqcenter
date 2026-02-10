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
class monthly_evaluations_details_model extends Model
 {
  use LogsActivity;
  protected static $logName = "monthly_evaluations_details";
  public $table ="monthly_evaluations_details";
  public $timestamps = false;
  
  protected $fillable = [
  "id", 
  "monthly_evaluations_id",
  "monthly_evaluation_forms_id",
  "cbd_title",
  "procedure_name",
  "procedure_list_id",
  "procedure_name_other",
  "clinical_problem",
  "assessor_comments",
  "feedback_discussion", 
  "feedback", 
  "aspects", 
  "suggested", 
  "able_perform_procedure", 
  "unable_perform_procedure", 
  "trained_and_competent", 
  "able_perform_procedure_limited", 
  "competent_perform_procedure_unsupervised", 
  "agree_action_plan",
  // Mini-CEX specific fields (7 columns)
  "minicex_observing_mins",
  "minicex_feedback_mins",
  "complexity_low",
  "complexity_moderate",
  "complexity_high",
  "not_competent",
  "competent",
  "is_deleted",
  "created_by",
  "created_at",
  "updated_at",
  "updated_by",
  ];
  public static function rules($request){
    //proccess 1000050
 $request["monthly_evaluations_id"]  = decrypt($request["monthly_evaluations_id"]);
 $request["assessment_criteria_id"]  = decrypt($request["assessment_criteria_id"]);
     return [
         "monthly_evaluations_id"=>["exists:monthly_evaluations,id","required","int"],
         "assessment_criteria_id"=>["exists:assessment_criteria,id","required","int"],
         "n_a"=>["nullable","int"],
         "below_standard"=>["nullable","int"],
         "meets_standard"=>["nullable","int"],
         "above_standard"=>["nullable","int"],
         "feedback_discussion"=>["nullable","string"],
         "feedback"=>["nullable","string"],
         "aspects"=>["nullable","string"],
         "suggested"=>["nullable","string"],
         "able_perform_procedure"=>["nullable","int"],
         "unable_perform_procedure"=>["nullable","int"],
         "trained_and_competent"=>["nullable","int"],
         "able_perform_procedure_limited"=>["nullable","int"],
         "competent_perform_procedure_unsupervised"=>["nullable","int"],
         "agree_action_plan"=>["nullable","string"],
            ];
  }
  public function getActivitylogOptions(): LogOptions
  {
     return LogOptions::defaults()->useLogName("monthly_evaluations_details")->logOnly(["*"]);
  }
} 
