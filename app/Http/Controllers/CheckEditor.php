<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckEditor extends Controller
{
    public function fileupload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file("upload");
            $path  = $file->store("photos", ["disk" => "uploads"]);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('uploads/'.$path);
            $msg = 'Image successfully uploaded';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
