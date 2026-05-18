<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\RatingResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserPrivateResource;
use App\Http\Resources\UserPublicResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->success(UserPrivateResource::collection(User::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        # Basic validation
        $data = $request->validated();
        $data['role_id'] = 1;

        # Creates the user
        $user = User::create($data);

        # Returns the created object
        return $this->success(new UserPublicResource($user));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->error('User not found.', 404);
        }

        return $this->success(new UserPrivateResource($user));
    }

    /**
     * Display a listing of ratings associated with the user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function ratings(User $user)
    {
        return $this->success(RatingResource::collection($user->ratings));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        $user->update($data);

        return $this->success(new UserPrivateResource($user));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->success();
    }
}
