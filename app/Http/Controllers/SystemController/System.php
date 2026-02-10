<?php 
namespace App\Http\Controllers\SystemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
class System extends Controller
{
    public static function PackageAjax($module)
    {
        global $lang;
        include "../class/$module.php";
        include "../lang/$lang.php";
    }
    public static function Package($module)
    {
          $lang='en';
         
        include  resource_path().'/views/adminDashboard/'.$module.'/class/'.$module.'.php';
       // include  resource_path().'/views/'.$module.'/lang/en.php';
       
    }
   
    public static function checkString($content)
    {

       
        $supported_image = array(
            'tif',
            'tiff',
            'bmp',
            'jpg',
            'jpeg',
            'gif',
            'png',
            'eps',
            
        );
        
       $supported_document = array(
           'odt',
           'pdf',
           'xls',
           'xlsx',
           'ppt',
           'pptx',
           'txt',
           'doc',
           'docx',
           
       );
        $extImage = strtolower(pathinfo($content, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
        $extDocument = strtolower(pathinfo($content, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
        if (in_array($extImage, $supported_image)) {
             
         
            $filePath = public_path()."/uploads/$content";
            if(File::exists( $filePath)){
            
                 
                echo " <a  href='".asset("uploads/$content")."' data-lightbox='images'><img src='".asset("uploads/$content")."' class='imageTable'></a>";
            }else{
                
                 echo "<img src='".asset("images/Image_not_available.png")."' class='imageTable'>";
            }
           


        } else if (in_array($extDocument, $supported_document)){
            echo "<a href='uploads/".$content."' download><i class='fa fa-file documentTable' > File</i></a>";
        }else{
            return $content;
        }


     


    }
}