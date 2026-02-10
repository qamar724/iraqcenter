<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Cookies;  
use Illuminate\Contracts\Validation\Rule;  
use Illuminate\Support\Facades\Validator;  
use Spatie\Activitylog\Traits\LogsActivity;  
use Spatie\Activitylog\LogOptions;    
//7878454545  
class activitylog_model extends Model
 {
  use LogsActivity;
  protected static $logName = "activity_log";
  public $table ="activity_log";
  protected $fillable = [
  "id", 
  "log_name", 
  "description", 
  "subject_type", 
  "causer_id",
  "causer_type", 
  "properties", 
  "created_by",
  "created_at",
  "updated_at",
  "updated_by",
  ];
  public static function rules(){
    //proccess 1000050
     return [
         "log_name"=>["required","string"],
         "description"=>["required","string"],
         "subject_type"=>["required","string"],
         "causer_type"=>["required","string"],
         "properties"=>["required","string"],
            ];
  }
  public function getActivitylogOptions(): LogOptions
  {
    $logOptions = new LogOptions();
    // Customize the log name as needed
    $logOptions->logName = $this->logName;
    // Add other options here using $logOptions
    return $logOptions;
  }
} 
