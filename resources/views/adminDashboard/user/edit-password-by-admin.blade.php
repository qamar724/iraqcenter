<?php 
use App\Http\Controllers\SystemController\Mform;  
 
 
Mform::openDiv("modal-header");
   echo "<h5> ".__('public.changepasswordToUser')." </h5>";
   Mform::closeDiv();
   Mform::openDiv("modal-body");

Mform::rowOpen();
 
Mform::password($title = __('public.newpassword'), $inputName = 'password', $id = 'password'  , $inputValue =   '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = 'col-lg-12');
Mform::password($title = __('public.repeatpassword'), $inputName = 'confirm_password', $id = 'confirm_password'  , $inputValue =   '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = 'col-lg-12');



Mform::rowClose();
Mform::drawCustomDiv('errorsResults');
Mform::openDiv("modal-footer");
Mform::Button($inputName = "Save", $id = "Save", $title = __("public.save") , $classElement = "btn btn-primary ", $javascript = 'onclick="ConfirmchangePasswordFromAdmin()"', $classMainDiv = "", $attr = "");   
Mform::Button($inputName = "Close", $id = "Close", $title =  __("public.close") , $classElement = "btn btn-danger ", $javascript =    'onclick="hidepopup()"' , $classMainDiv = "", $attr = "");   
Mform::closeDiv();
Mform::drawCloseDiv(); 
?>
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<input type="hidden" name="selectedUserid" id="selectedUserid" value="{{ $selectedUserid }}">
 