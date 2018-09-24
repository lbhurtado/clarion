<?php

namespace Clarion\Domain\Traits;

use Larapackages\AnonymousRelationships\Traits\GeneratesIdentifier;

trait IsAnonymous
{
    use GeneratesIdentifier;

    public function getIdentifierAttribute()
    {
        return $this->generateIdentifier($this->mobile);
    }
}
