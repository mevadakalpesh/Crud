<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Jobs\ImportCsvDataJob;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Bus;

class FileImportController extends Controller
{
  public $file_path;
  public function __construct() {
    $this->file_path = public_path().'/csv/';

    //ini_set('max_execution_time', 300);
    ini_set('memory_limit', '-1');
    ini_set('upload_max_filesize', '1000M');
    ini_set('post_max_size', '1000M');


  }

  public function index() {
    return view('fileupload');
  }

  public function uploadFile(Request $request) {
    $validator = Validator::make($request->all(), [
      'file' => 'required|mimetypes:text/plain,text/csv'
    ]);

    if ($validator->fails()) {
      return redirect()->route('file-import-view')->with('error', $validator->errors()->first());
    }


    $fileData = file($request->file('file'));
    if (!blank($fileData)) {
      $this->makeDir();
      $fileputpath = $this->file_path;
      $file_records = array_chunk($fileData, 500);
      foreach ($file_records as $key => $value) {
        $filename = 'csv_'.$key.time().uniqid().'.csv';
        file_put_contents($fileputpath.$filename, $value);
      }
      $batch = $this->ImportData();
      if (!blank($batch)) {
        return response()->json(['status' => 200, 'message' => 'Success', 'result' => $batch]);
      } else {
        return response()->json(['status' => 101, 'message' => 'something went wrong']);
      }
    } else {
      return response()->json(['status' => 101, 'message' => 'File Is Empty']);
    }
  }


  public function makeDir() {
    if (!File::exists($this->file_path)) {
      File::makeDirectory($this->file_path);
    }
  }

  public function ImportData() {
    $files = glob($this->file_path.'/*.csv');
    if (!blank($files)) {
      $header = [];
      $jobs = [];
      foreach ($files as $key => $file) {
        $filedata = array_map('str_getcsv', file($file));
        if ($key == 0) {
          $header = $filedata[0];
          unset($filedata[0]);
        }
        $jobs[] = new ImportCsvDataJob($header, $filedata);
        unlink($file);
      }
      return Bus::batch($jobs)->dispatch();
    } else {
      throw new \Exception('Csv Folder Is empty');
    }
  }
  
  public function getBatchById($batchId){
    $batchId = isset($batchId) ? $batchId : 0;
    $batch =  Bus::findBatch($batchId);
    if (!blank($batch)) {
        return response()->json(['status' => 200, 'message' => 'Success', 'result' => $batch]);
    } else {
        return response()->json(['status' => 101, 'message' => 'Batch Not Found']);
    }
  }
}