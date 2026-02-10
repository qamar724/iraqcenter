<?php
 if (request("hospitals_id")) {
  $hospitals_id=decrypt(request("hospitals_id"));

  $sql="SELECT
       hospitals_has_specialties.id as id,
       specialties.name_$lang as name_en
       FROM
       hospitals_has_specialties
       JOIN specialties ON specialties.id = hospitals_has_specialties.specialties_id
       WHERE hospitals_has_specialties.hospitals_id=$hospitals_id
       ";

      
       $records = DB::select( $sql );
      
    if (count($records) >= 1) {
           $data = "";
         $data .= "<option value=0>Select</option>";
        foreach ($records  as $record) {
            $data .= "<option value=".encrypt($record->id).">".$record->name_en."</option>";
         }
          echo $data;
      } else {
          echo "<option value=0>No Data</option>";
       }
    }
