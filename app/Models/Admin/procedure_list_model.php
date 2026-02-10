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
class procedure_list_model extends Model
 {
  use LogsActivity;
  protected static $logName = "procedure_list";
  public $table ="procedure_list";
  protected $fillable = [
  "id", 
  "name", 
  "category_procedure_id", 
  "created_by",
  "created_at",
  "updated_at",
  "updated_by",
  ];
  public static function rules($request){
    //proccess 1000050
     return [
         "name"=>["required","string"],
         "category_procedure_id"=>[
             "nullable",
             function ($attribute, $value, $fail) {
                 if (is_null($value) || $value === "") {
                     return;
                 }
                 try {
                     $id = decrypt($value);
                     if ($id <= 0) {
                         $fail(__("public.select"));
                     }
                 } catch (\Exception $e) {
                     $fail(__("public.select"));
                 }
             },
         ],
            ];
  }
  public function getActivitylogOptions(): LogOptions
  {
     return LogOptions::defaults()->useLogName("procedure_list")->logOnly(["*"]);
  }
} 
