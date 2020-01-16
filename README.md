# FOOTBALL API

Football API es un servicio de datos publicos, en formato JSON. 
Los datos fueron capturados del el api (https://www.football-data.org) con la ayuda de Guzzle http client.

# Retos
Construir los siguientes endpoints
- /competitions - Obtendra el detalle de todas las ligas 
    Se creo un controlador "CompetitionController" dentro del cual se realizaron las consultas externas.
```sh
public function index(){
$client = new GuzzleHttp\Client;
$response = $client->request('GET', 'https://api.football-data.org/v2/competitions',$this->options);
...
...
}
```
- /competitions/<competition_id> - Obtiene el detalle de una liga especifica (Equipos y jugadores que luego serán almacenados localmente)
Usando el metodo show($id) de CompetitionController se capturaron los detalles desde la api externa.
```sh
public function show($id){
$client = new GuzzleHttp\Client;
$response = $client->request('GET', 'https://api.football-data.org/v2/competitions/'.$id,$this->options);
...
...
}
```
- /team - Muestra todos los equipos que se han almacenado hasta el momento
Se creo un controlador para este endpoint "TeamController" el metodo indext hace la magia.
```sh
    public function index()
    {
        return Team::all();
    }
```    
- /team/<team_id> - Muestra el detalle de los equipo seleccionado
El metodo show() de TeamController maneja este endpoint.
```sh
    public function show($id){
        // return Team::where('id',$id)->firstOrFail();
        if(Team::where('id',$id)->exists())
            return Response::json(Team::where('id',$id)->get());
        else
            return Response::json(['message'=>'Recurso no encontrado']);
    }
```
- /players -  Muestra todos los jugadores almacenados hasta el momento
PlayerController captura todas las peticiones.
```sh
    public function index()
    {
        return Player::all();
    }
```
# LIMITE DE CONSULTAS
Se manejan los diversos http_status 400,401,403,429.
El error 429 el indicador de limite consultas,
```sh
    if($errorCode == 429){
        if($e->getResponse()->hasHeader('X-RequestCounter-Reset'))
            $waitFor = $e->getResponse()->getHeader('X-RequestCounter-Reset')[0];
        return Response::json([
                'message'=>"Excediste el limite de consultas de tu plan free, espera por $waitFor segundos para reintentarlo",
                'error'=> 429],429)->header('Content-Type', 'application/json;charset=UTF-8');
    }
```

# FEEDBACK
Este api tiene demasiadas cosas por mejorar:
- Crear una instancia global del cliente http "Guzzle".
- Implementar Navigation Guards.
- Crear un handler para Guzzle.
- Refactorizar.