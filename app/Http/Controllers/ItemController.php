<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        # Basic validation
        $data = $request->validate([
            'title'    => 'required|string',
            'genres'   => 'required',
            'type'     => 'required|string',
            'year'     => 'required|string',
            'imdb_id'  => 'required|string|unique:items,imdb_id'  
        ]);

        # Normalizes the genres in an array
        $genreIds = $data['genres'];

        if (!is_array($genreIds)) {
            $genreIds = explode(',', $genreIds); 
            $genreIds = array_map('trim', $genreIds);   
        }

        $genreIds = array_map('intval', $genreIds);

        # Create the object
        $item = Item::create($data);

        # Populates the pivot table with the associated genres
        $item->genres()->sync($genreIds);

        # Returns the created object
        return new ItemResource($item);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Item::findOrFail($id);
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
        Item::destroy($id);
    }
}
