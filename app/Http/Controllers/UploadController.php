<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Http\Requests;

class UploadController extends Controller
{
    private $uploadDir = __DIR__ . '/../../../public/files/';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request, $type = '', $id = '')
    {
        $endpoint = $type . '/' . $id;
        $files = [];
        
        try{
            $dir = $this->uploadDir . $endpoint;
            if (is_dir($dir)) {               
                $files = scandir($dir);
                unset($files[0], $files[1]);
            }
        } catch (Exception $ex) {
            $request->session()->flash('errorMessage', $ex->getMessage());
        }
        
        return view('upload.index', [
            'files' => $files,
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
            $filename = $file->getClientOriginalName();
            $file->move($dir, $filename);            
            
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
        
        try {            
            if (! $filename) {
                return redirect('/upload/' . $type . '/' . $id );
            }            
            $fileName = $dir . '/' . $filename;

            if (file_exists($fileName)) {
                unlink($fileName);
                $request->session()->flash('successMessage', 'Delete file successfully.');
            }        
        } catch (Exception $ex) {
            $request->session()->flash('errorMessage', $ex->getMessage());
        }
        
        return redirect('/upload/' . $endpoint);
    }
}
