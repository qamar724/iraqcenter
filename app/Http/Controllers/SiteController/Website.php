<?php 
namespace App\Http\Controllers\SiteController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
 
class Website extends Controller
{
 /*  
  This controller has been generated Automatically by generatesystems.com  
  */ 

  public function Home(){
    return view('website.index');
  }
  
  
 }
