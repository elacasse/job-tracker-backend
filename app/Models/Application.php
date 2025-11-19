<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Random\RandomException;

/**
 * @property int $id
 * @property string $name
 * @property string $token_hash
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereTokenHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Application extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'token_hash'];

    /**
     * @throws RandomException
     */
    public static function createToken(bool|array|string|null $name): string
    {
        $token = bin2hex(random_bytes(32)); // 64 chars secure token

        self::create([
            'name' => $name,
            'token_hash' => Hash::make($token),
        ]);

        return $token;
    }
}
