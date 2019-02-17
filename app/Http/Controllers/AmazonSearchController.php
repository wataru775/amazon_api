<?php

namespace App\Http\Controllers;

use App\Exceptions\AmazonSearchControllerServiceException;
use App\Search\Response;
use App\Services\AmazonSearchControllerService;
use Illuminate\Http\Request;

class AmazonSearchController extends Controller
{
    private $searchControllerService;
    public function __construct(AmazonSearchControllerService $searchControllerService)
    {
        $this->searchControllerService = $searchControllerService;
    }

    public function searchItems(Request $request){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Credentials: true');

        $response = new Response();
        $response->request =$request;

        try {
            $response->results = $this->searchControllerService->searchItems(\App\Search\Request::valueOf($request));
            return response()->json($response, 200, [], JSON_UNESCAPED_UNICODE);
        }catch (AmazonSearchControllerServiceException $e){
            $response->code = 500;
            $response->message = $e->getMessage();
            return response()->json($response, 200, [], JSON_UNESCAPED_UNICODE);
        }
    }
}
