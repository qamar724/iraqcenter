<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Cookies;  
use Illuminate\Contracts\Validation\Rule;  
use Spatie\Activitylog\Traits\LogsActivity;  
use Spatie\Activitylog\LogOptions;  

class category_procedure_model extends Model
 {
  use LogsActivity;
  protected static $logName = "category_procedure";
  public $table ="category_procedure";
  protected $fillable = [
  "id", 
  "name", 
  "created_by",
  "created_at",
  "updated_at",
  "updated_by",
  ];
  public static function rules($request){
     return [
         "name"=>["required","string"],
            ];
  }
  public function getActivitylogOptions(): LogOptions
  {
     return LogOptions::defaults()->useLogName("category_procedure")->logOnly(["*"]);
  }
} 
