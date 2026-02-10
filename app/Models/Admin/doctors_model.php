<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Cookies;
use Illuminate\Contracts\Validation\Rule;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Hash;

//7878454545
class doctors_model extends Model
{
    use LogsActivity;
    protected static $logName = "users";
    public $table = "users";
    protected $fillable = [
    "id",
    "name",
    "email",
    "profile_photo_path",
    "tbl_users_type_id",
    "phone",
    "genders_id",
    "city_id",
    "tbl_users_type_id",
    "active_status_id",
    "password",
    "created_by",
    "created_at",
    "updated_at",
    "updated_by",
    ];
    public static function rules($request)
    {
        //proccess 1000050
        $request["gender"]  = decrypt($request["gender"]);
        $request["city"]  = decrypt($request["city"]);
        return [
            "name" => ["required","string"],
            "email" => ["required","string"],
            "profile_photo_path" => ["nullable","mimes:bmp,jpg,jpeg,gif,png","max:50000"],
            "phone" => ["required","integer"],
            "gender" => ["exists:gender","string"],
            "city" => ["exists:city","string"],
               ];
    }

    /**
     * Insert a doctor/user row coming from import.
     *
     * @param array $row
     * @param int $createdBy
     * @return static
     */
    public static function createFromImport(array $row, int $createdBy)
    {
        return self::create([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password'] ?? '123456'),
            'tbl_users_type_id' => 4,
            'phone' => $row['phone'] ?? null,
            'genders_id' => $row['genders_id'],
            'city_id' => $row['city_id'] ?? null,
            'active_status_id' => 1,
            'created_by' => 1,
            'created_at' => now(),
        ]);
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName("users")->logOnly(["*"]);
    }
}
