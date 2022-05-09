<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request; 
// use App\Http\Requests\StoreClientRequest;
// use App\Http\Requests\UpdateClientRequest;

class ClientController extends Controller
{

    public function __construct(Client $client) {
        $this->client = $client;
    }


    public function index()
    {
        $client = $this->client->all();
        return response()->json ($client, 200);
    }


    public function store(Request $request)
    {
        $request->validate($this->client->rules(), $this->client->feedback());

        $client = $this->client->create([
            'name' => $request->name,
            'table_id' => $request->table_id,
            'bill' => $request->bill,
            'status' => $request->status,
        ]);

        return response()->json ($client, 201);
    }


    public function show($id)
    {
        $client = $this->client->find($id);

        if($client === null) {
            return response()->json(['erro' => 'Registro solicitado não existe!'], 404);
        }

        return response()->json ($client, 200);
    }

    
    public function update(Request $request, $id)
    {
        $client = $this->client->find($id);

        if($client === null) {
            return response()->json(['erro' => 'Registro solicitado para atualização não existe!'], 404);
        }

        if ($request->method() === 'PATCH'){
            $dynamicRules = array();

            foreach($client->rules() as $input => $rule) {
                //Verica se o indice da regra existe no request
                if (array_key_exists($input, $request->all())) {
                    $dynamicRules[$input] = $rule;
                }
            }
            
            $request->validate($dynamicRules, $client->feedback());

        } else {
            $request->validate($client->rules(), $client->feedback());
        }

        // UPDATING
        $client->fill($request->all());
        $client->save();

        return response()->json ($client, 200);
    }
    
    public function destroy($id)
    {
        $client = $this->client->find($id);

        if($client === null) {
            return response()->json(['erro' => 'Registro solicitado para exclusão não existe!'], 404);
        }

        $client->delete();
        return ['msg' =>'Cliente removido com sucesso'];
    }
}
