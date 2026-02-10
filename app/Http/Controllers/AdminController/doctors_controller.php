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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin\doctors_model;
use App\Models\Admin\tbl_users_type_model;
use App\Models\Admin\genders_model;
use App\Models\Admin\city_model;
use App\Http\Controllers\AdminController\UserAuthController;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class doctors_controller extends Controller
{
    /*
     This controller has been generated Automatically by generatesystems.com
     */
    /**************Start Table (doctors) Functionality **************/
    public function index(Request $request)
    {
        //  proccess 100000075
        $lang = app()->getLocale();
        $host = request()->getHttpHost();
        $hostUrl = "https://".$host."/uploads/documents/";
        $data = doctors_model::select(
            "users.active_status_id AS active_status_id",
            "users.tbl_users_type_id AS tbl_users_type_id",
            "users.id   AS  id",
            "users.name   AS  name",
            "users.email   AS  email",
            "users.profile_photo_path   AS  profile_photo_path",
            DB::raw("concat('$hostUrl',users.profile_photo_path)   AS  profile_photo_path_url"),
            "tbl_users_type.name    AS  tbl_users_type_id_name",
            "users.tbl_users_type_id   AS  tbl_users_type_id",
            "users.phone   AS  phone",
            "genders.name_$lang    AS  genders_id_name_en",
            "users.genders_id   AS  genders_id",
            "city.name_$lang    AS  city_id_name_en",
            "users.city_id   AS  city_id"
        )
                       ->join('tbl_users_type as tbl_users_type', 'users.tbl_users_type_id', '=', 'tbl_users_type.id')
                       ->leftjoin('genders as genders', 'users.genders_id', '=', 'genders.id')
                       ->leftjoin('city as city', 'users.city_id', '=', 'city.id')
        ;

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
                            $data = $data->where("users.$exp_key", "=", $value) ;
                        }
                    }
                    if (strpos($key, "id_") !== false) {
                        $exp_key = explode("id_", $key);
                        $exp_key = $exp_key[1];
                        if ($value != null && $value != ""  && $value > 0) {
                            if ($exp_key == "from_date" || $exp_key == "to_date") {
                                if ($exp_key == "from_date") {
                                    $exp_key = "created_at";
                                    $value = $value." 00:00:00";
                                    $data = $data->where("users.$exp_key", ">=", $value) ;
                                } elseif ($exp_key == "to_date") {
                                    $exp_key = "created_at";
                                    $value = $value." 23:59:59";
                                    $data = $data->where("users.$exp_key", "<=", $value) ;
                                }
                            } else {
                                $data = $data->where("users.$exp_key", "=", $value) ;
                            }

                        }
                    }
                }
            }
        }
        /********************************************************************/
        $data = $data->where("users.is_deleted", "=", 0)// 0 not deleted & 1 is deleted
                     ->where("users.tbl_users_type_id", "=", 4);
        if (Auth::user()["tbl_users_type_id"] == 1) { // super admin
            $permissions = array(
                                 "importNew" => true,
                                 "viewPage" => true,
                                 "delete" => true,
                                 "update" => true,
                                 );
        } elseif (Auth::user()["tbl_users_type_id"] == 2) { // administrators
            $data = $data->orWhere("users.email", Auth::user()["email"]);
            $permissions = array(
              "viewPage" =>  Permission::CheckPermission(1, "users"),
              "update" =>    Permission::CheckPermission(2, "users"),
              "importNew" => Permission::CheckPermission(3, "users"),
              "delete" =>    Permission::CheckPermission(4, "users"),
              );
        } else {
            $permissions = array(
              "viewPage" =>  Permission::CheckPermission(1, "users"),
              "update" =>    Permission::CheckPermission(2, "users"),
              "importNew" => Permission::CheckPermission(3, "users"),
              "delete" =>    Permission::CheckPermission(4, "users"),
              );
        }
        $pagination = env("PAGINATION");
        if (isset($_COOKIE["users_pagination"])) {
            $pagination = $_COOKIE["users_pagination"];
        }

        $data = $data->paginate($pagination);
        $layout = "table";
        if (isset($_COOKIE["users"])) {
            $layout = $_COOKIE["users"];
        }
        /****** foreign key filters start ******/
        $data_tbl_users_type = tbl_users_type_model::where("is_deleted", 0)->get();
        $data_genders = genders_model::where("is_deleted", 0)->get();
        $data_city = city_model::where("is_deleted", 0)->get();
        /****** foreign key filters end ******/



        $array = array(
                      "records" => $data,
                      "folderName" => "administrator",
                      "table" => "users",
                      "permissions" => $permissions,
                      "lang" => $lang,
                      "layout" => $layout,
                      "pagination" => $pagination,
                      "data_tbl_users_type" => $data_tbl_users_type,
                      "data_genders" => $data_genders,
                      "data_city" => $data_city,
                     );
        return view("adminDashboard.administrator.doctors.doctors", $array);
    }
    public function doctors_delete(Request $request)
    {
        //  proccess 10000008 - delete controller
        if (Auth::user()["tbl_users_type_id"] == 1) {  // Super admin
            $permissions = array( "delete" => true   );
        } else {
            $permissions = array( "delete" => Permission::CheckPermission(4, "users"));
        }

        //check if current user has permission
        if ($permissions["delete"] == false) {
            return response()->json(array("response" => "no_permission","message" => __("public.noPermission_to_delete_record"),));
        }

        $id = decrypt($request->input("id"));
        $table = "users";
        $id_name = $table . "_id";
        if (Delete::checkRow($id_name, $id)) {  // this function to check if this record has been related with another tables
            return response()->json(array("response" => "not_allow","message" => __("public.not_allow_to_delete_record"),));
        } else {
            $doctors = doctors_model::find($id);
            $deleted = doctors_model::where("id", $id)->update(["is_deleted" => 1]);
            if ($deleted) {
                activity("doctors")
                ->performedOn($doctors)
                ->causedBy(Auth::user())
                ->withProperties([
                  "attributes" => json_encode($doctors, JSON_UNESCAPED_UNICODE),
                ])
                ->log("deleted");
                return response()->json(array("response" => "deleted","message" => __("public.success_deleted_record"),));

            }
            return response()->json(array("response" => "error", "message" => __("public.error_server")));
        }
    }
    function  doctors_import_add(){
        //  proccess 100000057 -add form
         $lang =app()->getLocale();

         // permission aligned with import button visibility
         if (Auth::user()["tbl_users_type_id"] ==1) {  // Super admin
          $permissions = array( "insertNew"=>true   );
         }else{
          $permissions = array( "insertNew"=> Permission::CheckPermission(3,"users")); 
         }

         $array = array(
            "folderName" => "administrator",
            "table" => "users",
            "permissions" => $permissions,
            "lang" => $lang,
           );
return view("adminDashboard.administrator.doctors.ajax.doctors_import_add", $array);
        }

        public function doctors_import_sample()
    {
        $samplePath = public_path('samples/doctors_import_sample.csv');
        if (!file_exists($samplePath)) {
            abort(404);
        }
        return response()->download($samplePath, 'doctors_import_sample.csv');
    }

        public function doctors_import(Request $request)
    {
        // handle uploaded excel/csv file for doctors
        if (Auth::user()["tbl_users_type_id"] == 1) {  // Super admin
            $permissions = array("importNew" => true);
        } else {
            $permissions = array("importNew" => Permission::CheckPermission(3, "users"));
        }

        if ($permissions["importNew"] == false) {
            return response()->json(array("response" => "no_permission", "message" => __("public.noPermission")));
        }

        $request->validate([
            // allow common csv mimes some browsers report as text/plain or application/vnd.ms-excel
            "file" => "required|mimes:xlsx,xls,csv,txt|mimetypes:text/plain,text/csv,application/csv,application/vnd.ms-excel,application/octet-stream",
        ]);

        $import = new UsersImport(Auth::id());
        Excel::import($import, $request->file("file"));

        
        $rows = $import->rows ?? collect();
        $errors = [];
        $inserted = 0;
        $successfulRecipients = [];

        foreach ($rows as $index => $row) {
            $rowArray = $row->toArray();

            // resolve gender id from name if given
            $genderId = $rowArray['genders_id'] ?? null;
            if (!$genderId && !empty($rowArray['gender'])) {
                $genderId = genders_model::where('name_en', $rowArray['gender'])
                    ->orWhere('name_ar', $rowArray['gender'])
                    ->value('id');
            }

            // resolve city id from name if given
            $cityId = $rowArray['city_id'] ?? null;
            if (!$cityId && !empty($rowArray['city'])) {
                $cityId = city_model::where('name_en', $rowArray['city'])
                    ->orWhere('name_ar', $rowArray['city'])
                    ->value('id');
            }

            $rowArray['genders_id'] = $genderId;
            $rowArray['city_id'] = $cityId;

            $validator = Validator::make($rowArray, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'nullable',
                'phone' => 'required|integer',
                'genders_id' => 'required|integer|exists:genders,id',
                'city_id' => 'nullable|integer|exists:city,id',
                'active_status_id' => 'nullable|integer',
            ], [
                'genders_id.required' => 'Gender not found for this row',
                'genders_id.exists' => 'Gender value does not match genders table',
                'city_id.exists' => 'City value does not match city table',
            ]);

            if ($validator->fails()) {
                $errors[] = [
                    'row' => $index + 2, // heading row is row 1
                    'name' => $row['name'],
                    'messages' => $validator->errors()->all(),
                ];
                continue;
            }

            doctors_model::createFromImport($rowArray, Auth::id());
            $inserted++;
            if (!empty($rowArray['email'])) {
                $successfulRecipients[] = [
                    'email' => $rowArray['email'],
                    'name' => $rowArray['name'] ?? '',
                ];
            }
        }

        // send notification email to successfully inserted users
        if (!empty($successfulRecipients)) {
            $fromAddress = config('mail.from.address') ?? 'no-reply@example.com';
            $fromName = config('mail.from.name') ?? config('app.name', 'Laravel');
            foreach ($successfulRecipients as $recipient) {
                $emailBody = __('public.import_success_email_body', ['name' => $recipient['name']]);
                Mail::raw($emailBody, function ($message) use ($recipient, $fromAddress, $fromName) {
                    $message->from($fromAddress, $fromName)
                            ->to($recipient['email'])
                            ->subject(__('public.import_success_email_subject') ?? '');
                });
            }
        }

        if (count($errors)) {
            return response()->json([
                "response" => "partial_success",
                "inserted" => $inserted,
                "errors" => $errors,
            ], 422);
        }

        Session::flash("success", __("public.success_import") ?? "File imported successfully");

        return response()->json(array("response" => "success", "message" => __("public.success_import") ?? "File imported successfully", "inserted" => $inserted));
    }
        
        public function doctors_form_update(Request $request)
    {
        // proccess 100000013 - update form
        try {
            $id = decrypt($request->input("id"));
        } catch (\Exception $e) {
            return response()->json(["response" => "invalid_id", "message" => __("public.invalid_payload") ?? "Invalid record identifier"], 400);
        }
        $records = doctors_model::findOrFail($id);
        $lang = app()->getLocale();
        if (Auth::user()["tbl_users_type_id"] == 1) {  // Super admin
            $permissions = array("update" => true );
        } else {
            $permissions = array( "update" => Permission::CheckPermission(2, "doctors") );
        }


        /****** foreign key filters start ******/
        $data_tbl_users_type = tbl_users_type_model::where("is_deleted", 0)->get();
        $data_genders = genders_model::where("is_deleted", 0)->get();
        $data_city = city_model::where("is_deleted", 0)->get();
        /****** foreign key filters end ******/

        $array = array(
                      "folderName" => "settings",
                      "table" => "doctors",
                      "records" => $records ,
                      "permissions" => $permissions,
                      "lang" => $lang,
                      "data_tbl_users_type" => $data_tbl_users_type,
                      "data_genders" => $data_genders,
                      "data_city" => $data_city,
                     
        );

        return view("adminDashboard.administrator.doctors.ajax.doctors_form_update", $array);
    }
    public function doctors_update(Request $request)
    {
        // proccess 1000000266
        try {
            $decryptedId = decrypt($request->input("id"));
        } catch (\Exception $e) {
            return response()->json(["response" => "invalid_id", "message" => __("public.invalid_payload") ?? "Invalid record identifier"], 400);
        }
        $administrator_doctors = doctors_model::findOrFail($decryptedId);
        $oldData = $administrator_doctors->getOriginal();
        //$request->validate(doctors_model::rules());;
        $data = array();
        $data["name"] = $request->input()["name"] ;
        $data["email"] = $request->input()["email"] ;
        $data["phone"] = $request->input()["phone"] ;
        try {
            $data["tbl_users_type_id"] = 4 ;
            $data["genders_id"] = decrypt($request->input()["genders_id"]) ;
            $data["city_id"] = decrypt($request->input()["city_id"]) ;
        } catch (\Exception $e) {
            dd('or here');
            return response()->json(["response" => "invalid_payload", "message" => __("public.invalid_payload") ?? "Invalid encrypted payload"], 400);
        }
        if ($request->hasFile("profile_photo_path")) {
            // remove old photo from Storage
            if ($administrator_doctors->profile_photo_path != "") {
                Storage::disk("uploads")->delete($administrator_doctors->profile_photo_path);
            }
            $file = $request->file("profile_photo_path");
            $path  = $file->store("documents", ["disk" => "uploads"]);
            $data["profile_photo_path"] = $path ;
        }
        $data["updated_by"] = Auth::user()["id"];
        $data["updated_at"] = date("Y-m-d H:i:s");
        $updated = doctors_model::where("id", "=", $decryptedId)->update($data);
        if ($updated) {
            $newData = $data;
            activity("doctors")
            ->performedOn($administrator_doctors)
            ->causedBy(Auth::user())
            ->withProperties([
                "old" => $oldData,
                "attributes" => $newData,
            ])
            ->log("updated");
            Session::flash("success_update", __("public.flashMsg_SuccessUpdate"));
            return response()->json(array("response" => "updated"));
        } else {
            return response()->json(array("response" => "error"));
        }
    }

      
    /****************End Table (doctors) Functionality******************/
}
