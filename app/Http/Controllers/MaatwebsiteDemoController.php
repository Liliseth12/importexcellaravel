<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use DB;
use Excel;
use Input;

class MaatwebsiteDemoController extends Controller
{
    //
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importExport()
    {
        return view('importExport');
    }
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadExcel($type)
    {
        $data = Item::get()->toArray();
            
        return Excel::create('itsolutionstuff_example', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importExcel(Request $request)
    {
        if($request->file('import_file')){
                $path = $request->file('import_file')->getRealPath();
                $data = Excel::load($path, function($reader) {})->get();
                $data = array_slice($data, 0, 2);
            //$count = count($data);
            //dd($count);
            if(!empty($data) && $data->count()){
                $data = $data->toArray();
                    dd($data);
                for($i=0;$i<count($data);$i++){
                    $dataImported[] = $data[$i];
                }
            }
            Item::insert($dataImported);    
        }
            return back();
    }
    //     if(Input::hasFile('import_file')){
    //         $path = Input::file('import_file')->getRealPath();
    //         //dd($path);
    //         $data = Excel::load($path, function($reader) {})->get();
    //         //dd($data);

    //         if(!empty($data) && $data->count()){
    //         //dd($data);
    //             foreach ($data as $key=>$value) {
    //                 echo "{$key} => {$value}";
    //                 echo "<br>";
    //                 print_r($data);

    //                 //$data->title->get();
    //                 //dd($data);
    //              $value1 = array_key_exists('title', $data) ? $data['title'] : '';
    //              $value2 = array_key_exists('description', $data) ? $data['description'] : '';
    //              $value3 = array_key_exists(0, $data) ? $data[0] : '';

    //              dd($value1, $value2, $value3);
    //                 $insert = [
    //                 'title' => $value['title'], 
    //                 'description' => $value['description'],
    //                 ];
    //             }
    //             if(!empty($insert)){
    //                 DB::table('items')->insert($insert);
    //                 dd('Insert Record successfully.');
    //             }
    //         }
    //     }
    //     return back();
    // }
}

