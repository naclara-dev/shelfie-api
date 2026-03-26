<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Filters\ItemFilter;
use App\Http\Resources\GenreResource;
use App\Http\Resources\RatingResource;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
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
     * Display a listing of genres associated with the item 
     */
    public function genres(Item $item) {
        return GenreResource::collection($item->genres);
    }

    /**
     * Display a listing of ratings associated with the item 
     */
    public function ratings(Item $item) {
        return RatingResource::collection($item->ratings);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemRequest  $request
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
     * @param  \App\Http\Requests\UpdateItemRequest  $request
     * @param  \App\Models\Item  $item
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
