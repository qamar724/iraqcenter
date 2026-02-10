<?php 
namespace App\Http\Controllers\SystemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Filter extends Controller
{
    public static function countFilterItems($filters) {
        $allowFilterCount=0;
        foreach ($filters as $key => $value) {
            $word = "_id";
            $mystring = $value;

            if (strpos($mystring, $word) !== false) {
                $allowFilterCount++;
            }

            
        }
        return $allowFilterCount;
    }
}