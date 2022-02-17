<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;

class IndexController extends Controller
{
    public function index(Request $request) 
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Access-Control-Request-Headers' => '*',
            'api-key' => env('API_KEY','')
        ])
        ->post(env('API_DOMAIN').'/app/data-itzom/endpoint/data/beta/action/find',[
            "dataSource" => env('MONGO_DB_SOURCE',''),
            'database'   => env('MONGO_DB_NAME',''),
            'collection' => env('MONGO_COLLECTION','')
        ]);

        return view('home',compact('response'));
    }

    public function getMoviesById(Request $request)
    {

        $title     = $request->title;
        $message   = '';
        $status    = 'error';
        $data      = '';
        $validator = Validator::make($request->all(), [
            'title'   => 'required',
        ]);

        if ($validator->fails()) {            
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return json_encode(['status' => $status,'message' => $message]);
        } else {

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Access-Control-Request-Headers' => '*',
                'api-key' => env('API_KEY','')
            ])
            ->post(env('API_DOMAIN').'/app/data-itzom/endpoint/data/beta/action/findOne',[
                "dataSource" => env('MONGO_DB_SOURCE',''),
                'database'   => env('MONGO_DB_NAME',''),
                'collection' => env('MONGO_COLLECTION',''),
                "filter"     => ["Title" => $title]
            ]);

            if($response->ok()) {
                $status  = 'success';
                $message = 'success';
                $data    = $response->json(); 
                
            } else {
                $message = $response->body();
            }

            return json_encode(['status' => $status,'message' => $message,'data' => $data]);
        }
    }
}
