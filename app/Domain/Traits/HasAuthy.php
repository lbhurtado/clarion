<?php

namespace Clarion\Domain\Traits;

trait HasAuthy
{

        public static function bootHasAuthy()
        {
                static::created(function ($model) {
                        event(new \Clarion\Domain\Events\UserWasRecorded($model));
                });

                static::updated(function ($model) {
                        if ($model->wasRecentlyCreated == true) {
                                if ($model->isDirty('authy_id') && ! empty($model->authy_id)) {
                                        event(new \Clarion\Domain\Events\UserWasRegistered($model));
                                }             
                        }
                });
        }
}