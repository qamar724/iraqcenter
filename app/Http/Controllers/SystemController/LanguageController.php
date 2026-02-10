<?php
namespace App\Http\Controllers\SystemController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
class LanguageController extends Controller
{
 public static function Language()
 {
$languages = array(
"en"=>"English",
"ar"=>"Arabic",
   );
return $languages;
 }
  
  public function changeLanguage(Request $request)
  {
     setcookie("lang", $request->input("lang"), time() + (86400 * 30), "/");
  }
}
