<?php

namespace App;

use Illuminate\Contracts\Support\Arrayable;

class Coordinate implements Arrayable
{
    /**
     * @var float
     */
    private $lat;

    /**
     * @var float
     */
    private $lon;

    /**
     * @param float $lat
     * @param float $lon
     */
    public function __construct(float $lat, float $lon)
    {
        $this->lat = $lat;
        $this->lon = $lon;
    }

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @return float
     */
    public function getLon(): float
    {
        return $this->lon;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'lat' => $this->getLat(),
            'lon' => $this->getLon(),
        ];
    }
}
