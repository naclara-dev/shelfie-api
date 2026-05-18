<?php

namespace App\Http\Controllers;

use App\Filters\RatingFilter;
use App\Http\Requests\DestroyRatingRequest;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;
use App\Http\Resources\RatingResource;
use Illuminate\Http\Request;
use App\Models\Rating;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new RatingFilter($request);

        $query = Rating::query();
        $ratings = $filter->apply($query)->get();

        return RatingResource::collection($ratings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRatingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRatingRequest $request)
    {
        # Basic validation
        $data = $request->validated();

        # Gets the user's id
        $data['user_id'] = auth()->id();

        # Creates the rating
        $rating = Rating::create($data);

        # Returns the created rating
        return new RatingResource($rating->load('title'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new RatingResource(Rating::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRatingRequest  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRatingRequest $request, Rating $rating)
    {
        $data = $request->validated();

        $rating->update($data);

        return new RatingResource($rating);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\DestroyRatingRequest  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRatingRequest $request, Rating $rating)
    {
        $rating->delete();

        return response()->noContent();
    }
}
