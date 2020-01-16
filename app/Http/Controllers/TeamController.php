<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use Response;

class TeamController extends Controller
{
    public function index()
    {
        return Team::all();
    }

    public function show($id){
        // return Team::where('id',$id)->firstOrFail();
        if(Team::where('id',$id)->exists())
            return Response::json(Team::where('id',$id)->get());
        else
            return Response::json(['message'=>'Recurso no encontrado']);
    }
}
