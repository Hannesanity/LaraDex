<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PokemonCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => ucfirst($this->name),
            'height' => $this->height,
            'weight' => $this->weight,
            'abilities' => $this->abilities,
            'types' => $this->types,
            'stats' => $this->stats,
            'sprites' => $this->sprites['front_default'],
        ];
    }
}
