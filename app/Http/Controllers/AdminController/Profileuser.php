<?php

namespace App\Http\Controllers\AdminController;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin\users_model as administrator_users;
use Illuminate\Support\Facades\Session;

class Profileuser  extends Controller
{
   function getUpdateForm()
   {
      return view('adminDashboard.user.edit-profile');
   }
   function getFormToChangePassword()
   {
      return view('adminDashboard.user.edit-password');
   }
   function UsersChangePassword_form_users(Request $request)
   {
      $id = $request->input()['id'];
      $data = array(
         'selectedUserid' => $id
      );
      return view('adminDashboard.user.edit-password-by-admin', $data);
   }
   function ConfirmProfile(Request $request)
   {
      $table = "users";
      $data = array();
      $data["name"] = $request->input()["name"];
      $data["email"] = $request->input()["email"];
      $administrator_users = administrator_users::findOrFail($request->input()["id"]);
      if ($request->hasFile("profile_photo_path")) {
         // remove old photo from Storage
         Storage::disk("uploads")->delete($administrator_users->profile_photo_path);
         $file = $request->file("profile_photo_path");
         $path  = $file->store("documents", ["disk" => "uploads"]);
         $data["profile_photo_path"] = $path;
      }
      $data["updated_at"] = date("Y-m-d H:i:s");
      $updated = administrator_users::where("id", "=", $request->input()["id"])->update($data);
      return response()->json(array("response" => "updated"));
   }
   function ConfirmProfileDirect(Request $request)
   {
      $table = "users";
      $data = array();
      $data["name"] = $request->input()["name"];
      $data["email"] = $request->input()["email"];
      $administrator_users = administrator_users::findOrFail(Auth::user()->id);
      if ($request->hasFile("profile_photo_path")) {
         // remove old photo from Storage
         if ($administrator_users->profile_photo_path != "") {
            Storage::disk("uploads")->delete($administrator_users->profile_photo_path);
         }
         $file = $request->file("profile_photo_path");
         $path  = $file->store("documents", ["disk" => "uploads"]);
         $data["profile_photo_path"] = $path;
      }
      $data["updated_at"] = date("Y-m-d H:i:s");
      $updated = administrator_users::where("id", "=", Auth::user()->id)->update($data);
      return response()->json(array("response" => "updated"));
   }
   function ConfirmchangePassword(Request $request)
   {
      $oldPassword = $request->oldpassword;
      $newPassword = $request->password;
      $repeatPassword = $request->repeatPassword;
      if ($oldPassword == '' || $newPassword == '' || $repeatPassword == '') {
         return response()->json(array(
            "response" => "allFieldRequired",
            "label" => __("public.password_field_required"),
         ));
      } else {
         $hashedPassword = Auth::user()->password;
         if ($newPassword != $repeatPassword) {
            return response()->json(array(
               "response" => "NewPasswor_not_match_repeatPassword",
               "label" => __("public.password_newpassword_not_match_repeated"),
            ));
         } elseif (Hash::check($request->oldpassword, $hashedPassword) === false) {
            return response()->json(array(
               "response" => "CurrentPasswordNotMatch",
               "label" => __("public.password_current_not_match"),
            ));
         } else {
            $user = User::find(Auth::id());
            $user->password = Hash::make($newPassword);
            $user->save();
            return response()->json(array(
               "response" => "updatedSuccessfully",
               "label" => __("public.password_updated"),
            ));
         }
      }
   }
   public function ConfirmchangePasswordFromAdmin(Request $request)
   {
      if (env('SYSTEM_ENV') != 'saas') {
         if (Auth::user()->tbl_users_type_id == 1) {
            $user_id = decrypt($request->input()['id']);
            $password = $request->input()['password'];
            $confirm_password = $request->input()['confirm_password'];
            if ($password == $confirm_password) {
               $data = array(
                  'password' => Hash::make($password)
               );
               $update = User::where('id', $user_id)->update($data);
               Session::flash("success_update",  __("public.flashMsg_SuccessUpdate"));
               return response()->json(array("response" => "updated"));
            } else {
               return response()->json(
                  array(
                     "response" => "password_not_match",
                     "label" => __("public.password_not_match")
                  )
               );
            }
         }
      } else {
         if (Auth::user()->tbl_users_type_id == 1 || Auth::user()->tbl_users_type_id == 2) {
            $user_id = decrypt($request->input()['id']);
            $password = $request->input()['password'];
            $confirm_password = $request->input()['confirm_password'];
            if ($password == $confirm_password) {
               $data = array(
                  'password' => Hash::make($password)
               );
               $update = User::where('id', $user_id)->update($data);
               Session::flash("success_update",  __("public.flashMsg_SuccessUpdate"));
               return response()->json(array("response" => "updated"));
            } else {
               return response()->json(
                  array(
                     "response" => "password_not_match",
                     "label" => __("public.password_not_match")
                  )
               );
            }
         }
      }
   }
   public function LockUnlockAccount_form_users(Request $request)
   {
      if (env('SYSTEM_ENV') != 'saas') {
         if (Auth::user()->tbl_users_type_id == 1) {
            $currentStatus = User::where("id", decrypt($request->input()["id"]))->get();
            if ($currentStatus[0]->active_status_id == 1) {
               User::where("id", decrypt($request->input()["id"]))->update(['active_status_id' => 2]);
               Session::flash("success_update",  __("public.deactiveUserAccountSuccess"));
            } else {
               User::where("id", decrypt($request->input()["id"]))->update(['active_status_id' => 1]);
               Session::flash("success_update",  __("public.activeUserAccountSuccess"));
            }
         }
      } else {
         if (Auth::user()->tbl_users_type_id == 1 || Auth::user()->tbl_users_type_id == 2) {
            $currentStatus = User::where("id", decrypt($request->input()["id"]))->get();
            if ($currentStatus[0]->active_status_id == 1) {
               User::where("id", decrypt($request->input()["id"]))->update(['active_status_id' => 2]);
               Session::flash("success_update",  __("public.deactiveUserAccountSuccess"));
            } else {
               User::where("id", decrypt($request->input()["id"]))->update(['active_status_id' => 1]);
               Session::flash("success_update",  __("public.activeUserAccountSuccess"));
            }
         }
      }
   }
}
