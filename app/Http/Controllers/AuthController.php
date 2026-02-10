<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // updated on 10-1-2023
    public function loginWeb(Request $request)
{
    $fields = $request->validate([
        'email' => 'required|string',
        'password' => 'required|string',
    ]);
    $remember_me = $request->has('remember_me') ? true : false; 
    $credentials = $request->only('email', 'password');
    $user = User::where('email', $fields['email'])->first();

    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Sorry, email is not correct!'
        ], 422);
    }

    if ($user->active_status_id == 2) {
        return response()->json([
            'status' => 'error',
            'message' => 'Sorry, the email is not active!'
        ], 422);
    }

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Sorry, password is not correct!'
        ], 422);
    }
   
if (Auth::attempt($credentials,$remember_me)) {
    return response()->json([
        'status' => 'success',
        'user' => $user,

    ], 201);
}
}
    public function login(Request $request)
{
    $fields = $request->validate([
        'email' => 'required|string',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $fields['email'])->first();

    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Sorry, email is not correct!'
        ], 422);
    }

    if ($user->active_status_id == 2) {
        return response()->json([
            'status' => 'error',
            'message' => 'Sorry, the email is not active!'
        ], 422);
    }

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Sorry, password is not correct!'
        ], 422);
    }

    $token = $user->createToken('Mobile_Token')->plainTextToken;

    return response()->json([
        'status' => 'success',
        'user' => $user,
        'token' => $token
    ], 201);
}
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string'
        ]);
        $user = User::create([
            'name'=>$fields['name'],
            'email'=>$fields['email'],
            'password'=> bcrypt($fields['password']),
            'tbl_users_type_id'=>2,
            'active_status_id'=>1,
            'created_by'=>1
        ]);
        $token = $user->createToken('Mobile_Token')->plainTextToken;
        $response = [
            'user'=>$user,
            'token'=>$token
        ];
        return response($response, 201);
    }
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return[
            'message'=>"loggedOut"
        ];
    }
    public function profile()
    {
        $host = request()->getHttpHost();
        $hostUrl = 'https://'.$host.'/uploads/';
        $user_id =  Auth::user()->id;
        $sql = "SELECT
         users.id,
         users.name,
         users.email,
           concat('$hostUrl',users.profile_photo_path) as PhotoURL
         FROM users where id='$user_id'";
        $data = DB::select(DB::raw($sql));
        if (count($data) >=1) {
            return response([
                'message'=>'success',
                'data'=>$data
                ]);
        } else {
            return response([
                'message'=>'faild'
                ]);
        }
    }
    // updated on 10-1-2023
    public function updateUserData(Request $request)
    {
        $errors=array();
        $user = User::findOrFail(Auth::user()->id);
        $data =array();
        if ($request->has('name')) {
            $data['name'] = $request->input()['name'];
        }
        if ($request->has('email')) {
            $data['email'] = $request->input()['email'];
        }
        if ($request->hasFile('photo')) {
            // remove old photo from Storage
            $images = $request->file("photo");
            $allowedExtension = array('bmp','jpg','jpeg','png', 'tif');
            if (in_array($images->extension(), $allowedExtension)) {
                $photo_name = rand()."_".time().".".$images->extension();
                $images->move(public_path("uploads/documents"), $photo_name);
                $data['profile_photo_path']='documents/'.$photo_name;
            } else {
                $errors[]="Sorry, please check photo extension , accepted only ('bmp','jpg','jpeg','png', 'tif')";
            }
        }
        if ($request->has('current_password')) {
            if ((Hash::check($request->get('current_password'), Auth::user()->password))) {
                if (strlen($request->input()['new_password']) >= 8) {
                    $data['password']=Hash::make($request->input()['new_password']);
                } else {
                    $errors[]="Sorry, password length must be more 7 charecter";
                }
            } else {
                $errors[]="Sorry, current password is not correct";
            }
        }
        if (count($errors) >=1) {
            return response([
                'status'=>'error',
                'feedback'=>$errors
                ]);
        } else {
            if (User::where('id', Auth::user()->id)->update($data)) {
                $token = $user->createToken('Mobile_Token')->plainTextToken;
                return response([
                    'status'=>'updated',
                    'feedback'=>[
                      'message'=>'Thank you, we have updated your requested data',
                      'token'=>$token
                    ]
                    ]);
            }
        }
    }
}
