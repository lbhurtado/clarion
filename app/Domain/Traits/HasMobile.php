<?php

namespace Clarion\Domain\Traits;

use Clarion\Domain\Models\Mobile;

trait HasMobile
{

	public static function bootHasMobile()
	{
        static::creating(function ($model) {
            $model->mobile = Mobile::number($model->mobile);
            $model->handle = $model->handle ?: $model->mobile;
        });
	}
}
