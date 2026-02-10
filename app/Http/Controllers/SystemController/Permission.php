<?php
namespace App\Http\Controllers\SystemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class Permission  extends Controller{
  public static function CheckPermission($tbl_actions_id,$tableName){
    $tbl_users_type_id = Auth::user()->tbl_users_type_id;
    $tbl_adv_menu_sub_id = self::getTableName($tableName);
    $permission =  DB::table('tbl_permissions')
    ->where("tbl_actions_id","$tbl_actions_id")
    ->where("tbl_adv_menu_sub_id",$tbl_adv_menu_sub_id)
    ->where("tbl_users_type_id",$tbl_users_type_id)
    ->get();
    if(count($permission) >= 1){
        return true;
    }
    return false;
  }
  private static function getTableName($tableName){
    $row = DB::table("tbl_adv_menu_sub")->where("link",$tableName)->get();
    if(count($row) >= 1){
        return $row[0]->id;
    }
    return false;
  }
  public static function GenerateElementPagePermissionsAdvance( $tbl_users_type_id)
    {
        $table = 'tbl_permissions';
        $user_type =(Auth::user()->tbl_users_type_id==1) ? '1,2,3':'2,3';;
        $sql = " SELECT
        tbl_adv_menu_sub.id AS tbl_adv_menu_sub_id,
        tbl_adv_menu_sub.page_name AS pageName,
        tbl_adv_menu_sub.link AS link,
        tbl_adv_menu.id AS tbl_adv_menu_id,
        tbl_adv_menu.moduleName AS mainmenu
    FROM
        `tbl_adv_menu_sub`
    JOIN tbl_adv_menu ON tbl_adv_menu_sub.tbl_adv_menu_id = tbl_adv_menu.id
    WHERE
    tbl_adv_menu_sub.permission_type_id in($user_type) and   page_name != 'tbl_action' AND page_name != 'tbl_assign_workflow'  order by tbl_adv_menu.id asc";
        $records = DB::select($sql);
        if ( count($records) >= 1) {
            echo "<table class='table table-generated '>";
            echo "<tr>";
            echo "<td>".__("public.main_menu")." </td>";
            echo "<td>".__("public.sub_menu")." </td>";
            echo "<td>".__("public.permission_view")."</td>";
            echo "<td>".__("public.permission_edit")."</td>";
            echo "<td>".__("public.permission_insert")."</td>";
            echo "<td>".__("public.permission_delete")."</td>";
            echo "</tr>";
            foreach ($records  as $record) {
                $tbl_adv_menu_id=$record->tbl_adv_menu_id;
                $tbl_adv_menu_sub_id=$record->tbl_adv_menu_sub_id;
                $check_1 = '';
                $check_2 = '';
                $check_3 = '';
                $check_4 = '';
                if (self::checkifUserHavePermissionAdvance($tbl_adv_menu_id,$tbl_adv_menu_sub_id, 1, $tbl_users_type_id)) {
                    $check_1 = 'checked';
                }
                if (self::checkifUserHavePermissionAdvance($tbl_adv_menu_id,$tbl_adv_menu_sub_id, 2, $tbl_users_type_id)) {
                    $check_2 = 'checked';
                }
                if (self::checkifUserHavePermissionAdvance($tbl_adv_menu_id,$tbl_adv_menu_sub_id, 3, $tbl_users_type_id)) {
                    $check_3 = 'checked';
                }
                if (self::checkifUserHavePermissionAdvance($tbl_adv_menu_id,$tbl_adv_menu_sub_id, 4, $tbl_users_type_id)) {
                    $check_4 = 'checked';
                }
                echo "<tr>";
                echo "<td> ".__("menu.mainmenu_".strtolower($record->mainmenu)."")." </td>";
                echo "<td> ".__("menu.submenu_".strtolower($record->link)."")."  </td>";
                echo "<td><input type='checkbox' $check_1 id='checkbox_".$tbl_adv_menu_id."_$tbl_adv_menu_sub_id" . '_' . "1_$tbl_users_type_id' onclick='setPermissionToUser($tbl_adv_menu_id,$tbl_adv_menu_sub_id, 1,$tbl_users_type_id)' ></td>";
                echo "<td><input type='checkbox' $check_2 id='checkbox_".$tbl_adv_menu_id."_$tbl_adv_menu_sub_id" . '_' . "2_$tbl_users_type_id' onclick='setPermissionToUser($tbl_adv_menu_id,$tbl_adv_menu_sub_id, 2,$tbl_users_type_id)' ></td>";
                echo "<td><input type='checkbox' $check_3 id='checkbox_".$tbl_adv_menu_id."_$tbl_adv_menu_sub_id" . '_' . "3_$tbl_users_type_id' onclick='setPermissionToUser($tbl_adv_menu_id,$tbl_adv_menu_sub_id, 3,$tbl_users_type_id)' ></td>";
                echo "<td><input type='checkbox' $check_4 id='checkbox_".$tbl_adv_menu_id."_$tbl_adv_menu_sub_id" . '_' . "4_$tbl_users_type_id' onclick='setPermissionToUser($tbl_adv_menu_id,$tbl_adv_menu_sub_id, 4,$tbl_users_type_id)' ></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

    
      public static function checkifUserHavePermissionAdvance($tbl_adv_menu_id,$tbl_adv_menu_sub_id, $tbl_actions_id, $tbl_users_type_id)
    {
        $records =  DB::table('tbl_permissions')->where([
            ['tbl_adv_menu_id', '=', $tbl_adv_menu_id],
            ['tbl_adv_menu_sub_id', '=', $tbl_adv_menu_sub_id],
            ['tbl_actions_id', '=', $tbl_actions_id],
            ['tbl_users_type_id', '=', $tbl_users_type_id]
        ])->get()  ;
        if ( count($records) >= 1) {
            return true;
        }
        return false;
    }
    public static function getUsersTypeBelongToAdmin(){
        $user_id = Auth::user()["id"];
        $sql = "select id from tbl_users_type where created_by = $user_id";
        $records = DB::select(  $sql  );
        $data = array();
        foreach ($records as $record) {
          $data[] = $record->id;
        }
        return $data;
      }
    public static function getUsersBelongToAdministrator(){
        $user_id = Auth::user()["id"]; // 5
        $sql = "select id from users where created_by = $user_id";
        $records = DB::select(  $sql  );
        $data = array();
        $data[]=Auth::user()["id"];
        foreach ($records as $record) {
          $data[] = $record->id;
        }
        return $data;
      }
      public static function getAllUsersAddedByAdmin(){
        $data = array();
        if(Auth::user()["tbl_users_type_id"] == 2){
          $user_id = Auth::user()["id"];
           $sql = "select id from users where created_by = $user_id";
           $data[]=Auth::user()["id"];
        }else{
          $user_id = Auth::user()["created_by"]; // 2
          $sql = "select id from users where created_by = $user_id";
          $data[]=Auth::user()["created_by"];
        }
        $records = DB::select(  $sql  );
        foreach ($records as $record) {
          $data[] = $record->id;
        }
       // dd($data);
        return $data;
      }
      //Permission::getAllUsersAddedByAdmin()
      public static function getAllUsersAddedByAdminRaw(){
        $records = self::getAllUsersAddedByAdmin();
        if(count($records)){
          $string = '';
          $x = 1;
          $recordCount = count($records);
          foreach($records as $value){
            if($x < $recordCount){
              $string .= $value .',';
            }else{
              $string .= $value;
            }
            $x++;
          }
          return $string;
        }
        /*
        array(
          0=>1,
          1=>3,
          2=>4
        )
        */
        // 1,3,4
      }

      public static function getSuperAdmin(){
        return $created_by = Auth::user()->created_by;
      }
}
?>
