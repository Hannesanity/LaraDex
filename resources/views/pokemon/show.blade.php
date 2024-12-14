@extends('layouts.layout')

@section('title')
    {{ ucfirst($pokeInfo['name']) }}
@endsection


@section('content')
    @php
        $mainType = $pokeInfo['types'][0]['type']['name']; 
    @endphp
    <div class="pokemon-home">
        <a href="/" class="pokedex-title">
            <img src="{{ url('/images/pokeball.png') }}" alt="" class="pokeicon">
            <p class="text-title">PokéDex</p>
        </a>
    </div>
    
    <div class="pokemon-slider">
        @if ( $previousPokemon !== null)
        <div class="slider-left">
            <a href="/pokemon/{{ $previousPokemon['id'] }}" class="slider-arrow"><</a>
            <h4 class="slider-id"># {{ $previousPokemon['id'] }}</h4>
            <h3 class="slider-name">{{ ucfirst($previousPokemon['name']) }}</h3>
        </div>
        @endif
        
        <div class="pokemon-name">
            <h4 class="text-xl"># {{ ($pokeInfo['id']) }}</h4>
            <h3  class="main-name" >{{ ucfirst($pokeInfo['name']) }}</h3>
        </div>

        @if ( $nextPokemon !== null)
        <div class="slider-right">
            <h3 class="slider-name">{{ ucfirst($nextPokemon['name']) }}</h3>
            <h4 class="slider-id"># {{ $nextPokemon['id'] }}</h4>
            <a href="/pokemon/{{ $nextPokemon['id'] }}" class="slider-arrow">></a>
        </div>
        @endif
    </div>
    <div class="pokemon-detail">
        <section class="pokemon-profile">
            <div class="profile-left">
                <h4 class="text-title ">Types</h4>
                <div class="types-container">
                    @foreach ($pokeInfo['types'] as $pokeType)
                        <div class="pokemon-type {{ $pokeType['type']['name'] }}">
                            <p> {{ ucfirst($pokeType['type']['name']) }} </p>
                        </div>
                    @endforeach
                </div>
                <h4 class="text-title ">Weakness</h4>
                <div class="types-container">
                    @foreach ($pokeWeaknesses as $pokeWeakness)
                    <div class="pokemon-type {{ $pokeWeakness }}">
                        <p> {{ ucfirst($pokeWeakness) }} </p>
                    </div>
                    @endforeach
                </div>
                
            </div>
            
            <div class="profile-center background background-{{ $mainType}}"> 
                
                <div class="pokemon-image">
                    <img src="{{ $pokeInfo['sprite'] }}" alt="{{ ucfirst($pokeInfo['name']) }}">
                </div>
            </div>
            
            <div class="profile-right">
                <div class="pokemon-identity">
                    <div class="identity-left">
                        <div class="pokemon-height">
                            <h4 class="text-title">Height</h4>
                            <h4 class="text-content">{{ ($pokeInfo['height']) }} m</h4>
                        </div>
                        <div class="pokemon-weight">
                            <h4 class="text-title">Weight</h4>
                            <h4 class="text-content">{{ ($pokeInfo['weight']) }} kg</h4>
                        </div>
                        <div>
                            <h4 class="text-title ">Abilities</h4>                           
                            @foreach ($pokeInfo['abilities'] as $pokeAbility)
                                <h4 class="text-content">{{ ucwords(str_replace('-', ' ', $pokeAbility['ability']['name'])) }} </h4>
                            @endforeach                            
                        </div>
                    </div>
                    <div class="identity-right">
                        
                        <div class="pokemon-category">
                            <h4 class="text-title ">Category</h4>
                            <h4 class="text-content">{{ ucfirst($pokecategory) }}</h4>
                        </div>
                        <div class="pokemon-description">
                            <h4 class="text-title ">Description</h4>
                            <h4 class="text-content">{{ $pokedescription }}</h4>
                        </div>
                    </div>
                    
                    
                    
                </div>
            </div>
        </section>

        <div class="pokemon-info">
            <div class="pokemon-evolutions">
                <h4 class="text-title ">Evolutions</h4>
                <div class="evolution-contents {{ $mainType}}">
                @foreach ($evolution_chain as $index => $evolution)
                    <div class="evolution-item">
                        <a href="/pokemon/{{ $evolution['id'] }}">
                            <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/{{ $evolution['id'] }}.png" alt="{{ ucfirst($evolution['name']) }}" class="evolution-image">
                        </a>
                        <h4 class="text-content"># {{ $evolution['id'] }}</h4>
                        <h4 class="font-bold"> {{ ucfirst($evolution['name']) }}</h4>
                        <h4 class="text-content"> {{ $evolution['evolve_method'] }}</h4>
                    </div>
                    @if ($index < count($evolution_chain) - 1)
                        <div class="arrow-container">
                            <span class="arrow">&#8594;</span> <!-- Right arrow symbol -->
                        </div>
                    @endif
                @endforeach
                </div>
            </div>
            <div class="pokemon-stats">
                <h3 class="text-title ">Stats</h3>
                <div class="stats-container {{ $mainType}}">
                    @foreach ($pokeInfo['stats'] as $pokeStats)
                        <div class="pokeStats">
                            <h4 class="text-title">{{ ucwords($pokeStats['name']) }}</h4>
                            <h4>{{ $pokeStats['base_stat'] }}</h4>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
        
@endsection