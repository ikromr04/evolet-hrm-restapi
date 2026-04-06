<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\AvatarStoreRequest;
use App\Http\Requests\V1\UserStoreRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->mappedAttributes())
            ->refresh();

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
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

    public function uploadAvatar(User $user, AvatarStoreRequest $request): UserResource
    {
        $avatar = $request->file('image');

        $thumbnail = (new ImageManager(Driver::class))
            ->decode($avatar)
            ->cover(144, 144)
            ->encode(new WebpEncoder(quality: 90));

        $hashedName = pathinfo($avatar->hashName(), PATHINFO_FILENAME);
        $avatarName = "{$user->id}_{$hashedName}.{$avatar->extension()}";
        $avatarPath = User::PATH_AVATAR . "/{$avatarName}";
        $thumbPath = User::PATH_AVATAR_THUMBS . "/{$user->id}_{$hashedName}.webp";

        Storage::disk('public')->putFileAs(User::PATH_AVATAR, $avatar, $avatarName);
        Storage::disk('public')->put($thumbPath, $thumbnail);

        $user->update([
            'avatar' => $avatarPath,
            'avatar_thumb' => $thumbPath,
        ]);

        return new UserResource($user);
    }
}
