<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Filters\GenreFilter;
use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use App\Http\Resources\GenreResource;
use App\Models\Genre;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new GenreFilter($request);

        $query = Genre::query();
        $genres = $filter->apply($query)->get();

        return GenreResource::collection($genres);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGenreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGenreRequest $request)
    {
        # Basic validation
        $data = $request->validated();

        # Creates the object
        $genre = Genre::create($data);

        # Returns the created object
        return new GenreResource($genre);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new GenreResource(Genre::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGenreRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGenreRequest $request, Genre $genre)
    {
        # Basic validation
        $data = $request->validated();

        # Updates the object
        $genre->update($data);

        # Returns the updated object
        return new GenreResource($genre);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();
        return response()->noContent();
    }
}
