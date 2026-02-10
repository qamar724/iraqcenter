<?php 
use App\Http\Controllers\SystemController\Mform;  

 
Mform::openDiv("modal-header");
   echo "<h5> ".__('public.accountSetting')." </h5>";
   Mform::closeDiv();
   Mform::openDiv("modal-body");
Mform::rowOpen();
Mform::text($title = __('public.users_name'), $inputName = 'name', $id = 'name'  , $inputValue =  Auth::user()->name, $classElement = '', $javascript = '', $attr = '', $classMainDiv = 'col-lg-6 d-flex justify-content-center');
Mform::text($title = __('public.users_email'), $inputName = 'email', $id = 'email'  , $inputValue =  Auth::user()->email, $classElement = '', $javascript = '', $attr = '', $classMainDiv = 'col-lg-6 d-flex justify-content-center');

Mform::rowClose();
Mform::rowOpen();
Mform::UploadFile($title = __("public.profile_photo") , $inputName = "profile_photo_path", $id = "profile_photo_path", $inputValue = "", $classElement = "", $javascript = "", $attr = "", $classMainDiv = "col-lg-6");

Mform::rowClose();


Mform::drawCustomDiv('profileResult');
Mform::openDiv("modal-footer");
Mform::saveBtn($inputName = 'Save', $id = 'upload', $title = __('public.sure'), $classElement = 'btn btn-primary', $javascript = 'onclick="ConfirmProfile()"', $classMainDiv = ' ', $attr = '');
Mform::Button($inputName = 'Close', $id = 'Close', $title = __('public.close'), $classElement = 'btn btn-danger ', $javascript = 'onclick="hidepopupProfile()"', $classMainDiv = ' ', $attr = '');
Mform::closeDiv();

Mform::drawCloseDiv(); 
?>

<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">