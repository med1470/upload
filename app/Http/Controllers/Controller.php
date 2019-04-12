<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\Integer;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function upload(Request $request)
    {
        $uploadFile = $request->pic;
        $path = "/var/www/html/blog/storage/app/public/upload";
        $i = 1;
        $files = scandir($path, SCANDIR_SORT_DESCENDING);
        $newest_file = $files[0];
        $i = intval($newest_file);
        $i++;
        $uploadFile->storeAs('upload', $i);
        rename($path . "/" . $i, $path . '/' . $i . ".pdf");
        return response(['status' => 'success'], 200);
    }

    public function lister()
    {
        $path = "/var/www/html/blog/storage/app/public/upload";


        $i = 1;
        $dirname = $path;
        $dir = opendir($dirname);
        $testTable = false;
        $array[0] = 0;
        while ($file = readdir($dir)) {
            if ($file != '.' && $file != '..' && !is_dir($dirname . $file)) {
                $testTable = true;
                $i++;
                $array[] = $file;
            }
        }

        closedir($dir);

        return view('welcome')->with(array('array' => $array, 'i' => $i, 'testTable' => $testTable));

    }

    public function display_file($id)
    {
        $filename = $id . '.pdf';
        $path = storage_path('app/public/upload/' . $filename);

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
