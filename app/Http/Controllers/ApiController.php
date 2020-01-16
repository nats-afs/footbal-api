<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    public function index()
    {
    	$client = new Client();
        $response = $client->request('GET', 'https://api.football-data.org/v2/competitions', 
            [   'verify' => false,
                'headers' => [
                    'X-Auth-Token'  =>  ['ab794dbbc14b4e919c16d7747ff03140']
                ]
            ]);
    	$statusCode = $response->getStatusCode();
    	$body = $response->getBody()->getContents();

    	return $body;
    }
}
