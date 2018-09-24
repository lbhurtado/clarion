<?php

namespace Clarion\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Messenger.
 *
 * @package namespace Clarion\Domain\Models;
 */
class Messenger extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'driver',
        'chat_id',
        'first_name',
        'last_name'
	];

    public function user()
    {
        return $this->belongsTo(User::class, 'identifier', 'identifier');
    }

}
