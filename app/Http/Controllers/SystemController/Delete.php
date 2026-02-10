<?php

namespace App\Http\Controllers\SystemController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Delete  extends Controller
{
    public static function checkRow($fieldName, $fieldValue)
    {
        $exceptionTables = array('tbl_actions', 'tbl_menu', 'tbl_operation', 'tbl_permissions', 'tbl_sys_operations_type', 'tbl_sys_tabels_control', 'tbl_users_type', 'tbl_users');
        $tables = DB::select('SHOW TABLES');
        $foundTables = array();
        $targetTabel = array();
        foreach ($tables  as $table) {
            foreach ($table as $key => $value) {
                if (in_array($value, $exceptionTables) === false) {
                    array_push($foundTables, $value);
                }
            }
        }
        if (count($foundTables) >= 1) {
            foreach ($foundTables as $key => $value) {
                //
                $existsTables = DB::select("SHOW FULL COLUMNS FROM $value");;
                foreach ($existsTables  as $keyE) {
                    if ($keyE->Field == $fieldName) {
                        array_push($targetTabel, $value);
                    }
                }
            }
        }
        if (count($targetTabel) >= 1) {
            foreach ($targetTabel as $target) {
                if (env("DELETE_TYPE") == "soft") {
                    $recordsSql =  DB::table($target)->where($fieldName, $fieldValue)->where("is_deleted", 0)->get();
                } else {
                    $recordsSql =  DB::table($target)->where($fieldName, $fieldValue)->get();
                }
                if (count($recordsSql)   >= 1) {
                    return true;
                    break 1;
                }
            }
        }
        return false;
    }
}
