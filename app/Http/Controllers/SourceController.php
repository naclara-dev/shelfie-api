<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSourceRequest;
use App\Http\Requests\UpdateSourceRequest;
use App\Http\Resources\SourceResource;
use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        $sources = Source::paginate($perPage)->appends($request->query());

        return $this->success(SourceResource::collection($sources));
    }

    public function titles(Source $source)
    {
        return $this->success(\App\Http\Resources\TitleResource::collection($source->titles));
    }

    public function store(StoreSourceRequest $request)
    {
        $source = Source::create($request->validated());

        return $this->success(new SourceResource($source), 201);
    }

    public function show($id)
    {
        $source = Source::find($id);

        if (!$source) {
            return $this->error('Source not found.', 404);
        }

        return $this->success(new SourceResource($source));
    }

    public function update(UpdateSourceRequest $request, Source $source)
    {
        $source->update($request->validated());

        return $this->success(new SourceResource($source));
    }

    public function destroy(Source $source)
    {
        $source->delete();

        return $this->success();
    }
}
