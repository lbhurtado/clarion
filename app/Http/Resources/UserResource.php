<?php

namespace Clarion\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'mobile' => $this->mobile,
            'handle' => $this->handle,
            'authy_id' => $this->authy_id,
        ];
    }
}
