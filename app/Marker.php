<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'coordinate',
    ];

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name)
    {
        $this->attributes['name'] = $name;

        return $this;
    }

    /**
     * @param Coordinate $coordinates
     *
     * @return $this
     */
    public function setCoordinate(Coordinate $coordinates): self
    {
        $srid = env('SPATIAL_REF_ID', 4326);
        $lat  = $coordinates->getLat();
        $lon  = $coordinates->getLon();

        $this->attributes['coordinate'] = DB::raw("ST_GeomFromText('POINT($lat $lon)', $srid)");

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Coordinate
     */
    public function getCoordinate(): Coordinate
    {
        return new Coordinate($this->lat, $this->lon);
    }
}
