<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Filters\GenreFilter;
use App\Http\Requests\DestroyGenreRequest;
use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use App\Http\Resources\GenreResource;
use App\Http\Resources\TitleResource;
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

        return $this->success(GenreResource::collection($genres));
    }

    /**
     * Display a listing of titles associated with the genre.
     */
    public function titles(Genre $genre)
    {
        return $this->success(TitleResource::collection($genre->titles));
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
        $data['created_by'] = auth()->id();

        # Creates the object
        $genre = Genre::create($data);

        # Returns the created object
        return $this->success(new GenreResource($genre));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return $this->error('Genre not found.', 404);
        }

        return $this->success(new GenreResource($genre));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGenreRequest $request
     * @param  \App\Models\Genre $genre
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGenreRequest $request, Genre $genre)
    {
        # Basic validation
        $data = $request->validated();

        # Updates the object
        $genre->update($data);

        # Returns the updated object
        return $this->success(new GenreResource($genre));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Http\Requests\DestroyGenreRequest $request 
     * @param \App\Models\Genre $genre 
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyGenreRequest $request, Genre $genre)
    {
        # Checks if the genre belongs to any title
        $titlesCount = $genre->titles()->count();

        # Returns an error if there is any association
        if ($titlesCount) {
            return $this->error(
                'This genre cannot be deleted because it is associated with titles.',
                409,
                ['titles_count' => $titlesCount]
            );
        }

        # Deletes the genre
        $genre->delete();
        return $this->success();
    }
}
