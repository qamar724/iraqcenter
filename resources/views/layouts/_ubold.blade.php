<?php
use App\Http\Controllers\SystemController\Menu;
use App\Http\Controllers\SystemController\Mform;
use App\Http\Controllers\SystemController\LanguageController;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;

$input = config('app.lang_config');
$languages = json_decode($input);

$directory = [
    'en' => 'ltr',
    'ar' => 'rtl',
    'ru' => 'ltr',
    'tr' => 'ltr',
    'hi' => 'ltr',
    'ge' => 'ltr',
    'ch' => 'ltr',
    'ind' => 'ltr',
    'ft' => 'ltr',
    'it' => 'ltr',
    'sp' => 'ltr',
    'sw' => 'ltr',
    'al' => 'ltr',
    'hu' => 'ltr',
];

$lang = Cookie::get('lang') != '' ? Cookie::get('lang') : config('app.locale');

$dir = $directory[$lang];
$nextLang = 'en';
if ($lang == 'ar') {
    $nextLang = 'en';
} else {
    $nextLang = 'ar';
}
?>

<!DOCTYPE html>
<html dir="{{ $dir }}" lang="{{ $lang }}">

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- plugin css -->
    <link href="{{ asset('ubold/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Theme Config Js -->
    <script src="{{ asset('ubold/assets/js/head.js') }}"></script>

    <!-- Bootstrap css -->
    <link href="{{ asset('ubold/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('css/common.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- App css -->
    @if ($dir == 'rtl')
        <link href="{{ asset('ubold/assets/css/app-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    @else
        <link href="{{ asset('ubold/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    @endif
    <link href="{{ asset('ubold/assets/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('ubold/assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons css -->
    <link href="{{ asset('ubold/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('plugins/chartjs/utils.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datepicker/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/build/toastr.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/lightbox/css/lightbox.min.css') }}">
    <!-- PWA  -->
    <meta name="theme-color" content="#177FD3" />
    <link rel="apple-touch-icon" href="{{ asset('images/logo_wpa.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

</head>
<style>
#filterDialog {
    z-index: 1040 !important;   
    position: relative;
}

.select2-container--default .select2-dropdown {
    z-index: 1051 !important;   
}
</style>
<body>

    <!-- Begin page -->
    <div id="wrapper">


        <!-- ========== Menu ========== -->
        <div class="app-menu">

            <!-- Brand Logo -->
            <div class="logo-box">
                <!-- Brand Logo Light -->
                <a href="index.html" class="logo-light">
                    <img src="{{ asset('images/title.png') }}" alt="logo" class="logo-lg">
                    <img src="{{ asset('images/title.png') }}" alt="small logo" class="logo-sm">
                </a>

                <!-- Brand Logo Dark -->
                <a href="index.html" class="logo-dark">
                    <img src="{{ asset('images/title.png') }}" alt="dark logo" class="logo-lg">
                    <img src="{{ asset('images/title.png') }}" alt="small logo" class="logo-sm">
                </a>
            </div>

            <!-- menu-left -->
            <div class="scrollbar">

                <!-- User box -->
                <div class="user-box text-center">


                    <?php
                            
                        $User_profilePhoto=Auth::user()->profile_photo_path;

                        if ($User_profilePhoto == "") {
                            ?>
                    <img src="{{ asset('images/users/1.jpg') }}" class="rounded-circle avatar-md"
                        title="{{ Auth::user()->name }}" width="31">
                    <?php
                        } else {
                            $userPhoto =  public_path()."/uploads/$User_profilePhoto";
                            if (file_exists($userPhoto)) {
                                ?>
                    <img src="{{ asset("uploads/$User_profilePhoto") }}" class="rounded-circle avatar-md">
                    <?php
                            } else {
                                ?>
                    <img src="{{ asset('images/users/1.jpg') }}" class="rounded-circle avatar-md">
                    <?php
                            }
                        }
                        ?>


                    <div class="dropdown">
                        <a href="javascript: void(0);" class="dropdown-toggle h5 mb-1 d-block"
                            data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
                        <div class="dropdown-menu user-pro-dropdown">

                            <!-- item-->
                            <a href="javascript:void(0);" data-toggle="modal" data-target=".bd-dialog-modal-lg"
                                onclick="getUpdateForm()" class="dropdown-item notify-item">
                                <i class="fe-user me-1"></i>
                                <span>{{ __('public.profileSetting') }}</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" data-toggle="modal" data-target=".bd-dialog-modal-lg"
                                onclick="getFormToChangePassword()" class="dropdown-item notify-item">
                                <i class="fe-settings me-1"></i>
                                <span>{{ __('public.changepassword') }}</span>
                            </a>



                            <!-- item-->
                            <a href="logout" class="dropdown-item notify-item">
                                <i class="fe-log-out me-1"></i>
                                <span>{{ __('public.logout') }}</span>
                            </a>

                        </div>
                    </div>

                </div>

                <!--- Menu -->
                <ul class="menu">


                    {{ Menu::getMenu(config('app.theme')) }}





                </ul>
                <!--- End Menu -->
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- ========== Left menu End ========== -->





        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">

            <!-- ========== Topbar Start ========== -->
            <div class="navbar-custom">
                <div class="topbar">
                    <div class="topbar-menu d-flex align-items-center gap-1">

                        <!-- Topbar Brand Logo -->


                        <!-- Sidebar Menu Toggle Button -->
                        <button class="button-toggle-menu">
                            <i class="mdi mdi-menu"></i>
                        </button>


                    </div>

                    <ul class="topbar-menu d-flex align-items-center">


                        <!-- Fullscreen Button -->
                        <li class="d-none d-md-inline-block">
                            <a class="nav-link waves-effect waves-light" href="" data-toggle="fullscreen">
                                <i class="fe-maximize font-22"></i>
                            </a>
                        </li>




                        <!-- Language flag dropdown  -->
                        <li class="dropdown d-none d-md-inline-block">
                            <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none"
                                data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                                aria-expanded="false">
                                <img src="{{ asset("flags/$lang") }}.svg" alt="user-image" class="me-0 me-sm-1"
                                    height="18">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated">


                                <?php
                                    $countLang = count($languages);
                                
                                if($countLang >= 1){
                                    foreach($languages as $key ){
                                    ?>

                                <!-- item-->
                                <a href="javascript:void(0);" onclick="changeLangTO('<?php echo $key; ?>')"
                                    class="dropdown-item">
                                    <img src="{{ asset("flags/$key") }}.svg" alt="user-image" class="me-1"
                                        height="12"> <span class="align-middle">{{ $key }}</span>
                                </a>




                                <?php
                                                                        }
                                                                    }
                                                                    
                                                                    ?>

                            </div>
                        </li>

                        <!-- Notofication dropdown -->
                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none"
                                data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                                aria-expanded="false">
                                <i class="fe-bell font-22"></i>
                                <span class="badge bg-danger rounded-circle noti-icon-badge">9</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                                <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 font-16 fw-semibold"> Notification</h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="javascript: void(0);"
                                                class="text-dark text-decoration-underline">
                                                <small>Clear All</small>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-1" style="max-height: 300px;" data-simplebar>

                                    <h5 class="text-muted font-13 fw-normal mt-2">Today</h5>
                                    <!-- item-->

                                    <a href="javascript:void(0);"
                                        class="dropdown-item p-0 notify-item card unread-noti shadow-none mb-1">
                                        <div class="card-body">
                                            <span class="float-end noti-close-btn text-muted"><i
                                                    class="mdi mdi-close"></i></span>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="notify-icon bg-primary">
                                                        <i class="mdi mdi-comment-account-outline"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 text-truncate ms-2">
                                                    <h5 class="noti-item-title fw-semibold font-14">Datacorp <small
                                                            class="fw-normal text-muted ms-1">1 min ago</small></h5>
                                                    <small class="noti-item-subtitle text-muted">Caleb Flakelar
                                                        commented on Admin</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);"
                                        class="dropdown-item p-0 notify-item card read-noti shadow-none mb-1">
                                        <div class="card-body">
                                            <span class="float-end noti-close-btn text-muted"><i
                                                    class="mdi mdi-close"></i></span>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="notify-icon bg-info">
                                                        <i class="mdi mdi-account-plus"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 text-truncate ms-2">
                                                    <h5 class="noti-item-title fw-semibold font-14">Admin <small
                                                            class="fw-normal text-muted ms-1">1 hours ago</small></h5>
                                                    <small class="noti-item-subtitle text-muted">New user
                                                        registered</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <h5 class="text-muted font-13 fw-normal mt-0">Yesterday</h5>

                                    <!-- item-->
                                    <a href="javascript:void(0);"
                                        class="dropdown-item p-0 notify-item card read-noti shadow-none mb-1">
                                        <div class="card-body">
                                            <span class="float-end noti-close-btn text-muted"><i
                                                    class="mdi mdi-close"></i></span>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="notify-icon">
                                                        <img src="{{ asset('ubold/assets/images/users/avatar-2.jpg') }}"
                                                            class="img-fluid rounded-circle" alt="" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 text-truncate ms-2">
                                                    <h5 class="noti-item-title fw-semibold font-14">Cristina Pride
                                                        <small class="fw-normal text-muted ms-1">1 day ago</small>
                                                    </h5>
                                                    <small class="noti-item-subtitle text-muted">Hi, How are you? What
                                                        about our next meeting</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <h5 class="text-muted font-13 fw-normal mt-0">30 Dec 2021</h5>

                                    <!-- item-->
                                    <a href="javascript:void(0);"
                                        class="dropdown-item p-0 notify-item card read-noti shadow-none mb-1">
                                        <div class="card-body">
                                            <span class="float-end noti-close-btn text-muted"><i
                                                    class="mdi mdi-close"></i></span>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="notify-icon bg-primary">
                                                        <i class="mdi mdi-comment-account-outline"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 text-truncate ms-2">
                                                    <h5 class="noti-item-title fw-semibold font-14">Datacorp</h5>
                                                    <small class="noti-item-subtitle text-muted">Caleb Flakelar
                                                        commented on Admin</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);"
                                        class="dropdown-item p-0 notify-item card read-noti shadow-none mb-1">
                                        <div class="card-body">
                                            <span class="float-end noti-close-btn text-muted"><i
                                                    class="mdi mdi-close"></i></span>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="notify-icon">
                                                        <img src="{{ asset('ubold/assets/images/users/avatar-4.jpg') }}"
                                                            class="img-fluid rounded-circle" alt="" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 text-truncate ms-2">
                                                    <h5 class="noti-item-title fw-semibold font-14">Karen Robinson</h5>
                                                    <small class="noti-item-subtitle text-muted">Wow ! this admin looks
                                                        good and awesome design</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <div class="text-center">
                                        <i class="mdi mdi-dots-circle mdi-spin text-muted h3 mt-0"></i>
                                    </div>
                                </div>

                                <!-- All-->
                                <a href="javascript:void(0);"
                                    class="dropdown-item text-center text-primary notify-item border-top border-light py-2">
                                    View All
                                </a>

                            </div>
                        </li>

                        <!-- Light/Darj Mode Toggle Button -->
                        <li class="d-none d-sm-inline-block">
                            <div class="nav-link waves-effect waves-light" id="light-dark-mode">
                                <i class="ri-moon-line font-22"></i>
                            </div>
                        </li>

                        <!-- User Dropdown -->
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light"
                                data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                                aria-expanded="false">
                                <?php
                            
                                $User_profilePhoto=Auth::user()->profile_photo_path;
    
                               
                                if ($User_profilePhoto == "") {
                                    ?>
                                <img src="{{ asset('images/users/1.jpg') }}" alt="user-image"
                                    class="rounded-circle">
                                <?php
                                } else {
                                    $userPhoto =  public_path()."/uploads/$User_profilePhoto";
                                    if (file_exists($userPhoto)) {
                                        ?>
                                <img src="{{ asset("uploads/$User_profilePhoto") }}" alt="user-image"
                                    class="rounded-circle">
                                <?php
                                    } else {
                                        ?>
                                <img src="{{ asset('images/users/1.jpg') }}" alt="user-image"
                                    class="rounded-circle">
                                <?php
                                    }
                                }
                                ?>


                                <span class="ms-1 d-none d-md-inline-block">
                                    {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">




                                <!-- item-->
                                <a href="javascript:void(0);" data-toggle="modal" data-target=".bd-dialog-modal-lg"
                                    onclick="getUpdateForm()" class="dropdown-item notify-item">
                                    <i class="fe-settings"></i>
                                    <span>{{ __('public.profileSetting') }}</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" data-toggle="modal" data-target=".bd-dialog-modal-lg"
                                    onclick="getFormToChangePassword()" class="dropdown-item notify-item">
                                    <i class="fe-user"></i>
                                    <span>{{ __('public.changepassword') }}</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <!-- item-->
                                <a href="logout" class="dropdown-item notify-item">
                                    <i class="fe-log-out"></i>
                                    <span>{{ __('public.logout') }}</span>
                                </a>

                            </div>
                        </li>

                        <!-- Right Bar offcanvas button (Theme Customization Panel) -->
                        <li>
                            <a class="nav-link waves-effect waves-light" data-bs-toggle="offcanvas"
                                href="#theme-settings-offcanvas">
                                <i class="fe-settings font-22"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- ========== Topbar End ========== -->

            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    @yield('content')
                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> © <a href="https://generatesystems.com/"
                                    target="_blank">GenerateSystems.com</a>
                            </div>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- Theme Settings -->
    <div class="offcanvas offcanvas-end right-bar" tabindex="-1" id="theme-settings-offcanvas">
        <div class="d-flex align-items-center w-100 p-0 offcanvas-header">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-bordered nav-justified w-100" role="tablist">


                <li class="nav-item">
                    <a class="nav-link py-2 active" data-bs-toggle="tab" href="#settings-tab" role="tab">
                        <i class="mdi mdi-cog-outline d-block font-22 my-1"></i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="offcanvas-body p-3 h-100" data-simplebar>
            <!-- Tab panes -->
            <div class="tab-content pt-0">



                <div class="tab-pane active" id="settings-tab" role="tabpanel">

                    <div class="mt-n3">
                        <h6 class="fw-medium py-2 px-3 font-13 text-uppercase bg-light mx-n3 mt-n3 mb-3">
                            <span class="d-block py-1">Theme Settings</span>
                        </h6>
                    </div>

                    <div class="alert alert-warning" role="alert">
                        <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
                    </div>

                    <h5 class="fw-medium font-14 mt-4 mb-2 pb-1">Color Scheme</h5>

                    <div class="colorscheme-cardradio">
                        <div class="d-flex flex-column gap-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-bs-theme"
                                    id="layout-color-light" value="light">
                                <label class="form-check-label" for="layout-color-light">Light</label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-bs-theme"
                                    id="layout-color-dark" value="dark">
                                <label class="form-check-label" for="layout-color-dark">Dark</label>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-medium font-14 mt-4 mb-2 pb-1">Content Width</h5>
                    <div class="d-flex flex-column gap-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="data-layout-width"
                                id="layout-width-default" value="default">
                            <label class="form-check-label" for="layout-width-default">Fluid (Default)</label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="data-layout-width"
                                id="layout-width-boxed" value="boxed">
                            <label class="form-check-label" for="layout-width-boxed">Boxed</label>
                        </div>
                    </div>

                    <div id="layout-mode">
                        <h5 class="fw-medium font-14 mt-4 mb-2 pb-1">Layout Mode</h5>

                        <div class="d-flex flex-column gap-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-layout-mode"
                                    id="layout-mode-default" value="default">
                                <label class="form-check-label" for="layout-mode-default">Default</label>
                            </div>


                            <div id="layout-detached">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="data-layout-mode"
                                        id="layout-mode-detached" value="detached">
                                    <label class="form-check-label" for="layout-mode-detached">Detached</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-medium font-14 mt-4 mb-2 pb-1">Topbar Color</h5>

                    <div class="d-flex flex-column gap-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="data-topbar-color"
                                id="topbar-color-light" value="light">
                            <label class="form-check-label" for="topbar-color-light">Light</label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="data-topbar-color"
                                id="topbar-color-dark" value="dark">
                            <label class="form-check-label" for="topbar-color-dark">Dark</label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="data-topbar-color"
                                id="topbar-color-brand" value="brand">
                            <label class="form-check-label" for="topbar-color-brand">Brand</label>
                        </div>
                    </div>

                    <div>
                        <h5 class="fw-medium font-14 mt-4 mb-2 pb-1">Menu Color</h5>

                        <div class="d-flex flex-column gap-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-menu-color"
                                    id="leftbar-color-light" value="light">
                                <label class="form-check-label" for="leftbar-color-light">Light</label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-menu-color"
                                    id="leftbar-color-dark" value="dark">
                                <label class="form-check-label" for="leftbar-color-dark">Dark</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-menu-color"
                                    id="leftbar-color-brand" value="brand">
                                <label class="form-check-label" for="leftbar-color-brand">Brand</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-menu-color"
                                    id="leftbar-color-gradient" value="gradient">
                                <label class="form-check-label" for="leftbar-color-gradient">Gradient</label>
                            </div>
                        </div>
                    </div>

                    <div id="menu-icon-color">
                        <h5 class="fw-medium font-14 mt-4 mb-2 pb-1">Menu Icon Color</h5>

                        <div class="d-flex flex-column gap-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-two-column-color"
                                    id="twocolumn-menu-color-light" value="light">
                                <label class="form-check-label" for="twocolumn-menu-color-light">Light</label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-two-column-color"
                                    id="twocolumn-menu-color-dark" value="dark">
                                <label class="form-check-label" for="twocolumn-menu-color-dark">Dark</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-two-column-color"
                                    id="twocolumn-menu-color-brand" value="brand">
                                <label class="form-check-label" for="twocolumn-menu-color-brand">Brand</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-two-column-color"
                                    id="twocolumn-menu-color-gradient" value="gradient">
                                <label class="form-check-label" for="twocolumn-menu-color-gradient">Gradient</label>
                            </div>
                        </div>
                    </div>

                    <div id="sidebar-size">
                        <h5 class="fw-medium font-14 mt-4 mb-2 pb-1">Sidebar Size</h5>

                        <div class="d-flex flex-column gap-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                    id="leftbar-size-default" value="default">
                                <label class="form-check-label" for="leftbar-size-default">Default</label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                    id="leftbar-size-compact" value="compact">
                                <label class="form-check-label" for="leftbar-size-compact">Compact (Medium
                                    Width)</label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                    id="leftbar-size-small" value="condensed">
                                <label class="form-check-label" for="leftbar-size-small">Condensed (Icon View)</label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                    id="leftbar-size-full" value="full">
                                <label class="form-check-label" for="leftbar-size-full">Full Layout</label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                    id="leftbar-size-fullscreen" value="fullscreen">
                                <label class="form-check-label" for="leftbar-size-fullscreen">Fullscreen
                                    Layout</label>
                            </div>
                        </div>
                    </div>

                    <div id="sidebar-user">
                        <h5 class="fw-medium font-14 mt-4 mb-2 pb-1">Sidebar User Info</h5>

                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" name="data-sidebar-user"
                                id="sidebaruser-check">
                            <label class="form-check-label" for="sidebaruser-check">Enable</label>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="offcanvas-footer border-top py-2 px-2 text-center">
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-light w-50" id="reset-layout">Reset</button>

            </div>
        </div>
    </div>
    <input id="dir" type="hidden" value="{{ $dir }}" />
    </div>
    {{ Mform::DrawModal() }}

    <script src="{{ asset('sw.js') }}"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("sw.js").then(function(reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Vendor js -->
    <script src="{{ asset('ubold/assets/js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('ubold/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- Plugins js-->
    <script src="{{ asset('ubold/assets/libs/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('ubold/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}">
    </script>
    <script
        src="{{ asset('ubold/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}">
    </script>
    <script src="{{ asset('ubold/assets/libs/tippy.js/tippy.all.min.js') }}"></script>
    <!-- Dashboard 2 init -->
    <script src="{{ asset('ubold/assets/js/pages/dashboard-2.init.js') }}"></script>
    <script src="{{ asset('plugins/lightbox/js/lightbox-plus-jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/build/toastr.min.js') }}"></script>
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>


    <script>
        $('.date').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            clearBtn: true,
            autoclose: true
        });
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
        $('.select2').select2({
            placeholder: 'Select an option'
        });
    </script>
</body>

</html>
