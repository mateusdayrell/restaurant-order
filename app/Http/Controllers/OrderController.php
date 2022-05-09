<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request; 
// use App\Http\Requests\StoreOrderRequest;
// use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{

    public function __construct(Order $order) {
        $this->order = $order;
    }
    
    public function index()
    {
        $order = $this->order->all();
        return response()->json ($order, 200);
    }

    
    
    public function store(Request $request)
    {
        $request->validate($this->order->rules(), $this->order->feedback());

        $order = $this->order->create([
            'client_id' => $request->client_id,
            'item_id' => $request->item_id,
            'status' => $request->status,
            'qtd' => $request->qtd,
            'value' => $request->value,
        ]);

        return response()->json ($order, 201);
    }

    
    
    public function show($id)
    {
        $order = $this->order->find($id);

        if($order === null) {
            return response()->json(['erro' => 'Registro solicitado não existe!'], 404);
        }

        return response()->json ($order, 200);
    }
    
    
    public function update(Request $request, $id)
    {
        $order = $this->order->find($id);

        if($order === null) {
            return response()->json(['erro' => 'Registro solicitado para atualização não existe!'], 404);
        }

        if ($request->method() === 'PATCH'){
            $dynamicRules = array();

            foreach($order->rules() as $input => $rule) {
                //Verica se o indice da regra existe no request
                if (array_key_exists($input, $request->all())) {
                    $dynamicRules[$input] = $rule;
                }
            }
            
            $request->validate($dynamicRules, $order->feedback());

        } else {
            $request->validate($order->rules(), $order->feedback());
        }

        // UPDATING
        $order->fill($request->all());
        $order->save();

        return response()->json ($order, 200);
    }
    
    
    public function destroy($id)
    {
        $order = $this->order->find($id);

        if($order === null) {
            return response()->json(['erro' => 'Registro solicitado para exclusão não existe!'], 404);
        }

        $order->delete();
        return ['msg' =>'Pedido removido com sucesso'];
    }
}
