<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Database\Factories\PostingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting query()
 * @mixin \Eloquent
 * @property mixed $user_id
 */
class Posting extends Model
{
    /** @use HasFactory<\Database\Factories\PostingFactory> */
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'user_id',
        'source',
        'source_id',
        'employment_type',
        'work_mode',
        'url',
        'company',
        'title',
        'description',
        'status',
        'cover_letter',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $posting) {
            if (!$posting->user_id && auth()->check()) {
                $posting->user_id = auth()->id();
            }
        });
    }
}
