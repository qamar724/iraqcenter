<?php 
use App\Http\Controllers\SystemController\Mform;  

 
Mform::openDiv("modal-header");
   echo "<h5> ".__('public.changepassword')." </h5>";
   Mform::closeDiv();
   Mform::openDiv("modal-body");

Mform::rowOpen();
 
Mform::password($title = __('public.currentpassword'), $inputName = 'currentPassword', $id = 'currentPassword'  , $inputValue =   '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = 'col-lg-12');
Mform::password($title = __('public.newpassword'), $inputName = 'newPassword', $id = 'newPassword'  , $inputValue =   '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = 'col-lg-12');
Mform::password($title = __('public.repeatpassword'), $inputName = 'repeatPassword', $id = 'repeatPassword'  , $inputValue =   '', $classElement = '', $javascript = '', $attr = '', $classMainDiv = 'col-lg-12');



Mform::rowClose();
Mform::drawCustomDiv('changePasswordResult');
Mform::openDiv("modal-footer");
Mform::saveBtn($inputName = 'Save', $id = 'upload', $title = __('public.sure'), $classElement = 'btn btn-primary  ', $javascript = 'onclick="ConfirmchangePassword()"', $classMainDiv = ' ', $attr = '');
Mform::Button($inputName = 'Close', $id = 'Close', $title = __('public.close'), $classElement = 'btn btn-danger  ', $javascript = 'onclick="hidepopupChangePassword()"', $classMainDiv = ' ', $attr = '');
Mform::closeDiv();
Mform::drawCloseDiv(); 
?>
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">