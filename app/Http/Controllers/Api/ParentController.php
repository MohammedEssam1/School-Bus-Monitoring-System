<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\StudentResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ParentResource;
use App\Http\Requests\UpdateParentRequest;

class ParentController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = User::where('role', 'user')->get();
        return $this->respondSuccess(ParentResource::collection($students));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParentRequest $request, string $id)
    {
        $parent = User::find($id);
        if ($parent && $parent->role == 'user') {
            $parent->update($request->all());
            return $this->respondSuccess(new ParentResource($parent));
        } else {
            return $this->respondNotFound();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $parent = User::find($id);
        if ($parent && $parent->role == 'user') {
            $parent->delete();
            return $this->respondSuccess(new ParentResource($parent));
        } else {
            return $this->respondNotFound();
        }
    }
    public function sons(string $id){
        $parent = User::find($id);
        if ($parent && $parent->role == 'user') {
            return $this->respondSuccess(StudentResource::collection($parent->sons));
        } else {
            return $this->respondNotFound();
        }
    }
}
