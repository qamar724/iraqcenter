<?php
namespace App\Http\Controllers\SystemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Input  extends Controller{
  public static function exists($type ='post'){
    switch ($type) {
      case 'post':
       return (!empty($_POST)) ? true : false;
        break;

      case 'get':
        return (!empty($_GET)) ? true : false;
        break;

      default:
        return false;
        break;
    }
  }


  public static function get($item){
    if(isset($_POST[$item])){
      return trim( $_POST[$item]);
    }else if(isset($_GET[$item])){
      return trim($_GET[$item]);
    }
    return '';
  }
}

?>
