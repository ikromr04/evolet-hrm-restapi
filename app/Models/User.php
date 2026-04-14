<?php

namespace App\Models;

use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

#[UseResource(UserResource::class)]
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    use SoftDeletes;

    public const PATH_AVATAR = 'images/avatars';
    public const PATH_AVATAR_THUMBS = 'images/avatars/thumbs';

    public const RELATIONSHIPS = [
        'profile',
        'roles',
        'positions',
        'departments',
        'languages',
        'equipments',
        'experiences',
        'educations',
    ];

    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'login',
        'avatar',
        'avatar_thumb',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function scopeWithRelationships($builder)
    {
        return $builder->with(self::RELATIONSHIPS);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class);
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class);
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class);
    }

    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    public function syncRelationships(array $relationships): static
    {
        foreach ($relationships as $name => $value) {
            $this->{$name}()->sync($value);
        }

        return $this;
    }

    public function storeAvatar(UploadedFile $avatar): void
    {
        $thumbnail = (new ImageManager(Driver::class))
            ->decode($avatar)
            ->cover(144, 144)
            ->encode(new WebpEncoder(quality: 90));

        $hashedName = pathinfo($avatar->hashName(), PATHINFO_FILENAME);
        $avatarName = "{$hashedName}.{$avatar->extension()}";
        $avatarPath = User::PATH_AVATAR . "/{$avatarName}";
        $thumbPath = User::PATH_AVATAR_THUMBS . "/{$hashedName}.webp";

        Storage::disk('public')->putFileAs(User::PATH_AVATAR, $avatar, $avatarName);
        Storage::disk('public')->put($thumbPath, $thumbnail);

        $this->update([
            'avatar' => $avatarPath,
            'avatar_thumb' => $thumbPath,
        ]);
    }

    public function updateAvatar(UploadedFile $avatar): void
    {
        $this->deleteAvatarFiles();
        $this->storeAvatar($avatar);
    }

    public function deleteAvatar(): void
    {
        $this->deleteAvatarFiles();
        $this->update([
            'avatar' => null,
            'avatar_thumb' => null,
        ]);
    }

    public function deleteAvatarFiles(): void
    {
        $avatar = $this->attributes['avatar'] ?? null;
        $thumb = $this->attributes['avatar_thumb'] ?? null;

        if ($avatar && Storage::disk('public')->exists($avatar)) {
            Storage::disk('public')->delete($avatar);
        }

        if ($thumb && Storage::disk('public')->exists($thumb)) {
            Storage::disk('public')->delete($thumb);
        }
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
