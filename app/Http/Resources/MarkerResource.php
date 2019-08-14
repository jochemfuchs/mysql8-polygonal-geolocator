<?php

namespace App\Http\Resources;

use App\Marker;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarkerResource extends JsonResource
{
    /**
     * @var Marker
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        $marker                = [];
        $marker['id']          = $this->resource->getKey();
        $marker['name']        = $this->resource->getName();
        $marker['coordinates'] = $this->resource->getCoordinate()->toArray();

        return $marker;
    }
}
