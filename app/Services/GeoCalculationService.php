<?php

namespace App\Services;

use App\Coordinate;

class GeoCalculationService
{
    /**
     * Earth radius in meters.
     *
     * @var int
     */
    private const EARTH_RADIUS = 6371000;

    /**
     * Calculates the center point between 2 or more locations.
     *
     * @param Coordinate $coordinates
     * @param int         $distance
     * @param int         $heading
     *
     * @return Coordinate
     */
    public function project(Coordinate $coordinates, int $distance, int $heading)
    {
        $lat      = deg2rad($coordinates->getLat());
        $lon      = deg2rad($coordinates->getLon());
        $distance = $distance/self::EARTH_RADIUS;
        $heading  = deg2rad($heading);

        $newLat = asin(
            sin($lat) *
            cos($distance) +
            cos($lat) *
            sin($distance) *
            cos($heading)
        );

        $newLon = $lon +
            atan2(
                sin($heading) *
                sin($distance) *
                cos($lat),
                cos($distance) -
                sin($lat) *
                sin($newLat)
            );

        $newLon = fmod(($newLon + 3 * pi()), (2 * pi())) - pi();

        return new Coordinate(rad2deg($newLat), rad2deg($newLon));
    }

    /**
     * @param Coordinate $coordinates
     * @param int         $maxDistance
     *
     * @return Coordinate
     */
    public function randomCoordinate(Coordinate $coordinates, int $maxDistance): Coordinate
    {
        $heading  = mt_rand(0, 359);
        $distance = mt_rand(0, $maxDistance);

        return $this->project($coordinates, $distance, $heading);
    }
}
