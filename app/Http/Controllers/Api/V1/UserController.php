<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\UserStoreRequest;
use App\Http\Requests\Api\V1\UserUpdateRequest;
use App\Http\Resources\Api\v1\UserCollection;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): UserCollection
    {
        return new UserCollection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request): UserResource
    {
        $user = User::create($request->mappedAttributes())
            ->syncRelationships($request->mappedRelationships());

        if ($request->hasFile('avatar')) {
            $user->storeAvatar($request->file('avatar'));
        }

        return new UserResource($user->refresh());
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user->load(['roles', 'positions']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $user->update($request->mappedAttributes());
        $user->syncRelationships($request->mappedRelationships());

        if ($request->exists('avatar')) {
            if ($request->hasFile('avatar')) {
                $user->storeAvatar($request->file($request->file('avatar')));
            } elseif ($request->input('avatar') === null) {
                $user->deleteAvatar();
            }
        }

        return new UserResource($user->refresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
