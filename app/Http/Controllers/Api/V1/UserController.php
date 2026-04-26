<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\EventType;
use App\Http\Requests\Api\V1\UserFireRequest;
use App\Http\Requests\Api\V1\UserStoreRequest;
use App\Http\Requests\Api\V1\UserTransferRequest;
use App\Http\Requests\Api\V1\UserUpdateRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use App\Queries\Api\V1\UserQuery;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class UserController extends ApiController
{
    public function index(UserQuery $query): ResourceCollection
    {
        return $query->get()->toResourceCollection();
    }

    public function fired(UserQuery $query): ResourceCollection
    {
        return $query
            ->query()
            ->onlyTrashed()
            ->whereHas('events', fn($q) => $q->where('type', EventType::FIRE))
            ->get()
            ->toResourceCollection();
    }

    public function tranfered(UserQuery $query): ResourceCollection
    {
        return $query
            ->query()
            ->onlyTrashed()
            ->whereHas('events', function ($q) {
                $q->where('type', EventType::TRANSFER);
            })
            ->get()
            ->toResourceCollection();
    }

    public function store(UserStoreRequest $request): UserResource
    {
        $user = User::create($request->mappedAttributes())
            ->syncRelationships($request->mappedRelationships());


        if ($request->hasFile('data.attributes.avatar')) {
            $user->storeAvatar($request->file('data.attributes.avatar'));
        }

        return $user->toResource();
    }

    public function show(UserQuery $query, string $id): UserResource
    {
        $user = $query->query()->findOrFail($id);

        return $user->toResource();
    }

    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $user->update($request->mappedAttributes());
        $user->syncRelationships($request->mappedRelationships());

        if ($request->exists('data.attributes.avatar')) {
            if ($request->hasFile('data.attributes.avatar')) {
                $user->deleteAvatar();
                $user->storeAvatar($request->file('data.attributes.avatar'));
            } elseif ($request->input('data.attributes.avatar') === null) {
                $user->deleteAvatar();
            }
        }

        return $user->toResource();
    }

    public function fire(UserFireRequest $request, User $user): Response
    {
        $user->events()->create($request->mappedAttributes());
        $user->delete();

        return $this->noContent();
    }

    public function transfer(UserTransferRequest $request, User $user): Response
    {
        $user->events()->create($request->mappedAttributes());
        $user->delete();

        return $this->noContent();
    }

    public function destroy(User $user)
    {
        //
    }
}
