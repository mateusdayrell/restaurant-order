<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
// use App\Http\Requests\StoreItemRequest;
// use App\Http\Requests\UpdateItemRequest;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct(Item $item) {
        $this->item = $item;
    }


    public function index(Request $request)
    {
        $items = array();

        if($request->has('filter')){
            $filter = $request->filter;
        }

        $items = $this->item->all();

        foreach($items as $key => $i) {
            $iOrder = $i->getOrder($i->id);
            $i->order = $iOrder;
        }

        return response()->json ($items, 200);
    }


    public function store(Request $request)
    {
        $request->validate($this->item->rules(), $this->item->feedback());

        $item = new Item;
        $item->name = $request->name;
        $item->type = $request->type;
        $item->price = $request->price;
        $item->avaliable = $request->avaliable;;
        $item->description = $request->description;

        if($request->image) {
            $image = $request->file('image');
            $image_urn = $image->store('images', 'public');

            $item->image = $image_urn;
        }

        // if($request->description) {
        //     $item->description = $request->description;
        // }

        $item->save();
        return response()->json ($item, 201);
    }


    public function show($id)
    {
        $item = $this->item->find($id);

        if($item === null) {
            return response()->json(['erro' => 'Registro solicitado não existe!'], 404);
        }
        $order = $item->getOrder($id);
        $item->order = $order;

        return response()->json ($item, 200);
    }


    public function update(Request $request, $id)
    {
        $item = $this->item->find($id);

        if($item === null) {
            return response()->json(['erro' => 'Registro solicitado para atualização não existe!'], 404);
        }

        if ($request->method() === 'PATCH'){
            $dynamicRules = array();

            foreach($item->rules() as $input => $rule) {
                //Verica se o indice da regra existe no request
                if (array_key_exists($input, $request->all())) {
                    $dynamicRules[$input] = $rule;
                }
            }
            
            $request->validate($dynamicRules, $item->feedback());

        } else {
            $request->validate($item->rules(), $item->feedback());
        }

        // UPDATING
        $item->fill($request->all());

             // ** GETTING NEW IMAGE FILE
            if( $request->file('image') ) {
                // ** REMOVING OLD IMAGE FILE
                Storage::disk('public')->delete($item->image);

                $image = $request->file('image');
                $image_urn = $image->store('images', 'public');
                $item->image = $image_urn;
            }

        // $item->fill($request->all());
        $item->save();
        return response()->json ($item, 200);
    }


    public function destroy($id)
    {
        $item = $this->item->find($id);

        if($item === null) {
            return response()->json(['erro' => 'Registro solicitado para exclusão não existe!'], 404);
        }

        if($item->image) {
            // ** REMOVING IMAGE FILE
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();
        return ['msg' =>'Item removido com sucesso'];
    }

    public function getItemWithOrders(Reequest $request) {
        $items = array();

        if($request->has('filter')){
            $filter = $request->filter;
        }

        $items = $this->item->all();

        foreach($items as $key => $i) {
            $iOrder = $i->getOrder($i->id);
            $i->order = $iOrder;
        }

        return response()->json ($items, 200);
    }
}
