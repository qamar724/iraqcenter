<?php
namespace App\Http\Controllers\SystemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
 


class Mform extends Controller
{

    // this function to open new form and must close with closeForm function
    public static function openForm($action = '', $method = 'post', $enctype = "multipart/form-data", $id = '')
    {

        //$action = $_SERVER['REQUEST_URI'];
        $data = "<form action='$action' method='$method' id='form_$id' enctype='$enctype'  autocomplete='off'>";
        $data .= "<div class='row'  >";
        // $data .= "<div class='col-md-12'>";

        echo $data;
    }
    


    public static function ButtonAction($buttonStyle , $table,$id){
      //  echo '<div class="ml-auto">';
        if($buttonStyle=='update'){
 
        echo ' <a href="javascript:void(0)"   data-bs-toggle="modal"    data-bs-target="bd-dialog-modal-lg" data-bs-toggle="bd-dialog-modal-lg" data-toggle="modal" data-target=".bd-dialog-modal-lg"  onclick="update_form_'.$table.'('.$id.',\'' . $table. '\')"  class="modal-effect btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a> ';
        }elseif($buttonStyle=='delete'){
        echo ' <a href="javascript:void(0)"   data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg" data-toggle="modal" data-target=".bd-dialog-modal-lg" onclick="delete_form_'.$table.'('.$id.',\'' . $table. '\')"  class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a> ';

        }elseif($buttonStyle=='details'){
       
        echo ' <a href="javascript:void(0)"    data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg" data-toggle="modal" data-target=".bd-dialog-modal-lg"  onclick="getDetails_'.$table.'('.$id.',\'' . $table. '\')"  class="btn btn-info shadow btn-xs sharp"><i class="fa fa-info"></i></a> ';

    
    }elseif($buttonStyle=='permission'){
        echo ' <a href="javascript:void(0)"   data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg" data-toggle="modal" data-target=".bd-dialog-modal-lg"  onclick="Permission_form_'.$table.'('.$id.',\'' . $table. '\')"  class="btn btn-info shadow btn-xs sharp"><i class="fa fa-eye"></i></a> ';
    }elseif($buttonStyle=='CloselockAccount'){
        echo ' <a href="javascript:void(0)"   data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg" data-toggle="modal" data-target=".bd-dialog-modal-lg"  onclick="LockAccount_form_'.$table.'('.$id.',\'' . $table. '\')"  class="btn btn-warning shadow btn-xs sharp"><i class="fa fa-lock"></i></a> ';

        }elseif($buttonStyle=='OpenlockAccount'){
            echo ' <a href="javascript:void(0)"   data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg" data-toggle="modal" data-target=".bd-dialog-modal-lg"  onclick="LockAccount_form_'.$table.'('.$id.',\'' . $table. '\')"  class="btn btn-info shadow btn-xs sharp"><i class="fas fa-lock-open"></i></a> ';
    
            }elseif($buttonStyle=='changePassword'){
            echo ' <a href="javascript:void(0)"   data-bs-toggle="modal"    data-bs-target=".bd-dialog-modal-lg" data-toggle="modal" data-target=".bd-dialog-modal-lg"  onclick="UsersChangePassword_form_'.$table.'('.$id.',\'' . $table. '\')"  class="btn btn-secondary shadow btn-xs sharp"><i class="fa fa-key"></i></a> ';

        }
       // echo '</div>';
    }
    public static function openFormExport()
    {

        //$action = $_SERVER['REQUEST_URI'];
        $data = "<form action='export.php' method='post' id='convert_form'  >";

        // $data .= "<div class='col-md-12'>";

        echo $data;
    }

    public static function closeFormExport()
    {
        echo "</form>";
    }

    

   

    public static function drawFilters($filters, $Maintable, $filtersData)
    {
        // print_object($filters);
        //print_object($_POST);
        /*
         * example:
         *
         * self::drawFilters($objects);
         */

        $counterElemetsFileter = 0;
        // self::drawOpenDiv($divCount = 1, $title = "filter", $myid = "main");
        self::ButtonFilter($inputName = 'showFilter', $id = 'showFilter', $title = 'Show filter', $classElement = 'btn btn-danger btn-sm', $javascript = 'onclick=toggleFilter()', $classMainDiv = '', $attr = '');

        echo "<div class='col-lg12 bg-orange text-white' id='filterDialog' style='display:none;padding: 10px; border-radius: 15px;'>";

        self::openForm($action = '', $method = 'post', $enctype = '');

        //$forgienFields = self::readForgenFields($filters);
        $forgienFieldsCount = count($filtersData);
        $totalFilterCount = $forgienFieldsCount + 2; // 2 from_date and to_date
        $totalFilterCountPerDiv = ceil(12 / $totalFilterCount);
        foreach ($filtersData as $forgienTable => $value) {
            //  echo $tableForgen = self::explodeLast('_id',$forgienField) ;
            $tblId = $forgienTable . '_id';
            self::select($forgienTable, $forgienTable, $selectName = 'key_'.$tblId, $key = 'id', $value, $inpuValue = "", $classElement = '', $classMainDiv = "col-lg-$totalFilterCountPerDiv", $javascript = '', $where = null);
        }
        self::date($title = __('public.from_date'), $inputName = 'id_from_date', $id = 'id_from_date', $inputValue = "", $classElement = '', $javascript = '', $classMainDiv = "col-lg-$totalFilterCountPerDiv", $attr = '');
        self::date($title = __("public.to_date"), $inputName = 'id_to_date', $id = 'id_to_date', $inputValue = "", $classElement = '', $javascript = '', $classMainDiv = "col-lg-$totalFilterCountPerDiv", $attr = '');

        self::saveBtn($inputName = '', $id = '', $title = __('public.search'), $classElement = 'btn btn-success col-lg-3', $javascript = '', $classMainDiv = ' col-lg-12 text-center', $attr = '');
        self::closeForm();
        echo "</div>";
        //  self::drawCloseDiv();
    }
   /* private static function explodeLast($explodeAt, $string)
    {
        $explode = explode($explodeAt, $string);
        $count = count($explode);
        $counter = 0;
        $string = null;

        while ($counter < $count - 1) {
            if ($counter < $count - 2) {
                $string .= $explode[$counter] . $explodeAt;
            } //end of if ($counter < $count-2)
            else {
                $string .= $explode[$counter];
            } //end of else not ($counter < $count-2)

            $counter++;
        } //end of while ($counter < $count)

        return $string;
    }*/
   /* private static function readForgenFields($filters)
    {
        $forgienFields = array();
        foreach ($filters as $filter) {
            if (self::checkString($filter)) {
                array_push($forgienFields, $filter);
            }

        }
        return $forgienFields;
    }
    private static function checkString($String)
    {
        if (strstr($String, 'tbl_')) {
            return true;
        } else {
            return false;
        }
    }*/
    public static function label($title = '', $id = '',  $classElement = '', $javascript = '', $attr = '',   $style = '')
    {

      
      
        // Notes: so if title not integar and not empty then title by defult is string

         
        echo  "<label id='$id' class='$classElement' $javascript  $attr style='$style'>" . $title . "</label>";
        
         
    }

   
    // to open model box use this with ajax
    public static function getEmptyBoxResult($class_css)
    {
        echo "<div class='clearfix'></div>";
        echo "<div class='$class_css'></div>";
        echo "<div class='clearfix'></div>";
    }
    public static function colorPicker($title = '', $inputName = '', $id = '', $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '') {

        $data = "<div class='form-group row $classMainDiv'>";
        $data .= "<div class='col-lg-12'>";
        $data .= "<label  >" . $title . "</label>";
        // $data .= "</div>";
        //  $data .= "<div class='col-lg-9'>";
        $data .= "<input type='color' autocomplete='false'  value='$inputValue' class='form-control $classElement' $javascript id='$id' name='$inputName' $attr />";
        $data .= "</div>";
        $data .= "</div>";

        echo $data;
    }
  
    public static function text($title = '', $inputName = '', $id = '', $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '')
    {

        /*
         * example:
         *
         * self::text($title = $Description, $inputName = $colName, $id = 'id_' . $colName, $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '');
         */

        /*  if (Input::exists()) {
        $inputValue = Input::get($inputName);
        } */
        if (empty($title)) {
            $title = '';
        }  
        // Notes: so if title not integar and not empty then title by defult is string

        $data = "<div class='form-group row $classMainDiv'>";
        $data .= "<div class='col-lg-12'>";
        $data .= "<label>" . $title . "</label>";
        //$data .= "</div>";
       // $data .= "<div class='col-lg-9'>";
        $data .= "<input type='text' autocomplete='false'  value='$inputValue' class='form-control $classElement' $javascript id='$id' name='$inputName' $attr />";
        $data .= "</div>";
        $data .= "</div>";
        echo $data;
    }
    public static function password($title = '', $inputName = '', $id = '', $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '')
    {

        /*
         * example:
         *
         * self::text($title = $Description, $inputName = $colName, $id = 'id_' . $colName, $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '');
         */

        /*  if (Input::exists()) {
        $inputValue = Input::get($inputName);
        } */
        if (empty($title)) {
            $title = '';
        }  
        // Notes: so if title not integar and not empty then title by defult is string

        $data = "<div class='form-group row $classMainDiv'>";
        $data .= "<div class='col-lg-12'>";
        $data .= "<label>" . $title . "</label>";
       // $data .= "</div>";
       // $data .= "<div class='col-lg-9'>";
        $data .= "<input type='text' autocomplete='false'  value='$inputValue' class='form-control $classElement' $javascript id='$id' name='$inputName' $attr />";
        $data .= "</div>";
        $data .= "</div>";
        echo $data;
    }

    public static function fileUpload($title = '', $inputName = '', $id = '', $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '')
    {

        /*
         * example:
         *
         * self::text($title = $Description, $inputName = $colName, $id = 'id_' . $colName, $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '');
         */

        /*  if (Input::exists()) {
        $inputValue = Input::get($inputName);
        } */
        if (empty($title)) {
            $title = '';
        }  
        // Notes: so if title not integar and not empty then title by defult is string

        $data = "<div class='form-group row $classMainDiv'>";
        $data .= "<div class='col-lg-12'>";
        $data .= "<label>" . $title . "</label>";
       // $data .= "</div>";
       // $data .= "<div class='col-lg-9'>";
        $data .= "<input type='file' autocomplete='false'  value='$inputValue' class='form-control $classElement' $javascript id='$id' name='$inputName' $attr />";
        $data .= "</div>";
        $data .= "</div>";
        echo $data;
    }

    public static function Number_float($title = '', $inputName = '', $id = '', $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '')
    {

        /*
         * example:
         *
         * self::Number_float($title = $Description, $inputName = $colName, $id = 'id_' . $colName, $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '');
         */

        /*  if (Input::exists()) {
        $inputValue = Input::get($inputName);
        } */

        if (empty($title)) {
            $title = '';
        }  
        // Notes: so if title not integar and not empty then title by defult is string

        $data = "<div class='form-group row $classMainDiv'>";
        $data .= "<div class='col-lg-12'>";
        $data .= "<label>" . $title . "</label>";
       // $data .= "</div>";
        //$data .= "<div class='col-lg-9'>";
        $data .= "<input type='number' step='0.01' autocomplete='false'  value='$inputValue' class='form-control $classElement' $javascript id='$id' name='$inputName' $attr />";
        $data .= "</div>";
        $data .= "</div>";
        echo $data;
    }

    public static function Number_int($title = '', $inputName = '', $id = '', $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '')
    {

        /*
         * example:
         *
         * self::Number_int($title = 336, $inputName = 'trx_period', $id = 'trx_period', $inputValue = '', $classElement = '', $javascript = "onkeyup=get_leave_value()", $attr = '', $classMainDiv = 'col-lg-4');
         */

        /*  if (Input::exists()) {
        $inputValue = Input::get($inputName);
        } */

        if (empty($title)) {
            $title = '';
        }  
        // Notes: so if title not integar and not empty then title by defult is string

        $data = "<div class='form-group row $classMainDiv'>";
        $data .= "<div class='col-lg-12'>";
        $data .= "<label>" . $title . "</label>";
        //$data .= "</div>";
        //$data .= "<div class='col-lg-9'>";
        $data .= "<input type='number'   autocomplete='false'  value='$inputValue' class='form-control $classElement' $javascript id='$id' name='$inputName' $attr />";
        $data .= "</div>";
        $data .= "</div>";
        echo $data;
    }

     

    public static function email($title = '', $inputName = '', $id = '', $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '')
    {

        /*
         * example:
         *
         * self::email($title = 27, $inputName = 'email', $id = 'email', $inputValue = @$email, $class = '', $javascript = '', $attr = 'placeholder="' . $email_placeholder . '"', $ClassMain = 'col-lg-3');
         */

        /*  if (Input::exists()) {
        $inputValue = Input::get($inputName);
        } */

        if (empty($title)) {
            $title = '';
        }  
        // Notes: so if title not integar and not empty then title by defult is string

        $data = "<div class='form-group $classMainDiv'>";
        $data .= "<label>" . $title . "</label>";
        $data .= "<input type='email' autocomplete='false' value='$inputValue' class='form-control $classElement' $javascript id='$id' name='$inputName' $attr />";
        $data .= "</div>";
        echo $data;
    }

     

    //$data = "<div id='results_delete'></div>";
    // use this function to open new row and col-lg(md-xs)-Number and must close this function with drawCloseDiv
    public static function drawOpenDiv($divCount = 1, $title = '', $myid = '',$table='',$insertPermission=false)
    {
        $i = 12 / $divCount;
        if ($title != '') {
            $title =  $title ;
        }
        if ($myid != '') {
            $divData = "id='$myid'";
        } else {
            $divData = '';
        }

        $data = "<div class='col-md-$i ' $divData table-responsive>";

        $data .= "<div class='card card-primary '>";
        $data .= "<div class='card-header '>";
        $data .= "  <h3 class='card-title '>" . strtoupper($title) . "</h3>";
        if($insertPermission){
           
            $data .=   Mform::ButtonInsertNew("addForm", $id = "AddForm", $title = __("public.add_new") , $classElement = "btn btn-primary btn-sm ", $javascript = "onclick=AddForm_$table()", $classMainDiv = "col-lg-12", $attr = "");

        }
       
       
        $data .= "</div>";
        $data .= "<div class='card-body'>";
        echo $data;
    }
    public static function drawOpenInnerDiv($divCount = 1, $title = '', $innerDivFlag = 0)
    {
        //  $i = 12 / $divCount;
        

        $data = "<div class='box-header with-border'>";
        if ($innerDivFlag == 0) {
            $data .= "<div class='box box-primary    '>";
            $data .= "  <h3 class='box-title-index'>" . $title . "</h3>";
            $data .= "</div>";
        }

        $data .= "<div class='box-body'>";
        echo $data;
    }

    public static function drawOpenCustomInnerDiv($divWidth = '12', $id = '')
    {
        $data = "<div id=$id class='col-lg-" . $divWidth . " col-md-" . $divWidth . " col-sm-12 col-xs-12'>";
        echo $data;
    }

    public static function drawCloseCustomInnerDiv()
    {
        $data = "</div>";
        echo $data;
    }

    public static function drawOpenOneLineInnerDiv()
    {
        $data = "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
        echo $data;
    }

    public static function drawCloseOneLineInnerDiv()
    {
        $data = "</div>";
        echo $data;
    }

    public static function drawCloseInnerDiv()
    {
        $data = '</div >';

        $data .= '</div >';
        echo $data;
    }

    public static function AjaxJSFile($folderName)
    {
        //$data = "<script src='module/$folderName/js/$folderName.js' ></script>";
        $data  = "<script>";
        $data .= "$('.date').datepicker({";
        $data .= " format: 'yyyy-mm-dd',";
        $data .= " todayBtn: 'linked',";
        $data .= "   clearBtn: true,";
        $data .= "   autoclose: true";
        $data .= "  });";
        $data .= "$('.select2').select2({";
        $data .= "placeholder: 'Select an option'";
        $data .= " });";
        $data .= "</script>";

        echo $data;
    }

   
    public static function MainPageJs($folderName)
    {
        $data = "<script src='module/$folderName/js/" . $folderName . ".js' type='text/javascript'></script>";
        echo $data;
    }

    public static function clearfix()
    {
        echo "<div class='clearfix'></div>";
    }

    public static function drawCloseDiv()
    {
        $data = '</div >';

        $data .= '</div >';
        $data .= '</div >';
        echo $data;
    }

    public static function hidden($inputName = '', $id = '', $inputValue = '', $class = '')
    {
        $data = "<input type='hidden' value='$inputValue' class=' $class '  id='$id' name='$inputName' />";

        echo $data;
    }
    public static function excelElement()
    {

        $data = "<input type='hidden'     id='file_content' name='file_content' />";

        echo $data;
    }

    
    public static function ExportPrinterHelper($helper)
    {
        $data = '<div class="row col-lg-12">';
        if (in_array('xlx', $helper)) {
            $data .= '<div class="col-lg-1">';
            $data .= '<img src="images/excel.ico"  style="width:50px;" name="convert" id="convert" />';
            $data .= '</div>';

        }
        if (in_array('printer', $helper)) {
            $data .= '<div class="col-lg-1">';
            $data .= '<img src="images/printer-door-open.png"  onclick=printContent() style="width:50px;"   />';
            $data .= '</div>';

        }

        $data .= '</div>';
        echo $data;

    }
    
    public static function InputTime($title = '', $inputName = '', $id = '', $inputValue = '', $classElement = '', $javascript = '', $classMainDiv = '', $attr = '')
    {

        /*
         * example:
         *
         * self::date($title = $Description, $inputName = $colName, $id = 'id_' . $colName, $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '');
         */

         
        if (empty($title)) {
            $title = '';
        }  

       

        $output = "<div class='form-group row $classMainDiv'>";
        $output .= "<div class='col-lg-12'>";
        $output .= "<label>" . $title . "</label>";
       // $output .= "</div> ";
       // $output .= "<div class='col-lg-9'>";
        $output .= "<div class='input-group bootstrap-timepicker timepicker'>";
        $output .= "<div class='input-group-addon'>";
        $output .= "  ";
        $output .= "  </div>";
        $output .= "  <input type='time' autocomplete='false'   class='form-control timepicker1   $classElement' id='$id'  $javascript value='$inputValue' name='$inputName' $attr><span class='input-group-addon'><i class='glyphicon glyphicon-time'></i></span>";
        $output .= "  </div>";
        $output .= "</div> ";
        $output .= "</div> ";
        echo $output;
    }
    public static function date($title = '', $inputName = '', $id = '', $inputValue = '', $classElement = '', $javascript = '', $classMainDiv = '', $attr = '')
    {

        /*
         * example:
         *
         * self::date($title = $Description, $inputName = $colName, $id = 'id_' . $colName, $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '');
         */

         
        if (empty($title)) {
            $title = '';
        }  

        $output = "<div class='form-group row $classMainDiv'>";
        $output .= "<div class='col-lg-12'>";
        $output .= "<label>" . $title . "</label>";
       
        $output .= "<div class='input-group date'>";
        $output .= "<div class='input-group-addon'>";
        $output .= "  ";
        $output .= "  </div>";
        $output .= "  <input type='text' autocomplete='false' readonly class='form-control pull-right date $classElement' id='$id'  $javascript value='$inputValue' name='$inputName' $attr><span class='input-group-addon'><i class='glyphicon glyphicon-th'></i></span>";
        $output .= "  </div>";
        $output .= "</div> ";
        $output .= "</div> ";
        echo $output;
    }

    public static function uploadFile($title = '', $inputName = '', $id = '', $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '')
    {

        /*
         * example:
         *
         * self::uploadFile($title = 141, $inputName = 'document_file', $id = 'document_file', $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '');
         */

        
        if (empty($title)) {
            $title = '';
        }  

        $output = "<div class='form-group row $classMainDiv'>";
        $output .= "<div class='col-lg-12'>";
        $output .= "<label>" . $title . "</label>";
       // $output .= "</div>";
       // $output .= "<div class='col-lg-9'>";
        $output .= "<input type='file'   id='$id' class='form-control $classElement' $javascript $attr >";
        $output .= "</div>";
        $output .= "</div>";

        echo $output;
    }
    public static function uploadFileUpdate($title = '', $inputName = '', $id = '', $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '')
    {

        /*
         * example:
         *
         * Mform::uploadFile($title = 141, $inputName = 'document_file', $id = 'document_file', $inputValue = '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = '');
         */

        
         if (empty($title)) {
            $title = '';
        } 


        $output = "<div class='form-group row $classMainDiv'>";
        // $output .= "<div class='col-lg-3'>";
        $output .= "<div class='col-md-12'>";
        $output .= "<label>" . $title . "</label>";
          $output .= "<div class='row'>";
         $output .= "<div class='col-md-2'>";
         $filePath = public_path()."/uploads/$inputValue";
         if(File::exists( $filePath)){
            
         $output .= "<img src='".asset("uploads/$inputValue")."' style='width:75px;height:75px;'";
         }else{
            $output .= "<img src='".asset("images/Image_not_available.png")."' style='width:75px;height:75px;'";

         }
         $output .= "</div>";
         
         $output .= "</div>";
         $output .= "<div class='col-md-10'>";
        $output .= "<input type='file'   id='$id' class='form-control $classElement' $javascript $attr style='    margin-top: 15px;'>";
        $output .= "</div>";
         
         $output .= "</div>";
         $output .= "</div>";
         $output .= "</div>";

        echo $output;
    }
 

    public static function selectArray($title = '', $selectName = '', $id = '', $classElement = '', $javascript = '', $array = array(), $inpuValue = '', $classMainDiv = '')
    {

        /*
         * example:
         *
         * self::selectArray(7016, $selectName = 'material_type', $id = 'material_type', $classElement = '', $javascript = '', $array, $inpuValue = '', $classMainDiv = '');
         */

        /* if (Input::exists()) {
        $inpuValue = Input::get($selectName);
        } else {
        // $inpuValue=-1;
        }
         */
        if (empty($title)) {
            $title = '';
        }  
        $select = "<div class='form-group $classMainDiv'>";
        $select .= "<label>" . $title . "</label>";
        $select .= "<select class='form-control select2 $classElement' $javascript name='$selectName' id='$id'>";
        if ($inpuValue == 0) {
            $select .= "<option selected value='0' > " . constant('select') . "</option>";
        } else {
            $select .= "<option value='0' > " . constant('select') . "</option>";
        }
        foreach ($array as $key => $value) {
            if ($inpuValue == $key) {
                $select .= "<option selected value='$key'>{$value}</option>";
            } else {
                $select .= "<option value='$key'>{$value}</option>";
            }
        }
        $select .= "</select>";
        $select .= "</div>";
        echo $select;
    }

     

    

    public static function select($title, $table, $selectName, $key, $value, $inpuValue = '', $classElement = '', $classMainDiv = '', $javascript = '', $where = null)
    { 
        global $style_lang, $selected_company_id, $selected_branch_id;
        /*
         * Example  :
        self::select($title=10, $table='countries' , $selectName='system_code_types', $key='id', $value='name', $inpuValue = '', $classElement = '', $classMainDiv = '',$javascript='onchange="getForm(this.value)"');
         */
        /* if (Input::exists()) {
        $inpuValue = Input::get($selectName);
        } */
        $selectName2 = __('public.select');


        $select = "<div class='form-group row $classMainDiv'>";
        $select .= "<div class='col-lg-12'>";
        $select .= "<label>" . $title . "</label>";
        
            
            if( $where != null){
              
               $whereStatment = " WHERE ";
               
               $x=1;
               foreach($where as $wheres){
                if($x < count($where)){
                    $whereStatment .= $table.'.'.$wheres[0].$wheres[1].$wheres[2] .' AND ';
                }else{
                    $whereStatment .= $table.'.'.$wheres[0].$wheres[1].$wheres[2];
                }
                 $x++;
               }
                $query = DB::select("select  *  from $table $whereStatment ORDER BY   id   ASC");
            }else{
                $query = DB::select("select  *  from $table  ORDER BY   id   ASC");
            }
         
     
        // print_object($query);
        $count =  count($query);
        $selectName=trim($selectName);
        
        $select .= "<select class='form-control select2 $classElement' name='$selectName' id='$selectName' $javascript>";
        if ($count >= 1) {
            $select .= "<option value='0'>" . $selectName2 . "</option>";

            foreach ($query  as $r) {
                $name = $r->$value;
                $id = $r->$key;
                if ($inpuValue == $id) {
                    $select .= "<option selected value='$id'>" . $name . " </option>";
                } else {
                    $select .= "<option value='$id'>" . $name . "  </option>";
                }
            }
        } else {
            $select .= "<option value='-1'> " . $selectName2 . "</option>";
        }
        $select .= "</select>";
        $select .= "</div>";
        $select .= "</div>";
        echo $select;
    }

    

    

     
 

    public static function checkbox($title = '', $inputName = '', $id = '', $inputValue = '', $classElement = '', $javascript = '', $classMainDiv = '', $style = '', $attr = '')
    {
        /* Example :

        self::checkbox($title = 1994, $inputName = 'man_power_flag', $id = 'man_power_flag', $inputValue = $man_power_flag, $class, $javascript = " onclick='if(this.value==0){this.value=1 }else{ this.value=0; } ' ");
         */

        /* if (Input::exists()) {
        $inputValue = Input::get($inputName);

        } */
        if (empty($title)) {
            $title = '';
        }  
        $data = "<div class='form-group $classMainDiv'><div class='checkbox'>";
        $data .= "<label>";
        $checked = '';
        if ($inputValue == 1) {
            $checked = ' checked  ';
        }
        $data .= "<input type='checkbox' value='$inputValue' class='$classElement' $javascript $attr id='$id' name='$inputName' $checked /><b style='$style'>" . $title . '</b>';
        $data .= "</label>";
        $data .= "</div></div>";
        echo $data;
    }

    

    public static function textarea($title = '', $inputName = '', $id = '', $inputValue = '', $classElement = '', $javascript = '', $classMainDiv = '', $style = null)
    {
         

        if (empty($title)) {
            $title = '';
        }  
        $data = "<div class = 'form-group row $classMainDiv'>";
        $data .= "<div class='col-lg-12'>";
        $data .= "<label>" . $title . "</label>";
        
        $data .= "<textarea class = 'form-control $classElement' $javascript id = '$id' name = '$inputName' style='$style'>$inputValue</textarea>";
        $data .= "</div>";
        $data .= "</div>";
        echo $data;
    }

    public static function saveBtn($inputName = '', $id = '', $title = '', $classElement = '', $javascript = '', $classMainDiv = '', $attr = '')
    {
        $data = "<div class = 'form-group $classMainDiv'>";
        $data .= "<input type = 'submit' value = '" . $title . "' class = 'btn $classElement' $javascript id = '$id' name = '$inputName' $attr />";
        $data .= "</div>";
        echo $data;
    }

    public static function Button($inputName = '', $id = '', $title = '', $classElement = '', $javascript = '', $classMainDiv = '', $attr = '',$icon='')
    {
        if (empty($title)) {
            $title = '';
        }  
        $data = "<div class = 'form-group $classMainDiv'>";
        if($id=='Save'  ){
            $data .="<button   type='button'  id = '$id' name = '$inputName'  class='btn   $classElement'   $javascript $attr> <i class='loader fa $icon'></i> " . $title . " </button>";

        }elseif($id=='Close'){
            $data .="<button   type='button' data-bs-toggle='modal'    data-bs-target='.bd-dialog-modal-lg'  data-bs-dismiss='modal' data-toggle='modal' data-target='.bd-dialog-modal-lg' id = '$id' name = '$inputName'  class='btn   $classElement'   $javascript $attr>   " . $title . " </button>";

        }else{
            $data .="<button   type='button' data-bs-toggle='modal'    data-bs-target='.bd-dialog-modal-lg'    data-toggle='modal' data-target='.bd-dialog-modal-lg' id = '$id' name = '$inputName'  class='btn   $classElement'   $javascript $attr>   " . $title . " </button>";

        }
        
        $data .= "</div>";
        echo $data;
    }

    public static function ButtonFilter($inputName = '', $id = '', $title = '', $classElement = '', $javascript = '', $classMainDiv = '', $attr = '',$icon='')
    {
        if (empty($title)) {
            $title = '';
        }  
        $data = "<div class = 'form-group $classMainDiv'>";
        
            $data .="<button   type='button'  id = '$id' name = '$inputName'  class='btn   $classElement'   $javascript $attr> <i class='loader fa $icon'></i> " . $title . " </button>";

        
        $data .= "</div>";
        echo $data;
    }
    public static function ButtonInsertNew($inputName = '', $id = '', $title = '', $classElement = '', $javascript = '', $classMainDiv = '', $attr = '',$icon='')
    {
       
       
        return  "<button   type='button'  data-toggle='modal' data-target='.bd-dialog-modal-lg' id = '$id' name = '$inputName'  class='btn   $classElement'   $javascript $attr> <i class='loader fa $icon'></i> " . $title . " </button>";

         
        
      
       
    }

    public static function ButtonHideme()
    {
        $title =  __('public.close') ;
        $classElement = 'btn btn-danger rev-popUp-btn-left';
        $javascript = 'onclick="hidepopup()"';
        $classMainDiv = 'col-lg-6 col-md-6 col-sm-6 col-xs-6 float-m-by-lang NOpadding NOmargin  rev-padding-left-5';
        $attr = '';
        if (empty($title)) {
            $title = '';
        } 
        $data = "<div class = 'form-group $classMainDiv'>";
        $data .= "<input  data-toggle='modal' data-target='.bd-dialog-modal-lg'  data-bs-dismiss='modal'  id = 'Close' name = 'Close' type='button' value = '" . $title . "' class='btn   $classElement'   $javascript $attr>";
        $data .= "</div>";
        echo $data;
    }

    public static function closeForm()
    {
        
        $data = "</div>";
        $data .= "</form>";
        echo $data;
    }

    public static function drawDivClearfix()
    {  
        $data = '<div class="clearfix"></div>';

        echo $data;
    }

    public static function DrawModal()
    {

        /*
        This function use to show ready popup box
         */
        $data = ' <div class="modal result   effect-scale    bd-dialog-modal-lg"   aria-modal="true" role="dialog"   id="modalpopup">';
         $data .= ' <div class="modal-dialog modal-lg">';
        $data .= ' <div class="modal-content result_content"></div>';
        $data .= ' </div>';
        $data .= ' </div>';
        echo $data;
    }

    public static function drawThemeModal()
    {

       /*
        This function use to show ready popup box
         */
        $data = ' <div class="modal result fade bd-dialog-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">';
         $data .= ' <div class="modal-dialog modal-lg">';
        $data .= ' <div class="modal-content result_content"></div>';
        $data .= ' </div>';
        $data .= ' </div>';
        echo $data;
    }
    public static function drawChangePasswordModal()
    {

      /*
        This function use to show ready popup box
         */
        $data = ' <div class="modal result fade bd-dialog-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">';
         $data .= ' <div class="modal-dialog modal-lg">';
        $data .= ' <div class="modal-content result_content"></div>';
        $data .= ' </div>';
        $data .= ' </div>';
        echo $data;
    }
    public static function drawUpdateProfile()
    {

        /*
        This function use to show ready popup box
         */
        $data = ' <div class="modal result fade bd-dialog-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">';
         $data .= ' <div class="modal-dialog modal-lg">';
        $data .= ' <div class="modal-content result_content"></div>';
        $data .= ' </div>';
        $data .= ' </div>';
        echo $data;
    }
    public static function drawNotification()
    {

        /*
        This function use only for theme box
         */
        $data = ' <div class = "NotificationContainer" id = "NotificationContainer"  >';
        $data .= ' <div class = "NotificationContent" id = "NotificationContent"  >';
        $data .= ' </div></div>';
        echo $data;
    }

    public static function drawCustomDiv($id)
    {
        echo "<div id='$id' class='$id'></div>";
    }

    public static function drawCustomDivIDClass($id, $class)
    {
        echo "<div id='$id' class='$class'></div>";
    }

    
    public static function MsgError($string = '')
    {
        echo "<div class='alert alert-danger text-center' style='clear:both;'><h3>$string</h3></div>";
    }

    public static function MsgSuccess($string = '')
    {
        echo "<div class='alert alert-success text-center' style='margin-top:50px;'><h3>$string</h3></div>";
    }

    public static function MsgWarning($string = '')
    {
        echo "<div class='alert alert-warning text-center'><h3>$string</h3></div>";
    }

     

     

     

    public static function rowOpen($class='')
    {
        echo "<div class='row $class'>";
    }

    public static function rowClose()
    {
        echo "</div>";
    }

    public static function openDiv($name){
        echo "<div class='$name' id='$name'>"; 
    }
    public static function closeDiv(){
        echo "</div>";
    }
}
