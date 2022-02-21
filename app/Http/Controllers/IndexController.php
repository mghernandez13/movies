<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;

class IndexController extends Controller
{
    public function index(Request $request) 
    {
        $method   = 'find';
        $sort     = isset($request->sort) && $request->sort == "popular" ? -1 : 1;
        $txt_sort = $request->sort;
        $page     = isset($request->page) ? $request->page : 1;
        $limit    = isset($request->limit) ? (int)$request->limit : 5;
        $skip     = $limit * ($page - 1);
        $start    = $skip + 1;

        $options = [
            "dataSource" => env('MONGO_DB_SOURCE',''),
            'database'   => env('MONGO_DB_NAME',''),
            'collection' => env('MONGO_COLLECTION',''),
        ];

        $full_response = $this->fetchResponse($method,$options);
        $total         = isset($full_response['documents']) ? count($full_response['documents']) : 0;

        $options = [
            "dataSource" => env('MONGO_DB_SOURCE',''),
            'database'   => env('MONGO_DB_NAME',''),
            'collection' => env('MONGO_COLLECTION',''),
            'sort'       => ['Voter Average' => $sort],
            'limit'      => $limit,
            'skip'       => $skip
        ];

        $response     = $this->fetchResponse($method,$options);
        $end          = count($response['documents']) == $limit ? $limit * $page : (($limit * $page) - $limit) + count($response['documents']);
        $total_pages  = (int)ceil($total / $limit);

        return view('home',compact('response','total','page','start','end','total_pages','sort','txt_sort','limit'));
    }

    public function getMoviesById(Request $request)
    {

        $id        = $request->id;
        $message   = '';
        $status    = 'error';
        $data      = '';
        $validator = Validator::make($request->all(), [
            'id'   => 'required',
        ]);

        if ($validator->fails()) {            
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return json_encode(['status' => $status,'message' => $message]);
        } else {
            $method  = 'findOne';
            $options = [
                "dataSource" => env('MONGO_DB_SOURCE',''),
                'database'   => env('MONGO_DB_NAME',''),
                'collection' => env('MONGO_COLLECTION',''),
                "filter"     => ["_id" => 
                    [ "\$oid" => $id]
                ]
            ];
            $response = $this->fetchResponse($method,$options);

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

    private function fetchResponse($method, $options) 
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Access-Control-Request-Headers' => '*',
            'api-key' => env('API_KEY','')
        ])
        ->post(env('API_DOMAIN').'/app/data-itzom/endpoint/data/beta/action/'.$method,$options);

        return $response;
    }
}
