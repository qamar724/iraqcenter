<?php 
use App\Http\Controllers\SystemController\Mform;  
use App\Http\Controllers\SystemController\System;   
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SystemController\Permission; 
$FolderName =  "Administrator";  
  Mform::drawOpenDiv($divCount = 1, $title =  "Set Permission to this user", $myid = "main");
    $sql = "
    SELECT
    tbl_adv_menu_sub.id AS tbl_adv_menu_sub_id,
    tbl_adv_menu_sub.page_name AS pageName,
    tbl_adv_menu_sub.link AS link,
    tbl_adv_menu.id AS tbl_adv_menu_id,
    tbl_adv_menu.moduleName AS mainmenu
    FROM
        `tbl_adv_menu_sub`
    JOIN tbl_adv_menu ON tbl_adv_menu_sub.tbl_adv_menu_id = tbl_adv_menu.id
    WHERE
    page_name != 'users' AND page_name != 'tbl_users_type' AND page_name != 'tbl_action' AND page_name != 'tbl_assign_workflow'   ";
    $records = DB::select($sql);
    if (count($records) >=1) {
       Permission::GenerateElementPagePermissionsAdvance(   $users_id);
    } else {
        Mform::MsgError("sorry, there is an errors");
    }
    Mform::rowOpen();
    Mform::Button($inputName = "Close", $id = "Close", $title = __("public.close"), $classElement = "btn btn-danger rev-popUp-btn-left", $javascript =   'onclick="hidepopup()"' , $classMainDiv = "col-lg-6 col-md-6 col-sm-6 col-xs-6 float-m-by-lang NOpadding NOmargin  rev-padding-left-5", $attr = "");
    Mform::rowClose();
    Mform::drawCloseDiv();
?>