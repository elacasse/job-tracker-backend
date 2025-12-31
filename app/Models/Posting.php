<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property int $user_id
 * @property string $source
 * @property string $source_id
 * @property string $employment_type
 * @property string $work_mode
 * @property string $url
 * @property string $company
 * @property string $title
 * @property string $description
 * @property string $status
 * @property string|null $cover_letter
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\PostingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting whereCoverLetter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting whereEmploymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Posting whereWorkMode($value)
 * @mixin \Eloquent
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
}
