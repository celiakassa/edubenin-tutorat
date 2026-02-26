<?php

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
 *
 * @package App\Models
 */
class Cache extends Model
{
	protected $table = 'cache';
	protected $primaryKey = 'key';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'value',
		'expiration'
	];
    protected function casts(): array
    {
        return [
    		'expiration' => 'int'
    	];
    }
}
