<?php

namespace App\Services;

use App\Marker;
use Illuminate\Database\Eloquent\Builder;

class LocationFinderService
{
    /**
     * @param array $mapBounds
     * @param array|null $markerIds
     *
     * @return Builder
     */
    public function findByBounds(array $mapBounds, array $markerIds = null)
    {
        $srid = env('SPATIAL_REF_ID', 4326);

        [   'south' => $south,
            'west'  => $west,
            'north' => $north,
            'east'  => $east
        ] = $mapBounds;

        $query = Marker::query()
            ->whereRaw("
            ST_Contains(
                ST_PolygonFromText('POLYGON(
                       ($north $west, $north $east, $south $east, $south $west, $north $west)
                    )', {$srid}), 
                `coordinate` 
            )");

        if($markerIds) {
            $query->whereNotIn('id', $markerIds);
        }

        return $query;
    }
}
