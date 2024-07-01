<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\ParentResource;
use App\Http\Requests\UpdateParentRequest;

class AdminController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return $this->respondSuccess(ParentResource::collection($admins));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);
        return $this->respondSuccess(new ParentResource($admin));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParentRequest $request, string $id)
    {
        $admin = User::find($id);
        if ($admin && $admin->role == 'admin' && $admin->id != 1) {
            $admin->update($request->all());
            return $this->respondSuccess(new ParentResource($admin));
        } else {
            return $this->respondNotFound();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = User::find($id);
        if ($admin && $admin->role == 'admin' && $admin->id != 1) {
            $admin->delete();
            return $this->respondSuccess(new ParentResource($admin));
        } else {
            return $this->respondNotFound();
        }
    }
}
