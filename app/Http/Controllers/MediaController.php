<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        $media = Media::paginate($perPage)->appends($request->query());

        return $this->success(MediaResource::collection($media));
    }

    public function titles(Media $media)
    {
        return $this->success(\App\Http\Resources\TitleResource::collection($media->titles));
    }

    public function store(StoreMediaRequest $request)
    {
        $media = Media::create($request->validated());

        return $this->success(new MediaResource($media), 201);
    }

    public function show($id)
    {
        $media = Media::find($id);

        if (!$media) {
            return $this->error('Media not found.', 404);
        }

        return $this->success(new MediaResource($media));
    }

    public function update(UpdateMediaRequest $request, Media $media)
    {
        $media->update($request->validated());

        return $this->success(new MediaResource($media));
    }

    public function destroy(Media $media)
    {
        $media->delete();

        return $this->success();
    }
}
