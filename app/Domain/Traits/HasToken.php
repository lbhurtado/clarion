<?php

namespace Clarion\Domain\Traits;

use Tymon\JWTAuth\Contracts\JWTSubject;

trait HasToken
{
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
