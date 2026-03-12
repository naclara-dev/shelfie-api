<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use Illuminate\Http\Request;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Filters\ItemFilter;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new ItemFilter($request);

        $query = Item::query();
        $items = $filter->apply($query)->get();

        return ItemResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemRequest $request)
    {
        # Basic validation
        $data = $request->validated();

        # Creates the object
        $item = Item::create($data);

        # Populates the pivot table with the associated genres
        if ($request->has('genres')) {
            $item->genres()->sync($data['genres']);
        }

        # Returns the created object
        return new ItemResource($item->load('genres'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {       
        return new ItemResource(Item::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        # Basic validation
        $data = $request->validated();

        # Updates the object
        $item->update($data);

        # Sync the pivot table with the associated genres
        if ($request->has('genres')) {
            $item->genres()->sync($data['genres']);
        }

        # Returns the updated object
        return new ItemResource($item->load('genres'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {        
        $item->delete();
        return response()->noContent();
    }
}
