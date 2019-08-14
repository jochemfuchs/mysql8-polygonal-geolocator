<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MapRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'north'     => 'required|numeric',
            'south'     => 'required|numeric',
            'east'      => 'required|numeric',
            'west'      => 'required|numeric',
            'markerIds' => 'nullable|array'
        ];
    }

    /**
     * @return float[]
     */
    public function getMapBounds(): array
    {
        return [
            'south' => floatval($this->get('south')),
            'west'  => floatval($this->get('west')),
            'north' => floatval($this->get('north')),
            'east'  => floatval($this->get('east'))
        ];
    }

    /**
     * @return int[]|null
     */
    public function getMarkerIds(): ?array
    {
        $markerIds = $this->get('markerIds');

        if(empty($markerIds)) {
            return null;
        }

        return array_map(function($item){
            return intval($item);
        }, $markerIds);
    }
}
