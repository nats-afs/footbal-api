<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Competition;
use App\Player;
use App\Team;
use DB;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

class CompetitionController extends Controller
{

        private $base_path = 'https://api.football-data.org/v2/';
        // private $handler = new CurlHandler();
        // private $stack = HandlerStack::create($handler);
        private $options =
            [
                'verify' => false,
                'headers' => ['X-Auth-Token'  =>  ['ab794dbbc14b4e919c16d7747ff03140']],
                // 'handler' => $this->handler
            ];

        // protected $xclient;


        // public function __construct(Client $xclient)
        // {
        //     $this->xclient = $xclient;
        // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new Client();
        try {
            $response = $client->request('GET', $this->base_path.'competitions',$this->options);
            $body = json_decode($response->getBody());
            return Response::json($body,200)->header('Content-Type', 'application/json;charset=UTF-8');
        } catch (RequestException $e) {
            // echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $errorCode = $e->getResponse()->getStatusCode();
                // echo Psr7\str($e->getResponse());
                if($errorCode == 429){
                    if($e->getResponse()->hasHeader('X-RequestCounter-Reset'))
                        $waitFor = $e->getResponse()->getHeader('X-RequestCounter-Reset')[0];
                    return Response::json(['message'=>"Excediste el limite de consultas de tu plan free, espera por $waitFor para reintentarlo",'error'=> 429],429)->header('Content-Type', 'application/json;charset=UTF-8');
                }
                elseif($errorCode == 404)
                    return Response::json(['message'=>'El recurso al que intentas acceder no existe','error'=> 403],403)->header('Content-Type', 'application/json;charset=UTF-8');
                elseif($errorCode == 403)
                    return Response::json(['message'=>'Acceso restringido, verifica la validez de tu token o se PREMIUM','error'=> 403],403)->header('Content-Type', 'application/json;charset=UTF-8');
                elseif($errorCode == 400)
                    return Response::json(['message'=>'Parametros de consulta erroneos','error'=> 400],400)->header('Content-Type', 'application/json;charset=UTF-8');
                else
                    // echo Psr7\str($e->getResponse());
                    return Response::json($e->getResponse()->getBody(),$e->getResponse()->getStatusCode());
            }
        }
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
        // $client = resolve(Client::class);
        $client = new Client();

        try {
            $response = $client->request('GET', $this->base_path.'competitions/'.$id,
                 $this->options
                );
            $body = json_decode($response->getBody());

            $teamResponse = $client->request('GET', $this->base_path.'competitions/'.$id.'/teams', $this->options);

            $dataTeams = json_decode($teamResponse->getBody())->teams;

            foreach($dataTeams as $dataTeam){
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

                if(!DB::table('teams')->where('id',$dataTeam->id)->exists())
                    $team->save();

                $playerResponse = $client->request('GET',$this->base_path.'teams/'.$team->id, $this->options);
                $squad = json_decode($playerResponse->getBody())->squad;

                foreach ($squad as $playerData) {
                    $player = new Player();
                    $player-> id = $playerData->id;
                    $player-> name = $playerData->name;
                    $player-> position = $playerData->position;
                    $player-> shirtNumber = $playerData->shirtNumber;
                    $player->timestamps = false;

                    if(!DB::table('players')->where('id',$player->id)->exists()){
                        $player->save();
                    }
                }

            }

            return Response::json($body,200)->header('Content-Type', 'application/json;charset=UTF-8');
        } catch (RequestException $e) {
            // echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $errorCode = $e->getResponse()->getStatusCode();
                // echo Psr7\str($e->getResponse());
                if($errorCode == 429){
                    if($e->getResponse()->hasHeader('X-RequestCounter-Reset'))
                        $waitFor = $e->getResponse()->getHeader('X-RequestCounter-Reset')[0];
                    return Response::json(['message'=>"Excediste el limite de consultas de tu plan free, espera por $waitFor segundos para reintentarlo",'error'=> 429],429)->header('Content-Type', 'application/json;charset=UTF-8');
                }
                elseif($errorCode == 404)
                    return Response::json(['message'=>'El recurso al que intentas acceder no existe','error'=> 403],403)->header('Content-Type', 'application/json;charset=UTF-8');
                elseif($errorCode == 403)
                    return Response::json(['message'=>'Acceso restringido, verifica la validez de tu token o se PREMIUM','error'=> 403],403)->header('Content-Type', 'application/json;charset=UTF-8');
                elseif($errorCode == 400)
                    return Response::json(['message'=>'Parametros de consulta erroneos','error'=> 400],400)->header('Content-Type', 'application/json;charset=UTF-8');
                else
                    // echo Psr7\str($e->getResponse());
                    return Response::json($e->getResponse()->getBody(),$e->getResponse()->getStatusCode());
            }
        }
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
