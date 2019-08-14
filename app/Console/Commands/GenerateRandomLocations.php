<?php

namespace App\Console\Commands;

use App\Marker;
use Faker\Factory;
use App\Coordinate;
use Illuminate\Console\Command;
use App\Services\GeoCalculationService;

class GenerateRandomLocations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:locations 
                                {startLat=50.884408: Starting latitude} 
                                {startLon=5.756073: Starting longitude} 
                                {radius=50: Limiting radius from starting point in Km} 
                                {amount=100: Amount of locations to generate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate random locations, starting at a center and within a radius';

    /**
     * @param GeoCalculationService $service
     */
    public function handle(GeoCalculationService $service)
    {
        $faker         = Factory::create();
        $startingPoint = $this->getStartingPoint();

        for($i = 0; $i <= $this->getAmount(); $i++) {
            $newCoordinate = $service->randomCoordinate($startingPoint, $this->getRadius());

            (new Marker)
                ->setName($faker->name)
                ->setCoordinate($newCoordinate)
                ->save();
        }
    }

    /**
     * @return int
     */
    private function getAmount()
    {
        return intval($this->argument('amount'));
    }

    /**
     * @return int
     */
    private function getRadius()
    {
        return intval($this->argument('radius')) * 1000;
    }

    /**
     * @return Coordinate
     */
    private function getStartingPoint(): Coordinate
    {
        return new Coordinate(
            floatval($this->argument('startLat')),
            floatval($this->argument('startLon'))
        );
    }
}
