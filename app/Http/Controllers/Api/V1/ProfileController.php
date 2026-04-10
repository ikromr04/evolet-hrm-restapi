<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\ProfileStoreRequest;
use App\Http\Resources\Api\V1\ProfileCollection;
use App\Http\Resources\Api\V1\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ProfileCollection
    {
        return new ProfileCollection(Profile::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfileStoreRequest $request): ProfileResource
    {
        $profile = Profile::create($request->mappedAttributes());

        return new ProfileResource($profile);
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile): ProfileResource
    {
        return new ProfileResource($profile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
