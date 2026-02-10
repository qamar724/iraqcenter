<?php
use App\Http\Controllers\SystemController\System;  
use App\Http\Controllers\SystemController\Mform;  
use App\Http\Controllers\SystemController\Cookies;  
// 8895654566  
$FolderName =  "";   
$table = "" ;   
$lang =app()->getLocale(); ;   
//System::Package($FolderName); ;   
Mform::openDiv("modal-header");
echo "<h5> ".__("public.themeForm")." </h5>";
Mform::closeDiv();
Mform::openDiv("modal-body");
/**********Start draw elements  (Please check mform class documentation ) *************/   
 
  $themeMode = '';
  $menuStyle = '';
  $menuType = '';
  $menuPosition = '';
  $headerBg = '';
  $navheaderBg = '';
  $sidebarBg = '';
  $headerPosition = '';
  $containerLayout = '';
  if(Cookies::exists('themeMode')){
    $themeMode = Cookies::get('themeMode');
  }
  if(Cookies::exists('menuStyle')){
    $menuStyle = Cookies::get('menuStyle');
  }
  if(Cookies::exists('menuType')){
    $menuType = Cookies::get('menuType');
  }
  if(Cookies::exists('menuPosition')){
    $menuPosition = Cookies::get('menuPosition');
  }
  if(Cookies::exists('headerBg')){
       $headerBg = Cookies::get('headerBg');
  }
  if(Cookies::exists('navheaderBg')){
    $navheaderBg = Cookies::get('navheaderBg');
  }
  if(Cookies::exists('sidebarBg')){
    $sidebarBg = Cookies::get('sidebarBg');
  }
  if(Cookies::exists('headerPosition')){
    $headerPosition = Cookies::get('headerPosition');
  }
  if(Cookies::exists('containerLayout')){
    $containerLayout = Cookies::get('containerLayout');
  }
 ?>
 <div class="row">
 <div class="form-group col-lg-6 col-md-6">
    <label >Theme Mode</label>
      <select class="form-control" id="themeMode" onchange="setThemeMode()">
        <option value="light" @if($themeMode =='light') selected @endif>Light</option>
        <option value="dark"  @if($themeMode =='dark') selected @endif>Dark</option>
      
      </select>
  </div>
 <div class="form-group  col-lg-6 col-md-6">
    <label >Menu Style</label>
      <select class="form-control" id="menuStyle" onchange="setmenuStyle()">
        <option value="Vertical" @if($menuStyle =='Vertical') selected @endif>Vertical</option>
        <option value="horizontal" @if($menuStyle =='horizontal') selected @endif>Horizontal</option>
    
      </select>
  </div>
 
</div>

<div class="row"> 
<div class="form-group  col-lg-6 col-md-6">
    <label >Menu Type</label>
      <select class="form-control"  id="menuType" onchange="setmenuType()">
        <option value="full" @if($menuType =='full') selected @endif>Full</option>
        <option value="compact" @if($menuType =='compact') selected @endif>Compact</option>
        <option value="modern" @if($menuType =='modern') selected @endif>Modern</option>
        <option value="mini" @if($menuType =='mini') selected @endif>Mini</option>
      </select>
  </div>
  <div class="form-group  col-lg-6 col-md-6">
    <label >containerLayout</label>
      <select class="form-control"  id="containerLayout" onchange="setcontainerLayout()">
        <option value="boxed" @if($containerLayout =='boxed') selected @endif>boxed</option>
        <option value="wide" @if($containerLayout =='wide') selected @endif>wide</option>
        <option value="wide-boxed" @if($containerLayout =='wide-boxed') selected @endif>wide-boxed</option>
        <option value="mini" @if($containerLayout =='mini') selected @endif>Mini</option>
      </select>
  </div>
  </div>
  <div class="row"> 
    <div class="form-group  col-lg-6 col-md-6">
    <label >Menu Position</label>
      <select class="form-control"  id="menuPosition" onchange="setmenuPosition()">
      <option value="-1"  >Select</option>
        <option value="fixed"  @if($menuPosition =='fixed') selected @endif>Fixed</option>
        <option value="static"  @if($menuPosition =='static') selected @endif>Static</option>
      </select>
  </div>
  <div class="form-group  col-lg-6 col-md-6">
    <label >Header Position</label>
      <select class="form-control"  id="headerPosition" onchange="setheaderPosition()">
      <option value="-1"  >Select</option>
        <option value="fixed"  @if($headerPosition =='fixed') selected @endif>Fixed</option>
        <option value="static"  @if($headerPosition =='static') selected @endif>Static</option>
      </select>
  </div>
  </div>

  <div class="row">
    <div class="form-group  col-lg-6 col-md-6">
    <label >headerBg Color</label>
      <select class="form-control"  id="headerBg" onchange="setheaderBgColor()">
        <option value="color_1"  @if($headerBg =='color_1') selected @endif>color_1</option>
        <option value="color_2"  @if($headerBg =='color_2') selected @endif>color_2</option>
        <option value="color_3"  @if($headerBg =='color_3') selected @endif>color_3</option>
        <option value="color_4"  @if($headerBg == 'color_4') selected @endif>color_4</option>
        <option value="color_5"  @if($headerBg =='color_5') selected @endif>color_5</option>
        <option value="color_6"  @if($headerBg =='color_6') selected @endif>color_6</option>
        <option value="color_7"  @if($headerBg =='color_7') selected @endif>color_7</option>
        <option value="color_8"  @if($headerBg =='color_8') selected @endif>color_8</option>
        <option value="color_9"  @if($headerBg =='color_9') selected @endif>color_9</option>
     
       
      </select>
  </div>
  <div class="form-group  col-lg-6 col-md-6">
    <label >Logo Background</label>
      <select class="form-control"  id="navheaderBg" onchange="setnavheaderBg()">
        <option value="color_1"  @if($navheaderBg =='color_1') selected @endif>color_1</option>
        <option value="color_2"  @if($navheaderBg =='color_2') selected @endif>color_2</option>
        <option value="color_3"  @if($navheaderBg =='color_3') selected @endif>color_3</option>
        <option value="color_4"  @if($navheaderBg =='color_4') selected @endif>color_4</option>
        <option value="color_5"  @if($navheaderBg =='color_5') selected @endif>color_5</option>
        <option value="color_6"  @if($navheaderBg =='color_6') selected @endif>color_6</option>
        <option value="color_7"  @if($navheaderBg =='color_7') selected @endif>color_7</option>
        <option value="color_8"  @if($navheaderBg =='color_8') selected @endif>color_8</option>
        <option value="color_9"  @if($navheaderBg =='color_9') selected @endif>color_9</option>
       
      </select>
  </div>
  </div>
  <div class="row"> 
    <div class="form-group  col-lg-6 col-md-6">
    <label >Menu Background</label>
      <select class="form-control"  id="sidebarBg" onchange="setsidebarBg()">
        <option value="color_1"  @if($sidebarBg =='color_1') selected @endif>color_1</option>
        <option value="color_2"  @if($sidebarBg =='color_2') selected @endif>color_2</option>
        <option value="color_3"  @if($sidebarBg =='color_3') selected @endif>color_3</option>
        <option value="color_4"  @if($sidebarBg =='color_4') selected @endif>color_4</option>
        <option value="color_5"  @if($sidebarBg =='color_5') selected @endif>color_5</option>
        <option value="color_6"  @if($sidebarBg =='color_6') selected @endif>color_6</option>
        <option value="color_7"  @if($sidebarBg =='color_7') selected @endif>color_7</option>
        <option value="color_8"  @if($sidebarBg =='color_8') selected @endif>color_8</option>
        <option value="color_9"  @if($sidebarBg =='color_9') selected @endif>color_9</option>
       
      </select>
  </div>
  </div>


    

 <?php  
   
/*********End draw elemets*********/   
Mform::drawCustomDivIDClass("errorsResults","errorsResults");   
Mform::openDiv("modal-footer");   
 Mform::Button($inputName = "Close", $id = "Close", $title = __("public.close") , $classElement = "btn btn-danger ", $javascript =    'onclick="hidepopup()"' , $classMainDiv = " ", $attr = "");   
Mform::closeDiv();  
Mform::hidden($inputName = "table", $id = "table", $inputValue = $table, $class = "");   
Mform::drawCloseDiv();    
 Mform::AjaxJSFile($FolderName);      
// Mform::MainPageJs($FolderName);     
?>    
