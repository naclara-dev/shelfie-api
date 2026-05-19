<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DestroyTitleRequest;
use App\Http\Resources\TitleResource;
use App\Http\Requests\StoreTitleRequest;
use App\Http\Requests\UpdateTitleRequest;
use App\Filters\TitleFilter;
use App\Http\Resources\GenreResource;
use App\Http\Resources\RatingResource;
use App\Models\Title;

class TitleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new TitleFilter($request);
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);

        $query = Title::query();
        $titles = $filter->apply($query)->paginate($perPage)->appends($request->query());

        return $this->success(TitleResource::collection($titles));
    }

    /**
     * Display a listing of genres associated with the title 
     */
    public function genres(Title $title) {
        return $this->success(GenreResource::collection($title->genres));
    }

    /**
     * Display a listing of ratings associated with the title 
     */
    public function ratings(Title $title) {
        return $this->success(RatingResource::collection($title->ratings));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTitleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTitleRequest $request)
    {
        # Basic validation
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        # Creates the object
        $title = Title::create($data);

        # Populates the pivot table with the associated genres
        if ($request->has('genres')) {
            $title->genres()->sync($data['genres']);
        }

        # Returns the created object
        return $this->success(new TitleResource($title->load('genres')));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {       
        $title = Title::find($id);

        if (!$title) {
            return $this->error('Title not found.', 404);
        }

        return $this->success(new TitleResource($title));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTitleRequest  $request
     * @param  \App\Models\Title  $title
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTitleRequest $request, Title $title)
    {
        # Basic validation
        $data = $request->validated();

        # Updates the object
        $title->update($data);

        # Sync the pivot table with the associated genres
        if ($request->has('genres')) {
            $title->genres()->sync($data['genres']);
        }

        # Returns the updated object
        return $this->success(new TitleResource($title->load('genres')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\DestroyTitleRequest  $request
     * @param  \App\Models\Title  $title
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyTitleRequest $request, Title $title)
    {        
        $title->delete();
        return $this->success();
    }
}
