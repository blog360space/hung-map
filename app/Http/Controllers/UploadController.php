<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Http\Requests;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Validation\Rule;
use Validator;

class UploadController extends Controller
{
    /**
     * Dir to store upload files
     * @var string
     */
    private $uploadDir = __DIR__ . '/../../../public/files/';
    
    /**
     * Available sizes
     */
    private $sizesImg = [
        'md' => ['w' => '640', 'h' => '428'],
        'sm' => ['w' => '320', 'h' => '214'],
        'sq' => ['w' => '150', 'h' => '150'],
    ];
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request, $type = '', $id = '')
    {
        $endpoint = $type . '/' . $id;
        $files = [];
        $results = [];
        try{
            $dir = $this->uploadDir . $endpoint;
            if (is_dir($dir)) {               
                $files = scandir($dir);
                unset($files[0], $files[1]);
            }
            
            
            foreach ($files as $file) {
                if (mb_strpos($file, "sq.") === 0) {
                    $results[] = $file;
                }
            }
            
        } catch (Exception $ex) {
            $request->session()->flash('errorMessage', $ex->getMessage());
        }
        
        return view('upload.index', [
            'files' => $results,
            'endpoint' => $endpoint
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postStore(Request $request, $type = '', $id = '')
    {
        $endpoint = $type . '/' . $id;
        $dir = $this->uploadDir . $endpoint;
        
        try {
            if (! $request->hasFile('file')) {
                throw new Exception('File not found', 1);
            }
            if (! is_dir($dir)) {
                mkdir($dir);
            }
            
            $file = $request->file('file');
            // Tell the validator that this file should be an image
            $rules = array(
              'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000' // max 10000kb
            );
            $validator = Validator::make(['image' => $file], $rules);
            
            if ($validator->fails()) {
                throw new Exception('Please upload an image', 1);
            } 
            
            $filename = $file->getClientOriginalName();
            
            $file->move($dir, $filename); 
            $originafile = $dir . '/' .  $filename;
            //process resize
            $source = $dir . '/' . $filename;
            foreach ($this->sizesImg as $k => $size) { 
                $tmpName = $k . "." . $filename;
                
                if ($k != 'sq') {
                    $img = Image::make($source)->resize($size['w'], null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                } else {
                    
                    $img = Image::make($source)->resize($size['w'] + 100, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop($size['w'], $size['h']);
                }
                
                $img->save($dir . '/' . $tmpName);
            }
            
            unlink($originafile);            
            $request->session()->flash('successMessage', 'File stored successfully.');
            
        } catch (Exception $ex) {
            $request->session()->flash('errorMessage', $ex->getMessage());
        }
        
        return redirect('/upload/' . $endpoint);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteDestroy(Request $request, $type = '', $id = '')
    {
        $filename = isset($request->fileName) ? $request->fileName : '';
        $endpoint = $type . '/' . $id;
        $dir = $this->uploadDir . $endpoint;
        
        $orgName = str_replace("sq.", "", $filename);
        try {            
            if (! $filename) {
                return redirect('/upload/' . $type . '/' . $id );
            }            
            
            foreach ($this->sizesImg as $k => $item) {
                $fileName = $dir . '/' . $k . '.' . $orgName;                
                if (file_exists($fileName)) {
                    unlink($fileName);
                    $request->session()->flash('successMessage', 'Delete file successfully.');
                }        
            }
        } catch (Exception $ex) {
            $request->session()->flash('errorMessage', $ex->getMessage());
        }
        
        return redirect('/upload/' . $endpoint);
    }
}
