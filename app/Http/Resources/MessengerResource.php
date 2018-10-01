<?php

namespace Clarion\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessengerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'driver' => $this->driver,
            'chat_id' => $this->chat_id,
        ];
    }
}
