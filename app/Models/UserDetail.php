<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'birth_date',
        'sex',
        'nationality',
        'citizenship',
        'address',
        'tel_1',
        'tel_2',
        'family_status',
        'children',
        'started_work_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = ['children' => 'array'];

    /**
     * The user that belong to the user_detail.
     *
     * @return BelongsTo<UserDetail>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
