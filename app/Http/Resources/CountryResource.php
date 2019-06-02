<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CountryResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->nowTimestamp = time();
        return [
            'success'=>true,
            'timestamp'=>$this->nowTimestamp,
            'countries'=>$this->collection,

            ];
    }
}
