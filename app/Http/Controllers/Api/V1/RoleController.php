<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\RoleCollection;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): RoleCollection
    {
        return new RoleCollection(Role::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
