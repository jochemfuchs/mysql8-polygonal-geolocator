<?php

namespace App\Http\Controllers;

use App\Http\Requests\MapRequest;
use App\Http\Resources\MarkerResource;
use App\Services\LocationFinderService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use InvalidArgumentException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getLocations(MapRequest $request, LocationFinderService $finderService)
    {
        if(!$request->validated()) {
            throw new InvalidArgumentException('Invalid map bounds');
        }

        $markers = $finderService->findByBounds(
            $request->getMapBounds(),
            $request->getMarkerIds()
        );

        return MarkerResource::collection(
            $markers->paginate(100)
        );
    }
}
