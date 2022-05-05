<?php

namespace App\Http\Controllers;

use App\Models\Item;
// use App\Http\Requests\StoreItemRequest;
// use App\Http\Requests\UpdateItemRequest;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        Item::create($request->all());
        dd($request->all());
        return 'hello';
    }

    public function update(Request $request, Item $item)
    {
        //
    }

    public function destroy(Item $item)
    {
        //
    }
}
