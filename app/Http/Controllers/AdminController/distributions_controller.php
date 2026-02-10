<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SystemController\Delete;
use App\Http\Controllers\SystemController\Permission;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\distributions_model;
use App\Models\Admin\users_model;
use App\Models\Admin\hospitals_model;
use App\Models\Admin\hospitals_has_specialties_model;
use App\Models\Admin\status_model;
use App\Http\Controllers\AdminController\UserAuthController;

class distributions_controller extends Controller
{
 /*  
  This controller has been generated Automatically by generatesystems.com  
  */
  /**************Start Table (distributions) Functionality **************/
  function index(Request $request)
  {
    //  proccess 100000075
    $lang = app()->getLocale();
    $host = request()->getHttpHost();
    $hostUrl = "https://" . $host . "/uploads/documents/";
    $data = distributions_model::select(
    "distributions.id   AS  id",
    "users.name    AS  users_id_name",
    "distributions.users_id   AS  users_id",
    "hospitals.name    AS  hospitals_id_name",
    "distributions.hospitals_id   AS  hospitals_id",
    "hospitals_has_specialties.specialties_id    AS  hospitals_has_specialties_id_specialties_id",
    "specialties.name_$lang    AS  specialties_name",
    "distributions.hospitals_has_specialties_id   AS  hospitals_has_specialties_id",
    "status.name_$lang    AS  status_id_name_en",
    "distributions.status_id   AS  status_id"
)
->join('users as users', 'distributions.users_id', '=', 'users.id')
->join('hospitals as hospitals', 'distributions.hospitals_id', '=', 'hospitals.id')
->join('hospitals_has_specialties as hospitals_has_specialties', 'distributions.hospitals_has_specialties_id', '=', 'hospitals_has_specialties.id')
->join('specialties', 'hospitals_has_specialties.specialties_id', '=', 'specialties.id')
->join('status as status', 'distributions.status_id', '=', 'status.id');
    /***********This area refer to search and paginate  ****************/
    /******************** Dont modify this code ************************/
    if (count($request->input()) >= 1) {
      foreach ($request->input() as $key => $value) {
        if ($key != "_token" || $key != "page") {
          if (strpos($key, "key_") !== false) {
            $exp_key = explode("key_", $key);
            $exp_key = $exp_key[1];
            $value = decrypt($value);
            if ($value != null && $value != ""  && $value > 0) {
              $data = $data->where("distributions.$exp_key", "=", $value);
            }
          }
          if (strpos($key, "id_") !== false) {
            $exp_key = explode("id_", $key);
            $exp_key = $exp_key[1];
            if ($value != null && $value != ""  && $value > 0) {
              if ($exp_key == "from_date" || $exp_key == "to_date") {
                if ($exp_key == "from_date") {
                  $exp_key = "created_at";
                  $value = $value . " 00:00:00";
                  $data = $data->where("distributions.$exp_key", ">=", $value);
                } elseif ($exp_key == "to_date") {
                  $exp_key = "created_at";
                  $value = $value . " 23:59:59";
                  $data = $data->where("distributions.$exp_key", "<=", $value);
                }
              } else {
                $data = $data->where("distributions.$exp_key", "=", $value);
              }
            }
          }
        }
      }
    }
    /********************************************************************/
    $data = $data->where("distributions.is_deleted", "=", 0); // 0 not deleted & 1 is deleted
    if (Auth::user()["tbl_users_type_id"] == 1) { // super admin
      $permissions = array(
        "insertNew" => true,
        "viewPage" => true,
        "delete" => true,
        "update" => true,
      );
    } elseif (Auth::user()["tbl_users_type_id"] == 2) { // administrators
      $permissions = array(
        "viewPage" =>  Permission::CheckPermission(1, "distributions"),
        "update" =>    Permission::CheckPermission(2, "distributions"),
        "insertNew" => Permission::CheckPermission(3, "distributions"),
        "delete" =>    Permission::CheckPermission(4, "distributions"),
      );
    } else {
      $permissions = array(
        "viewPage" =>  Permission::CheckPermission(1, "distributions"),
        "update" =>    Permission::CheckPermission(2, "distributions"),
        "insertNew" => Permission::CheckPermission(3, "distributions"),
        "delete" =>    Permission::CheckPermission(4, "distributions"),
      );
    }
    $pagination = env("PAGINATION");
    if (isset($_COOKIE["distributions_pagination"])) {
      $pagination = $_COOKIE["distributions_pagination"];
    }

    $data = $data->paginate($pagination);
    $layout = "table";
    if (isset($_COOKIE["distributions"])) {
      $layout = $_COOKIE["distributions"];
    }
    /****** foreign key filters start ******/
    $data_users = users_model::where("is_deleted", 0)->where('tbl_users_type_id', 4)->get();
    $data_hospitals = hospitals_model::where("is_deleted", 0)->get();
$data_hospitals_has_specialties = DB::table('hospitals_has_specialties')
    ->join('specialties', 'hospitals_has_specialties.specialties_id', '=', 'specialties.id')
    ->where('hospitals_has_specialties.is_deleted', 0)
    ->select(
        'hospitals_has_specialties.id',
           "specialties.name_{$lang} as specialties_name",  
    )
    ->get();    $data_status = status_model::where("is_deleted", 0)->get();
    /****** foreign key filters end ******/



    $array = array(
      "records" => $data,
      "folderName" => "doctorsdistributions",
      "table" => "distributions",
      "permissions" => $permissions,
      "lang" => $lang,
      "layout" => $layout,
      "pagination" => $pagination,
      "data_users" => $data_users,
      "data_hospitals" => $data_hospitals,
      "data_hospitals_has_specialties" => $data_hospitals_has_specialties,
      "data_status" => $data_status,
    );
    return view("adminDashboard.doctorsdistributions.distributions.distributions", $array);
  }
  function  distributions_delete(Request $request)
  {
    //  proccess 10000008 - delete controller
    if (Auth::user()["tbl_users_type_id"] == 1) {  // Super admin
      $permissions = array("delete" => true);
    } else {
      $permissions = array("delete" => Permission::CheckPermission(4, "distributions"));
    }

    //check if current user has permission
    if ($permissions["delete"] == false) {
      return response()->json(array("response" => "no_permission", "message" => __("public.noPermission_to_delete_record"),));
    }

    $id = decrypt($request->input("id"));
    $table = "distributions";
    $id_name = $table . "_id";
    if (Delete::checkRow($id_name, $id)) {  // this function to check if this record has been related with another tables
      return response()->json(array("response" => "not_allow", "message" => __("public.not_allow_to_delete_record"),));
    } else {
      $distributions = distributions_model::find($id);
      $deleted = distributions_model::where("id", $id)->update(["is_deleted" => 1]);
      if ($deleted) {
        activity("distributions")
          ->performedOn($distributions)
          ->causedBy(Auth::user())
          ->withProperties([
            "attributes" => json_encode($distributions, JSON_UNESCAPED_UNICODE),
          ])
          ->log("deleted");
        return response()->json(array("response" => "deleted", "message" => __("public.success_deleted_record"),));
      }
      return response()->json(array("response" => "error", "message" => __("public.error_server")));
    }
  }
  function  distributions_form_add()
  {
    //  proccess 100000057 -add form
    $lang = app()->getLocale();

    if (Auth::user()["tbl_users_type_id"] == 1) {  // Super admin
      $permissions = array("insertNew" => true);
    } else {
      $permissions = array("insertNew" => Permission::CheckPermission(3, "distributions"));
    }

    /****** foreign key filters start ******/
    $data_users = users_model::where("is_deleted", 0)->where('tbl_users_type_id', 4)->get();
    $data_hospitals = hospitals_model::where("is_deleted", 0)->get();
    $data_status = status_model::where("is_deleted", 0)->get();
    $data_hospitals_has_specialties = DB::table('hospitals_has_specialties')
        ->join('specialties', 'hospitals_has_specialties.specialties_id', '=', 'specialties.id')
        ->where('hospitals_has_specialties.is_deleted', 0)
        ->select(
            'hospitals_has_specialties.id',
           "specialties.name_{$lang} as specialties_name",  
        )
        ->get();
    /****** foreign key filters end ******/
    $array = array(
      "folderName" => "doctorsdistributions",
      "table" => "distributions",
      "permissions" => $permissions,
      "lang" => $lang,
      "data_users" => $data_users,
      "data_hospitals" => $data_hospitals,
      "data_hospitals_has_specialties" => $data_hospitals_has_specialties,
      "data_status" => $data_status,
    );
    return view("adminDashboard.doctorsdistributions.distributions.ajax.distributions_form_add", $array);
  }
  function  distributions_insert(Request $request)
  {
    //  proccess 10000004 - confirm insert
    $request->validate(distributions_model::rules($request));
    
    try {
        DB::beginTransaction();
        
        $users_id = $request->input("users_id");
        $hospitals_id = $request->input("hospitals_id");
        $hospitals_has_specialties_id = $request->input("hospitals_has_specialties_id");
        $status_id = $request->input("status_id");
        
        $existingDistribution = distributions_model::where('users_id', $users_id)
            ->where('hospitals_has_specialties_id', $hospitals_has_specialties_id)
            ->where('is_deleted', 0)
            ->first();
        
        if ($existingDistribution) {
            DB::rollBack();
            
            $lang = app()->getLocale();
            $errorMessage = $lang == 'ar' 
                ? 'هذا الطبيب موزع مسبقاً على هذا التخصص' 
                : 'This doctor is already assigned to this specialty';
            
            return response()->json([
                "response" => "dublicated",
                "errors" => "dublicated",
                "label" => $errorMessage
            ]);
        }
        
        $data = array();
        $data["users_id"] = $users_id;
        $data["hospitals_id"] = $hospitals_id;
        $data["hospitals_has_specialties_id"] = $hospitals_has_specialties_id;
        $data["status_id"] = $status_id;
        $data["created_by"] = Auth::user()->id;
        
        $insert = distributions_model::create($data);
        
        if ($insert) {
            $evaluationData = array(
                "users_id" => $users_id,
                "hospitals_has_specialties_id" => $hospitals_has_specialties_id,
                "created_by" => Auth::user()->id,
                "created_at" => date("Y-m-d H:i:s"),
                "is_deleted" => 0
            );
            
            DB::table('monthly_evaluations')->insert($evaluationData);
            
            DB::commit();
            
            Session::flash("success_update", __("public.flashMsg_SuccessInsert"));
            return response()->json(["response" => "inserted"]);
        } else {
            DB::rollBack();
            return response()->json(["response" => "error"]);
        }
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        \Log::error('Distribution Insert Error: ' . $e->getMessage());
        
        return response()->json([
            "response" => "error",
            "message" => __("public.error_server"),
            "error_details" => $e->getMessage()
        ]);
    }
  }
  function distributions_form_update(Request $request)
  {
    // proccess 100000013 - update form
    $id = decrypt($request->input("id"));
    $records = distributions_model::findOrFail($id);
    $lang = app()->getLocale();
    if (Auth::user()["tbl_users_type_id"] == 1) {  // Super admin
      $permissions = array("update" => true);
    } else {
      $permissions = array("update" => Permission::CheckPermission(2, "distributions"));
    }


    /****** foreign key filters start ******/
    $data_users = users_model::where("is_deleted", 0)->where('tbl_users_type_id', 4)->get();
    $data_hospitals = hospitals_model::where("is_deleted", 0)->get();
    $data_hospitals_has_specialties = hospitals_has_specialties_model::where("is_deleted", 0)->get();
    $data_status = status_model::where("is_deleted", 0)->get();
    $data_hospitals_has_specialties = DB::table('hospitals_has_specialties')
        ->join('specialties', 'hospitals_has_specialties.specialties_id', '=', 'specialties.id')
        ->where('hospitals_has_specialties.is_deleted', 0)
        ->select(
            'hospitals_has_specialties.id',
            "specialties.name_{$lang} as specialties_name",
        )
        ->get();
    /****** foreign key filters end ******/

    $array = array(
      "folderName" => "settings",
      "table" => "employees",
      "records" => $records,
      "permissions" => $permissions,
      "lang" => $lang,
      "data_users" => $data_users,
      "data_hospitals" => $data_hospitals,
      "data_hospitals_has_specialties" => $data_hospitals_has_specialties,
      "data_status" => $data_status,
    );

    return view("adminDashboard.doctorsdistributions.distributions.ajax.distributions_form_update", $array);
  }
  function  distributions_update(Request $request)
  {
    // proccess 1000000266
    try {
        DB::beginTransaction();
        
        $distributionId = decrypt($request->input("id"));
        $users_id = decrypt($request->input("users_id"));
        $hospitals_id = decrypt($request->input("hospitals_id"));
        $hospitals_has_specialties_id = decrypt($request->input("hospitals_has_specialties_id"));
        $status_id = decrypt($request->input("status_id"));
        
        $existingDistribution = distributions_model::where('users_id', $users_id)
            ->where('hospitals_has_specialties_id', $hospitals_has_specialties_id)
            ->where('id', '!=', $distributionId)
            ->where('is_deleted', 0)
            ->first();
        
        if ($existingDistribution) {
            DB::rollBack();
            
            $lang = app()->getLocale();
            $errorMessage = $lang == 'ar' 
                ? 'هذا الطبيب موزع مسبقاً على هذا التخصص' 
                : 'This doctor is already assigned to this specialty';
            
            return response()->json([
                "response" => "dublicated",
                "dublicateField" => $lang == 'ar' ? 'الطبيب - التخصص' : 'Doctor - Specialty'
            ]);
        }
        
        $doctorsdistributions_distributions = distributions_model::findOrFail($distributionId);
        $oldData = $doctorsdistributions_distributions->getOriginal();
        
        $data = array();
        $data["users_id"] = $users_id;
        $data["hospitals_id"] = $hospitals_id;
        $data["hospitals_has_specialties_id"] = $hospitals_has_specialties_id;
        $data["status_id"] = $status_id;
        $data["updated_by"] = Auth::user()["id"];
        $data["updated_at"] = date("Y-m-d H:i:s");
        
        $updated = distributions_model::where("id", "=", $distributionId)->update($data);
        
        if ($updated) {
            $existingEvaluation = DB::table('monthly_evaluations')
                ->where('users_id', $data["users_id"])
                ->where('hospitals_has_specialties_id', $data["hospitals_has_specialties_id"])
                ->where('is_deleted', 0)
                ->first();
            
            if ($existingEvaluation) {
                DB::table('monthly_evaluations')
                    ->where('id', $existingEvaluation->id)
                    ->update([
                        "updated_by" => Auth::user()["id"],
                        "updated_at" => date("Y-m-d H:i:s")
                    ]);
            } else {
                $evaluationData = array(
                    "users_id" => $data["users_id"],
                    "hospitals_has_specialties_id" => $data["hospitals_has_specialties_id"],
                    "created_by" => Auth::user()->id,
                    "created_at" => date("Y-m-d H:i:s"),
                    "is_deleted" => 0
                );
                
                DB::table('monthly_evaluations')->insert($evaluationData);
            }
            
            DB::commit();
            
            $newData = $data;
            activity("distributions")
                ->performedOn($doctorsdistributions_distributions)
                ->causedBy(Auth::user())
                ->withProperties([
                    "old" => $oldData,
                    "attributes" => $newData,
                ])
                ->log("updated");
                
            Session::flash("success_update", __("public.flashMsg_SuccessUpdate"));
            return response()->json(array("response" => "updated"));
        } else {
            DB::rollBack();
            return response()->json(array("response" => "error"));
        }
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        \Log::error('Distribution Update Error: ' . $e->getMessage());
        
        return response()->json([
            "response" => "error",
            "message" => __("public.error_server"),
            "error_details" => $e->getMessage()
        ]);
    }
  }



  function distributions_get_hospitals_has_specialties_by_hospitals_id()
  {
      $lang = app()->getLocale();
    // PROCCESS 30002155
    return view("adminDashboard.doctorsdistributions.distributions.ajax.distributions_get_hospitals_has_specialties_by_hospitals_id", compact("lang"));
  }
  /****************End Table (distributions) Functionality******************/
}