<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Random\RandomException;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application query()
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
