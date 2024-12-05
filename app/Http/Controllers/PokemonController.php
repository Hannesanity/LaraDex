<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PokemonController extends Controller
{
    
    public function index(Request $request) {
        
        $response = Http::get("https://pokeapi.co/api/v2/pokemon?limit=10000");
        $pokemonLists = $response->json()['results'];

        $searchQuery = $request->input('search');

        if ($searchQuery) {
            $filteredPokemon = array_filter(
                $pokemonLists,
                function ($pokemon) use ($searchQuery) {
                    return stripos($pokemon['name'], $searchQuery) !== false;
                }
            );

            $pokemonLists = array_values($filteredPokemon);
        }

        $page = request()->get('page', 1);
        $limit = 16;
        $offset = ($page - 1) * $limit;
        
        $pokemonListPerPage = array_slice($pokemonLists, $offset, $limit);

        $totalPages = ceil(count($pokemonLists) / $limit);

        $pokemonDetails = [];

        $normalizeName = function ($name) {
            $name = ucwords(str_replace('-', ' ', $name));
            if (stripos($name, 'Mega') !== false) {
                $name = str_ireplace('Mega', '', $name);
                $name = 'Mega ' . trim($name);
            };
            return $name;
        };

        foreach ($pokemonListPerPage as $pokemon){
            $pokeDetails = Http::get($pokemon['url'])->json();
            $pokemonDetails[] = [
                'name' => $normalizeName($pokemon['name']),
                'url' => $pokemon['url'],
                'id' => $pokeDetails['id'],
                'sprite' => $pokeDetails['sprites']['front_default'],
                'types' => $pokeDetails['types']
            ];
        }

        

        return view('index', [
            'pokemonDetails' => $pokemonDetails,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'searchQuery' => $searchQuery
        ]);

    }

    public function show($id) {
        $response = Http::get('https://pokeapi.co/api/v2/pokemon/' . $id);
        $pokemonInfo = $response->json();
        $pokeInfo = [
            'id' => $pokemonInfo['id'],
            'name' => $pokemonInfo['name'],
            'height' => $pokemonInfo['height'],
            'weight' => $pokemonInfo['weight'],
            'types' => $pokemonInfo['types'],
            'sprite' => $pokemonInfo['sprites']['other']['official-artwork']['front_default'],
            'abilities' => $pokemonInfo['abilities'],
            'stats' => array_map(function($stat) { return [ 'base_stat' => $stat['base_stat'], 'name' => ucwords(str_replace('-', ' ', $stat['stat']['name'])) ]; }, $pokemonInfo['stats']),
        ];

        $previousPokemon = null;
        $nextPokemon = null;

        if ($id > 1) {
            $previousResponse = Http::get('https://pokeapi.co/api/v2/pokemon/' . ($id - 1));
            if ($previousResponse->successful()) {
                $previousData = $previousResponse->json();
                $previousPokemon = [
                    'id' => $id - 1,
                    'name' => $previousData['name'],
                ];
            }
        }

        $nextResponse = Http::get('https://pokeapi.co/api/v2/pokemon/' . ($id + 1));
        if ($nextResponse->successful()) {
            $nextData = $nextResponse->json();
            $nextPokemon = [
                'id' => $id + 1,
                'name' => $nextData['name'],
            ];
        }   


        $species = Http::get('https://pokeapi.co/api/v2/pokemon-species/' . $id);
        $pokespecies = $species->json();
        $flavor_text = '';
        $category = '';
        $evolution_chain = Http::get($pokespecies['evolution_chain']['url']);
        $evolution_chain = $evolution_chain->json();
        $pokeWeaknesses = [];

        foreach ($pokespecies['flavor_text_entries'] as $entry) {
            if ($entry['language']['name'] === 'en' && $entry['version']['name'] === 'shield') {
                $flavor_text = $entry['flavor_text'];
                break; 
            };
        }
        foreach ($pokespecies['genera'] as $genera) {
            if ($genera['language']['name'] === 'en') {
                $category = $genera['genus'];
                break; 
            };
        }
        
        foreach ($pokeInfo['types'] as $type) {
            $typeResponse = Http::get($type['type']['url']);
            $typeData = $typeResponse->json();
            foreach ($typeData['damage_relations']['double_damage_from'] as $weakness) {
                if (in_array($weakness['name'], $pokeWeaknesses)) {
                    continue;
                }
                else{
                    $pokeWeaknesses[] = $weakness['name'];
                }
            }

        }


        $getIdFromUrl = function($url) {
            preg_match('/\/(\d+)\//', $url, $matches);
            return isset($matches[1]) ? (int)$matches[1] : null;
        };


        $pokeEvolutions[] = [
            'name' => $evolution_chain['chain']['species']['name'],
            'id' => $getIdFromUrl($evolution_chain['chain']['species']['url'])
        ];

        if (!empty($evolution_chain['chain']['evolves_to'])) {
            foreach ($evolution_chain['chain']['evolves_to'] as $firstEvolution) {
               $pokeEvolutions[] = [
                'name' => $firstEvolution['species']['name'],
                'id' => $getIdFromUrl($firstEvolution['species']['url'])
               ];
               
               if (!empty($firstEvolution['evolves_to'])) {
                   foreach ($firstEvolution['evolves_to'] as $secondEvolution) {
                       $pokeEvolutions[] = [
                        'name' => $secondEvolution['species']['name'],
                        'id' => $getIdFromUrl($secondEvolution['species']['url'])
                       ];
                   }
               }
            }
        }

        
        return view('pokemon.show', [
            'pokeInfo' => $pokeInfo, 
            'previousPokemon' => $previousPokemon,
            'nextPokemon' => $nextPokemon,
            'pokedescription' => $flavor_text, 
            'pokecategory' => $category, 
            'evolution_chain' => $pokeEvolutions,
            'pokeWeaknesses' => $pokeWeaknesses
        ]);
    }
}