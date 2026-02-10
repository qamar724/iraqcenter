<?php

namespace App\Http\Controllers\SystemController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

function print_object($records)
{
    echo "<pre>";
    print_r($records);
    echo "</pre>";
}
class Menu extends Controller
{
    public static function getMenu($theme)
    {
        if (Auth::user()->tbl_users_type_id == 1) {
            if ($theme == 'adminlte') {
                self::getAdmin_AdminLteTheme();
            } elseif ($theme == 'Fit') {
                self::getAdmin_FitoTheme();
            } elseif ($theme == 'sash') {
                self::getAdmin_SashTheme();
            } elseif ($theme == 'ubold') {
                self::getAdmin_UboldTheme();
            } else {
                self::getAdmin_AdminLteTheme();
            }
        } else {
            if ($theme == 'adminlte') {
                self::getUser_AdminLteTheme();
            } elseif ($theme == 'Fit') {
                self::getUser_FitoTheme();
            } elseif ($theme == 'ubold') {
                self::getNormalUser_UboldTheme();
            } else {
                self::getUser_AdminLteTheme();
            }
        }
    }
    public static function getNormalUser_UboldTheme()
    {
        $moduleName = Route::getFacadeRoot()->current()->uri();
        $moduleName = strtolower($moduleName);
        $newName = explode('adminpanel/', $moduleName);
        $moduleName_new = $newName[1];
        $output = '<li class="menu-item">';
        $output .= '<a href="dashboard" class="menu-link">';
        $output .= '<span class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span>';
        $output .= ' <span class="menu-text">' . __("public.dashboardMenu") . ' dd</span>';
        $output .= '  </a>';
        $output .= "</li>";
        $menuLink = self::getUserMainMenu();
        if ($menuLink !== false) {
            $output = '<li class="menu-item">';
            $output .= '<a href="dashboard" class="menu-link">';
            $output .= '<span class="menu-icon">
            <i class="fas  fa-chart-line"  width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></i>
            </span>';
            $output .= ' <span class="menu-text">' . __("public.dashboardMenu") . ' </span>';
            $output .= '  </a>';
            $output .= "</li>";
            $FoucMainMenu = '';
            $activeMainMenu = '';
            // print_object($menuLink);
            foreach ($menuLink  as $record) {
                $key = $record->id;
                $val = strtolower($record->moduleName);
                $icon = ($record->icon != null) ? $record->icon : 'fa-chart-pie';
                $mainVal = $val;
                if ($moduleNameClean = self::checkString($moduleName, $mainVal)) {
                    $FoucMainMenu = 'active';
                    $activeMainMenu = 'menuitem-active';
                } else {
                    $FoucMainMenu = '';
                    $activeMainMenu = '';
                }
                $output .= ' <li class="menu-item  ' . $activeMainMenu . '">';
                $output .= '<a href="#' . $mainVal . '" data-bs-toggle="collapse" class="menu-link" aria-expanded="true">';
                $output .= ' <span class="menu-icon">
                <i class="   ' . $icon . '" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ></i>
                 </span>';
                $output .= ' <span class="menu-text">' . ucfirst(__("menu.mainmenu_$val")) . '</span>';
                $output .= '  <span class="menu-arrow"></span>';
                $output .= '  </a>';
                $subMenus = self::getSubMenusUsers($key);
                $output .= '<div class="collapse " id="' . $mainVal . '" style="">';
                if ($subMenus !== false) {
                    $output .= '<ul class="sub-menu">';
                    $activeMenu = '';
                    foreach ($subMenus as $subKey => $subVal) {
                        // $linkPage =  $val.'_'.$subVal;
                        $linkPage =  strtolower($subVal);
                        $linkPage = strtolower($linkPage);
                        if ($linkPage == $moduleName_new) {
                            $activeMenu = 'menuitem-active';
                            $activeMenuHelper = 'active';
                        } else {
                            $activeMenu = '';
                            $activeMenuHelper = '';
                        }
                        $subVal =  strtolower($subVal);
                        $output .= '<li class="menu-item ' . $activeMenu . ' ">';
                        $output .= '<a href="' . strtolower($linkPage) . '" class="menu-link ' . $activeMenuHelper . '"><span class="menu-text">' . ucfirst(__("menu.submenu_$subVal")) . '</span></a></li>';
                    }
                    $output .= '</ul>';
                }
                $output .= '</div>';
                $output .= '</li>';
            }
        }
        echo $output;
    }
    public static function getAdmin_SashTheme()
    {
        $moduleName = Route::getFacadeRoot()->current()->uri();
        $moduleName = strtolower($moduleName);
        $newName = explode('adminpanel/', $moduleName);
        $moduleName_new = $newName[1];
        $output = '<li class="slide">';
        $output .= '<a class="side-menu__item has-link" data-bs-toggle="slide" href="/dashboard"><i
        class="side-menu__icon fe fe-home"></i><span
        class="side-menu__label">' . __("public.dashboardMenu") . '</span></a>';
        $output .= "</li>";
        $menuLink = self::getMainMenu();
        if ($menuLink !== false) {
            $output = '<li class="slide">';
            $output .= '<a class="side-menu__item has-link" data-bs-toggle="slide" href="/dashboard"><i
        class="side-menu__icon fe fe-home"></i><span
        class="side-menu__label">' . __("public.dashboardMenu") . '</span></a>';
            $output .= "</li>";
            $FoucMainMenu = '';
            $activeMainMenu = '';
            foreach ($menuLink  as $record) {
                $key = $record->id;
                $val = strtolower($record->moduleName);
                $icon = ($record->icon != null) ? $record->icon : 'fa-chart-pie';
                $mainVal = $val;
                if (self::checkSubMenuBelongMainMenu($record->id)) {
                    $FoucMainMenu = 'active';
                    $activeMainMenu = 'menu-open';
                } else {
                    $FoucMainMenu = '';
                    $activeMainMenu = '';
                }
                $output .= '<li class="slide">';
                $output .= '<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                class="side-menu__icon   ' . $icon . '"></i><span
                class="side-menu__label">' . __("menu.mainmenu_$val") . '</span><i
                class="angle fe fe-chevron-right"></i>
        </a>';
                $subMenus = self::getSubMenus($key);
                if ($subMenus !== false) {
                    $output .= '<ul class="slide-menu">';
                    $activeMenu = '';
                    foreach ($subMenus as $subKey => $subVal) {
                        // $linkPage =  $val.'_'.$subVal;
                        $linkPage =  strtolower($subVal);
                        $linkPage = strtolower($linkPage);
                        if ($linkPage == $moduleName_new) {
                            $activeMenu = 'active';
                        } else {
                            $activeMenu = '';
                        }
                        $subVal =  strtolower($subVal);
                        $output .= '<li><a class="slide-item ' . $activeMenu . '" href="' . strtolower($linkPage) . '">' . __("menu.submenu_$subVal") . '</a></li>';
                    }
                    $output .= '</ul>';
                }
                $output .= '</li>';
            }
        }
        echo $output;
    }
    public static function getAdmin_UboldTheme()
    {
        $moduleName = Route::getFacadeRoot()->current()->uri();
        $moduleName = strtolower($moduleName);
        $newName = explode('adminpanel/', $moduleName);
        $moduleName_new = $newName[1];
        $output = '<li class="menu-item">';
        $output .= '<a href="dashboard" class="menu-link">';
        $output .= '<span class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span>';
        $output .= ' <span class="menu-text">' . __("public.dashboardMenu") . ' dd</span>';
        $output .= '  </a>';
        $output .= "</li>";
        $menuLink = self::getMainMenu();
        if ($menuLink !== false) {
            $output = '<li class="menu-item">';
            $output .= '<a href="dashboard" class="menu-link">';
            $output .= '<span class="menu-icon">
            <i class="fa  fa-chart-line"  width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></i>
            </span>';
            $output .= ' <span class="menu-text">' . __("public.dashboardMenu") . ' </span>';
            $output .= '  </a>';
            $output .= "</li>";
            $FoucMainMenu = '';
            $activeMainMenu = '';
            // print_object($menuLink);
            foreach ($menuLink  as $record) {
                $key = $record->id;
                $val = strtolower($record->moduleName);
                $icon = ($record->icon != null) ? $record->icon : 'fa-chart-pie';
                $mainVal = $val;
                if ($moduleNameClean = self::checkString($moduleName, $mainVal)) {
                    $FoucMainMenu = 'active';
                    $activeMainMenu = 'menuitem-active';
                } else {
                    $FoucMainMenu = '';
                    $activeMainMenu = '';
                }
                $output .= ' <li class="menu-item  ' . $activeMainMenu . '">';
                $output .= '<a href="#' . $mainVal . '" data-bs-toggle="collapse" class="menu-link" aria-expanded="true">';
                $output .= ' <span class="menu-icon">
                <i class="fa  ' . $icon . '" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ></i>
                 </span>';
                $output .= ' <span class="menu-text">' . ucfirst(__("menu.mainmenu_$val")) . '</span>';
                $output .= '  <span class="menu-arrow"></span>';
                $output .= '  </a>';
                $subMenus = self::getSubMenus($key);
                $output .= '<div class="collapse " id="' . $mainVal . '" style="">';
                if ($subMenus !== false) {
                    $output .= '<ul class="sub-menu">';
                    $activeMenu = '';
                    foreach ($subMenus as $subKey => $subVal) {
                        // $linkPage =  $val.'_'.$subVal;
                        $linkPage =  strtolower($subVal);
                        $linkPage = strtolower($linkPage);
                        if ($linkPage == $moduleName_new) {
                            $activeMenu = 'menuitem-active';
                            $activeMenuHelper = 'active';
                        } else {
                            $activeMenu = '';
                            $activeMenuHelper = '';
                        }
                        $subVal =  strtolower($subVal);
                        $output .= '<li class="menu-item ' . $activeMenu . ' ">';
                        $output .= '<a href="' . strtolower($linkPage) . '" class="menu-link ' . $activeMenuHelper . '"><span class="menu-text">' . ucfirst(__("menu.submenu_$subVal")) . '</span></a></li>';
                    }
                    $output .= '</ul>';
                }
                $output .= '</div>';
                $output .= '</li>';
            }
        }
        echo $output;
    }
    public static function getAdmin_FitoTheme()
    {
        $moduleName = Route::getFacadeRoot()->current()->uri();
        $moduleName = strtolower($moduleName);
        $newName = explode('adminpanel/', $moduleName);
        $moduleName_new = $newName[1];
        $output = '<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">';
        $output .= '<i class="flaticon-381-networking"></i>';
        $output .= ' <span class="nav-text">' . __("public.dashboardMenu") . '</span>';
        $output .= '  </a>';
        $output .= "<ul>";
        $output .= '<li><a href="dashboard">Dashboard</a></li>';
        $output .= "</ul>";
        $output .= "</li>";
        $menuLink = self::getMainMenu();
        if ($menuLink !== false) {
            $output = '<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">';
            $output .= '<i class="flaticon-381-networking"></i>';
            $output .= ' <span class="nav-text">' . __("public.dashboardMenu") . '</span>';
            $output .= '  </a>';
            $output .= "<ul>";
            $output .= '<li><a href="dashboard">Dashboard</a></li>';
            $output .= "</ul>";
            $output .= "</li>";
            $FoucMainMenu = '';
            $activeMainMenu = '';
            foreach ($menuLink  as $record) {
                $key = $record->id;
                $val = strtolower($record->moduleName);
                $icon = ($record->icon != null) ? $record->icon : 'fa-chart-pie';
                $mainVal = $val;
                if ($moduleNameClean = self::checkString($moduleName, $mainVal)) {
                    $FoucMainMenu = 'active';
                    $activeMainMenu = 'menu-open';
                } else {
                    $FoucMainMenu = '';
                    $activeMainMenu = '';
                }
                $output .= '<li><a class="has-arrow  " href="javascript:void()" aria-expanded="false">';
                $output .= '<i class="' . $icon . '"></i>';
                $output .= ' <span class="nav-text">' . ucfirst(__("menu.mainmenu_$val")) . '</span>';
                $output .= '  </a>';
                $subMenus = self::getSubMenus($key);
                if ($subMenus !== false) {
                    $output .= '<ul>';
                    $activeMenu = '';
                    foreach ($subMenus as $subKey => $subVal) {
                        // $linkPage =  $val.'_'.$subVal;
                        $linkPage =  strtolower($subVal);
                        $linkPage = strtolower($linkPage);
                        if ($linkPage == $moduleName_new) {
                            $activeMenu = 'active';
                        } else {
                            $activeMenu = '';
                        }
                        $subVal =  strtolower($subVal);
                        $output .= '<li><a href="' . strtolower($linkPage) . '">' . ucfirst(__("menu.submenu_$subVal")) . '</a></li>';
                    }
                    $output .= '</ul>';
                }
                $output .= '</li>';
            }
        }
        echo $output;
    }
    public static function getUser_FitoTheme()
    {
        $moduleName = Route::getFacadeRoot()->current()->uri();
        $moduleName = strtolower($moduleName);
        $newName = explode('adminpanel/', $moduleName);
        $moduleName_new = $newName[1];
        $output = '<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">';
        $output .= '<i class="flaticon-381-networking"></i>';
        $output .= ' <span class="nav-text">' . __("public.dashboardMenu") . '</span>';
        $output .= '  </a>';
        $output .= "<ul>";
        $output .= '<li><a href="dashboard">Dashboard</a></li>';
        $output .= "</ul>";
        $output .= "</li>";
        $menuLink = self::getUserMainMenu();
        if ($menuLink !== false) {
            $output = '<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">';
            $output .= '<i class="flaticon-381-networking"></i>';
            $output .= ' <span class="nav-text">' . __("public.dashboardMenu") . '</span>';
            $output .= '  </a>';
            $output .= "<ul>";
            $output .= '<li><a href="dashboard">Dashboard</a></li>';
            $output .= "</ul>";
            $output .= "</li>";
            $FoucMainMenu = '';
            $activeMainMenu = '';
            foreach ($menuLink  as $record) {
                $key = $record->id;
                $val = strtolower($record->moduleName);
                $icon = ($record->icon != null) ? $record->icon : 'fa-chart-pie';
                // value = name
                $mainVal = $val;
                if (self::checkSubMenuBelongMainMenu($record->id)) {
                    $FoucMainMenu = 'active';
                    $activeMainMenu = 'menu-open';
                } else {
                    $FoucMainMenu = '';
                    $activeMainMenu = '';
                }
                $output .= '<li><a class="has-arrow  " href="javascript:void()" aria-expanded="false">';
                $output .= '<i class="' . $icon . '"></i>';
                $output .= ' <span class="nav-text">' . ucfirst(__("menu.mainmenu_$val")) . '</span>';
                $output .= '  </a>';
                $subMenus = self::getSubMenusUsers($key);;
                if ($subMenus !== false) {
                    $output .= '<ul>';
                    $activeMenu = '';
                    foreach ($subMenus as $subKey => $subVal) {
                        // $linkPage =  $val.'_'.$subVal;
                        $linkPage =   $subVal;
                        $linkPage = strtolower($linkPage);
                        if ($linkPage == $moduleName_new) {
                            $activeMenu = 'active';
                        } else {
                            $activeMenu = '';
                        }
                        $output .= '<li><a href="' . strtolower($linkPage) . '">' . ucfirst(__("menu.submenu_$subVal")) . '</a></li>';
                    }
                    $output .= '</ul>';
                }
                $output .= '</li>';
            }
        }
        echo $output;
    }
    public static function getUser_AdminLteTheme()
    {
        $moduleName = Route::getFacadeRoot()->current()->uri(); // adminPanel/tasks_no_action_task
        $moduleName = strtolower($moduleName);
        $newName = explode('adminpanel/', $moduleName);
        //  print_object($newName);
        $moduleName_new = $newName[1];
        $output = '<nav class="mt-2">';
        $output .= '<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">';
        // start dashboard static page
        $output .= '<li class="nav-item  ">';
        $output .= '   <a href="#" class="nav-link  ">';
        $output .= '     <i class="nav-icon fas fa-tachometer-alt"></i>';
        $output .= '     <p>';
        $output .= __("public.dashboardMenu");;
        $output .= '       <i class="right fas fa-angle-left"></i>';
        $output .= '     </p>';
        $output .= '   </a>';
        $output .= '   <ul class="nav nav-treeview">';
        $output .= '     <li class="nav-item">';
        $output .= '       <a href="mainPage" class="nav-link active">';
        $output .= '         <i class="far fa-circle nav-icon"></i>';
        $output .= '         <p>Dashboard  </p>';
        $output .= '       </a>';
        $output .= '     </li>';
        $output .= '   </ul>';
        $output .= ' </li>';
        // end dashboard static page
        $menuLink = self::getUserMainMenu();
        if ($menuLink !== false) {
            //   print_object($menuLink);
            //   die();
            $FoucMainMenu = '';
            $activeMainMenu = '';
            foreach ($menuLink  as $record) {
                $key = $record->id;
                $val = strtolower($record->moduleName); // tasks
                $icon = ($record->icon != null) ? $record->icon : 'fa-chart-pie';
                // value = name
                $mainVal = $val;
                if (self::getUserMainMenu($record->id)) {
                    $FoucMainMenu = 'active';
                    $activeMainMenu = 'menu-open';
                } else {
                    $FoucMainMenu = '';
                    $activeMainMenu = '';
                }
                $output .= '<li class="nav-item ' . strtolower($activeMainMenu) . '">';
                $output .= '<a href="#" class="nav-link ' . $FoucMainMenu . ' ">';
                $output .= '<i class="nav-icon fas ' . $icon . '"></i>';
                $output .= '<p>';
                $output .= ucfirst(__("menu.mainmenu_$val"));
                $output .= '  <i class="right fas fa-angle-left"></i>';
                $output .= '</p>';
                $output .= '</a>';
                $output .= '<ul class="nav nav-treeview">';
                $subMenus = self::getSubMenusUsers($key);;
                //  print_object($subMenus);
                //
                if ($subMenus !== false) {
                    $activeMenu = '';
                    foreach ($subMenus as $subKey => $subVal) {
                        // $linkPage =  $val.'_'.$subVal;
                        $linkPage =  $subVal;
                        if ($linkPage == $moduleName_new) {
                            $activeMenu = 'active';
                        } else {
                            $activeMenu = '';
                        }
                        $output .= '<li class="nav-item ">';
                        $output .= '<a href="' . strtolower($linkPage) . '" class="nav-link ' . $activeMenu . '">';
                        $output .= '  <i class="far fa-circle nav-icon"></i>';
                        $output .= '  <p>' . ucfirst(__("menu.submenu_$subVal")) . '</p>';
                        $output .= ' </a>';
                        $output .= ' </li>';
                    }
                }
                $output .= '</ul>';
                $output .= '</li>';
            }
        }
        $output .= ' </ul>';
        $output .= '</nav>';
        echo $output;
    }
    public static function getAdmin_AdminLteTheme()
    {
        $moduleName = Route::getFacadeRoot()->current()->uri();
        $moduleName = strtolower($moduleName);
        //$ex = explode('_', $moduleName);
        //$string = $ex[0];
        $newName = explode('adminpanel/', $moduleName);
        //  print_object($newName);
        $moduleName_new = $newName[1];
        $output = '<nav class="mt-2">';
        $output .= '<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">';
        // start dashboard static page
        $output .= '<li class="nav-item  ">';
        $output .= '   <a href="#" class="nav-link  ">';
        $output .= '     <i class="nav-icon fas fa-tachometer-alt"></i>';
        $output .= '     <p>';
        $output .= __("public.dashboardMenu");;
        $output .= '       <i class="right fas fa-angle-left"></i>';
        $output .= '     </p>';
        $output .= '   </a>';
        $output .= '   <ul class="nav nav-treeview">';
        $output .= '     <li class="nav-item">';
        $output .= '       <a href="mainPage" class="nav-link active">';
        $output .= '         <i class="far fa-circle nav-icon"></i>';
        $output .= '         <p>Dashboard  </p>';
        $output .= '       </a>';
        $output .= '     </li>';
        $output .= '   </ul>';
        $output .= ' </li>';
        // end dashboard static page
        $menuLink = self::getMainMenu();
        if ($menuLink !== false) {
            //  print_object($menuLink);
            $FoucMainMenu = '';
            $activeMainMenu = '';
            foreach ($menuLink  as $record) {
                $key = $record->id;
                $val = strtolower($record->moduleName);
                $icon = ($record->icon != null) ? $record->icon : 'fa-chart-pie';
                // value = name
                $mainVal = $val;
                //self::checkBelongMainMenu();
                if (self::checkSubMenuBelongMainMenu($record->id)) {
                    $FoucMainMenu = 'active';
                    $activeMainMenu = 'menu-open';
                } else {
                    $FoucMainMenu = '';
                    $activeMainMenu = '';
                }
                $output .= '<li class="nav-item ' . strtolower($activeMainMenu) . '">';
                $output .= '<a href="#" class="nav-link ' . $FoucMainMenu . ' ">';
                $output .= '<i class="nav-icon fas ' . $icon . '"></i>';
                $output .= '<p>';
                $output .= ucfirst(__("menu.mainmenu_$val"));
                $output .= '  <i class="right fas fa-angle-left"></i>';
                $output .= '</p>';
                $output .= '</a>';
                $output .= '<ul class="nav nav-treeview">';
                $subMenus = self::getSubMenus($key);
                //print_object($subMenus);
                //
                if ($subMenus !== false) {
                    $activeMenu = '';
                    foreach ($subMenus as $subKey => $subVal) {
                        //$linkPage =  $val.'_'.$subVal;
                        $linkPage =   $subVal;
                        $linkPage = strtolower($linkPage);
                        if ($linkPage == $moduleName_new) {
                            $activeMenu = 'active';
                        } else {
                            $activeMenu = '';
                        }
                        $output .= '<li class="nav-item ">';
                        $output .= '<a href="' . strtolower($linkPage) . '" class="nav-link ' . $activeMenu . '">';
                        $output .= '  <i class="far fa-circle nav-icon"></i>';
                        $output .= '  <p>' . ucfirst(__("menu.submenu_$subVal")) . '</p>';
                        $output .= ' </a>';
                        $output .= ' </li>';
                    }
                }
                $output .= '</ul>';
                $output .= '</li>';
            }
        }
        $output .= ' </ul>';
        $output .= '</nav>';
        echo $output;
    }
    private static function checkSubMenuBelongMainMenu($tbl_adv_menu_id)
    {
        $url = URL::current();
        $explode = explode('/', parse_url($url, PHP_URL_PATH));
        $subMenuURL = last($explode);
        $rowCount = DB::table('tbl_adv_menu_sub')
            ->where('tbl_adv_menu_id', $tbl_adv_menu_id)
            ->where('link', $subMenuURL)
            ->count();
        if ($rowCount >= 1) {
            return true;
        }
        return false;
    }
    public static function checkString($string, $word)
    {
        $ex = explode('_', $string);
        $string = $ex[0];
        $newName = explode('adminpanel/', $string);
        $string = $newName[1];
        if ($string == $word) {
            return true;
        }
        return false;
    }
    public static function checkStringNormalUser($string, $word)
    {
        $ex = explode('_', $string);
        $string = $ex[0];
        $newName = explode('adminpanel/', $string);
        $string = $newName[1];
        if ($string == $word) {
            return true;
        }
        return false;
    }
    public static function getMenuAlias($id)
    {
        $records = DB::select("select * from tbl_adv_menu where id='$id'");
        if (count($records) >= 1) {
            foreach ($records as $record) {
                return $record->menuAlias;
            }
        }
    }
    public static function getUserSubmenusAdminLte($tbl_adv_menu_id)
    {
        $tbl_users_type_id = Auth::user()->tbl_users_type_id;
        $sql = "SELECT
        tbl_adv_menu.moduleName,
        tbl_adv_menu_sub.page_name,
        tbl_adv_menu_sub.link
    FROM
        `tbl_permissions`
    JOIN tbl_adv_menu ON tbl_permissions.tbl_adv_menu_id = tbl_adv_menu.id
    JOIN tbl_adv_menu_sub ON tbl_permissions.tbl_adv_menu_sub_id = tbl_adv_menu_sub.id
    WHERE
         tbl_users_type_id = $tbl_users_type_id AND 
         tbl_permissions.tbl_actions_id = 1 and 
         tbl_permissions.tbl_adv_menu_id=$tbl_adv_menu_id
         order by tbl_adv_menu_sub.sort asc 
          ";
        $menus = array();
         $records =  DB::select( $sql );;
        if (count($records) >= 1) {
            foreach ($records as $record) {
                $menus[$record->page_name] = $record->link;
            }
            return $menus;
        }
        return false;
    }
    public static function getSubMenusUsers($tbl_adv_menu_id)
    {
        $created_by_user_id = Permission::getSuperAdmin();
        $tbl_users_type_id = Auth::user()->tbl_users_type_id;
        $sql = "SELECT 
        tbl_permissions.id as permission_id,
        tbl_permissions.tbl_actions_id as action_id,
        tbl_permissions.tbl_users_type_id as tbl_users_type_id,
        tbl_adv_menu.moduleName as moduleName,
        tbl_adv_menu_sub.page_name as page_name,
        tbl_adv_menu_sub.link as link,
        tbl_adv_menu_sub.sort as sortPage
        FROM `tbl_permissions`  
        JOIN tbl_adv_menu on tbl_adv_menu.id = tbl_permissions.tbl_adv_menu_id
        join tbl_adv_menu_sub on tbl_adv_menu_sub.id = tbl_permissions.tbl_adv_menu_sub_id
        WHERE 
        tbl_permissions.tbl_adv_menu_id='$tbl_adv_menu_id' 
        and 
        tbl_permissions.users_id=$created_by_user_id 
        and 
        tbl_permissions.tbl_users_type_id=$tbl_users_type_id 
        and tbl_permissions.tbl_actions_id=1";
        if (env('SYSTEM_ENV') == 'saas') {
            $sql .= " and tbl_adv_menu_sub.permission_type_id in(2,3) ";
        }
        $sql .= " ORDER BY tbl_adv_menu_sub.sort  asc;";
        $records = DB::select($sql);
        $menus = array();
        if (count($records) >= 1) {
            foreach ($records as $record) {
                $menus[$record->page_name] = $record->link;
            }
            return $menus;
        }
        return false;
    }
    public static function getSubMenus($tbl_adv_menu_id)
    {
        if (env('SYSTEM_ENV') == 'saas') {
            $records = DB::select("select * from tbl_adv_menu_sub where tbl_adv_menu_id='$tbl_adv_menu_id'  and hidden=0 and permission_type_id in(1,3) order by sort asc");
        } else {
            $records = DB::select("select * from tbl_adv_menu_sub where tbl_adv_menu_id='$tbl_adv_menu_id'  and hidden=0 order by sort asc");
        }
        $menus = array();
        if (count($records) >= 1) {
            foreach ($records as $record) {
                $menus[$record->page_name] = $record->link;
            }
            return $menus;
        }
        return false;
    }
    public static function getMainMenu()
    {
        $records = DB::select("select * from tbl_adv_menu  ORDER BY `tbl_adv_menu`.`sort` ASC");
        $menus = array();
        if (count($records) >= 1) {
             return $records;
        }
        return false;
    }
    public static function getUserMainMenu()
    {
        $tbl_users_type_id = Auth::user()->tbl_users_type_id;
   
        $sql = "SELECT
tbl_adv_menu.moduleName AS moduleName,
tbl_adv_menu.id AS id,
tbl_adv_menu.icon AS icon
FROM
`tbl_permissions`
JOIN
tbl_adv_menu ON tbl_permissions.tbl_adv_menu_id = tbl_adv_menu.id
JOIN
tbl_adv_menu_sub ON tbl_adv_menu_sub.tbl_adv_menu_id = tbl_adv_menu.id
WHERE
tbl_users_type_id = $tbl_users_type_id
AND tbl_permissions.tbl_actions_id = 1
GROUP BY
tbl_adv_menu.moduleName,
tbl_adv_menu.id,
tbl_adv_menu.icon
ORDER BY
MIN(tbl_adv_menu.sort) ASC";
        $records =  DB::select($sql);;
        $menus = array();
        if (count($records) >= 1) {
       
            return $records;
        }
        return false;
    }
    public function users()
    {
        return view('adminstrator.users');
    }
}
