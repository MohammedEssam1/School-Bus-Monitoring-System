<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Resources\TagResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;

class TagController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return $this->respondSuccess(TagResource::collection($tags));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        $tag = Tag::create($request->all());
        return $this->respondSuccess(new TagResource($tag));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, string $id)
    {
        $tag = Tag::find($id);
        if ($tag) {
            $tag->update($request->all());
            return $this->respondSuccess(new TagResource($tag));
        } else {
            return $this->respondNotFound();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = Tag::find($id);
        if ($tag) {
            $tag->delete();
            return $this->respondSuccess(new TagResource($tag));
        } else {
            return $this->respondNotFound();
        }
    }
}
