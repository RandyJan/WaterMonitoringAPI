<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Kreait\Firebase\Database;
use Kreait\Firebase\Database\ApiClient;
use Kreait\Firebase;
use Kreait\Firebase\Factory;



class SensorController extends Controller
{
    //

  
    // public function __construct(ApiClient $database)
    // {
    //     $this->database = $database;
    // }
    public function dispatchData(Request $request){
        $firebase = (new Factory)
        ->withServiceAccount(env('FIREBASE_CREDENTIALS'))
        ->withDatabaseUri(env('FIREBASE_DATABSE_URL'));

    $database = $firebase->createDatabase();

        $databaseTable = "PH Level";
        $postData = [
            'PH Level'=>$request['a'],
            'Tubidity'=>$request['b'],
            // 'TDS'=>$request['c'],
            // 'Conductivity'=>$request['d']
        ];

        $date = Carbon::now();

        $result = $database->getReference($date)->set($postData);
        if($result){
            return response()->json(['Message'=>"Success",
        'Result'=>[
            "a"=>$request['a'],
            "b"=>$request['b'],
            "c"=>$request['c'],
            "d"=>$request['d']
        ]],200);
        }
        return response()->json(['Message'=>"Failed"],500);
    }
}
