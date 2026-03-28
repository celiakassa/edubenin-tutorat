<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cache
 *
 * @property string $key
 * @property string $value
 * @property int $expiration
 */
final class Cache extends Model
{
    public $incrementing = false;

    public $timestamps = false;

    protected $table = 'cache';

    protected $primaryKey = 'key';

    protected $fillable = [
        'value',
        'expiration',
    ];

    protected function casts(): array
    {
        return [
            'expiration' => 'int',
        ];
    }
}
