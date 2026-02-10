<?php
 use App\Http\Controllers\SystemController\System;  
 use App\Http\Controllers\SystemController\Mform;  
 use App\Http\Controllers\SystemController\Filter; 
 use App\Http\Controllers\SystemController\Input;  
 use Illuminate\Support\Facades\DB;  
 //45512323664
    $lang =app()->getLocale();  
    $records = DB::table("hospitals")->where("city_id" ,decrypt(request("city_id")))->get();
    if (count($records) >= 1) {
         $data = "";
         $data .= "<option value=".encrypt(-1).">".__("public.select")."</option>";
        foreach ($records  as $record) {
         $record_id= encrypt($record->id);
            $data .= "<option value=$record_id>$record->name</option>";
         }
          echo $data;
      } else {
          echo "<option value=".encrypt(-1).">".__("public.no_return_data")."</option>";
      }
