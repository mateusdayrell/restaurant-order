<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request; 
// use App\Http\Requests\StoreTableRequest;
// use App\Http\Requests\UpdateTableRequest;

class TableController extends Controller
{
    
    public function __construct(Table $table) {
        $this->table = $table;
    }
    
    public function index()
    {
        $table = $this->table->all();
        return response()->json ($table, 200);
    }

    public function store(Request $request)
    {
        $request->validate($this->table->rules(), $this->table->feedback());

        $table = $this->table->create([
            'number' => $request->number,
            'waiter' => $request->waiter,
        ]);

        return response()->json ($table, 201);
    }


    public function show($id)
    {
        $table = $this->table->find($id);

        if($table === null) {
            return response()->json(['erro' => 'Registro solicitado não existe!'], 404);
        }

        return response()->json ($table, 200);
    }

    
    public function update(Request $request, $id)
    {
        $table = $this->table->find($id);

        if($table === null) {
            return response()->json(['erro' => 'Registro solicitado para atualização não existe!'], 404);
        }

        if ($request->method() === 'PATCH'){
            $dynamicRules = array();

            foreach($table->rules() as $input => $rule) {
                //Verica se o indice da regra existe no request
                if (array_key_exists($input, $request->all())) {
                    $dynamicRules[$input] = $rule;
                }
            }
            
            $request->validate($dynamicRules, $table->feedback());

        } else {
            $request->validate($table->rules(), $table->feedback());
        }

        // UPDATING
        $table->fill($request->all());
        $table->save();

        return response()->json ($table, 200);
    }

    
    public function destroy($id)
    {
        $table = $this->table->find($id);

        if($table === null) {
            return response()->json(['erro' => 'Registro solicitado para exclusão não existe!'], 404);
        }

        $table->delete();
        return ['msg' =>'Pedido removido com sucesso'];
    }
}
