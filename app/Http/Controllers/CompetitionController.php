<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Competition;
use App\Team;
use GuzzleHttp\Client;


class CompetitionController extends Controller
{

        private $base_path = 'https://api.football-data.org/v2/';
        private $headers = ['X-Auth-Token'  =>  ['ab794dbbc14b4e919c16d7747ff03140']];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new Client();
        $response = $client->request('GET', $this->base_path.'competitions/', 
            [   'verify' => false,
                'headers' => $this->headers
            ]);
    	$statusCode = $response->getStatusCode();
    	$body = $response->getBody()->getContents();

    	return $body;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = new Client();
        $response = $client->request('GET', $this->base_path.'competitions/'.$id, 
            [   'verify' => false,
                'headers' => $this->headers
            ]);
    	$statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        
        $teamResponse = $client->request('GET', 
            $this->base_path.'competitions/'.$id.'/teams', 
            [   
                'verify' => false,
                'headers' => $this->headers
            ]
        );

        $dataTeams = json_decode($teamResponse->getBody())->teams;
        
        foreach($dataTeams as $dataTeam){
            // dump($dataTeam->name);
            // dump(gettype($dataTeam));
            $team = new Team();
            $team-> id = $dataTeam->id;
            $team-> name = $dataTeam->name;
            $team-> shortName = $dataTeam->shortName;
            $team-> tla = $dataTeam->tla;
            $team-> crestUrl = $dataTeam->crestUrl;
            $team-> address = $dataTeam->address;
            $team-> phone = $dataTeam->phone;
            $team-> website = $dataTeam->website;
            $team-> email = $dataTeam->email;
            $team-> founded = $dataTeam->founded;
            $team-> clubColors = $dataTeam->clubColors;
            $team-> venue = $dataTeam->venue;
            $team-> lastUpdated = $dataTeam->lastUpdated;
            $team->timestamps = false;
            
            $team->save();

            // $playerResponse = $client->request('GET', 
            //     $this->base_path.'teams/'.$team->id, 
            //     [   
            //         'verify' => false,
            //         'headers' => $this->headers
            //     ]
            // );

            // dump(json_decode($playerResponse->getBody()));
        }

        // $data = json_decode($response->getBody());
        // return $data->name;
        dump($response);
        return $body;
        // return $dataTeams->teams;
        // return Competition::where('id', $id)->get();
        // return dd($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
