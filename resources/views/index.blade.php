@extends('layouts.layout')

@section('title', 'Welcome to PokeDex!')

@section('content')
    <section class="pokedex">
        <div class="filterAndSearch">
            <form method="GET" action="" class="search-form">
                <label for="searchBox">Search: </label>
                <input type="text" id="searchBox" class="searchBox" name="search" placeholder="Ditto" value="{{ request('search') }}">
                <button type="submit">Search</button>
            </form>
            
            <form method="GET" action="/" class="filterBy">
                <label for="pokeFilter">Filter by type:</label>
                <select name="type" id="pokeFilter" class="pokeFilter" onchange="this.form.submit()">
                    <option value="all" {{ request('type') === 'all' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>All</option>
                    <option value="normal" class="text-normal" {{ request('type') === 'normal' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Normal</option>
                    <option value="fire" class="text-fire" {{ request('type') === 'fire' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Fire</option>
                    <option value="water" class="text-water" {{ request('type') === 'water' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Water</option>
                    <option value="electric" class="text-electric" {{ request('type') === 'electric' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Electric</option>
                    <option value="grass" class="text-grass" {{ request('type') === 'grass' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Grass</option>
                    <option value="ice" class="text-ice" {{ request('type') === 'ice' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Ice</option>
                    <option value="fighting" class="text-fighting" {{ request('type') === 'fighting' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Fighting</option>
                    <option value="poison" class="text-poison" {{ request('type') === 'poison' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Poison</option>
                    <option value="ground" class="text-ground" {{ request('type') === 'ground' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Ground</option>
                    <option value="flying" class="text-flying" {{ request('type') === 'flying' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Flying</option>
                    <option value="psychic" class="text-psychic" {{ request('type') === 'psychic' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Psychic</option>
                    <option value="bug" class="text-bug" {{ request('type') === 'bug' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Bug</option>
                    <option value="rock" class="text-rock" {{ request('type') === 'rock' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Rock</option>
                    <option value="ghost" class="text-ghost" {{ request('type') === 'ghost' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Ghost</option>
                    <option value="steel" class="text-steel" {{ request('type') === 'steel' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Steel</option>
                    <option value="dragon" class="text-dragon" {{ request('type') === 'dragon' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Dragon</option>
                    <option value="dark" class="text-dark" {{ request('type') === 'dark' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Dark</option>
                    <option value="fairy" class="text-fairy" {{ request('type') === 'fairy' ? 'selected' : '' }}&page={{ request('page') }}&search{{ request('search') }}>Fairy</option>
                </select>
            </form>
        </div>

        <div class="pokemon-list">
        @foreach ($pokemonDetails as $pokeList)

            <div class="pokeCards">
                <div class="pokedex-pokemon">
                    <a href="/pokemon/{{ $pokeList['id'] }}" class="pokedex-image" aria-label="View details of {{ ucfirst($pokeList['name']) }}">
                        <img src="{{ $pokeList['sprite'] }}" alt="{{ ucfirst($pokeList['name']) }}">
                    </a>
                    <p class="font-semibold text-md"># {{ $pokeList['id'] }}<p>
                    <h5 class="font-bold text-2xl ">{{ ucfirst($pokeList['name']) }}</h5>
                </div>
                <div class="index-types">
                    @foreach ($pokeList['types'] as $pokeTypes)
                        <div class="pokemon-type {{ $pokeTypes['type']['name'] }}">
                            <p> {{ ucfirst($pokeTypes['type']['name']) }} </p>
                        </div>
                    @endforeach
                </div>
            </div>
        
        @endforeach
        </div>

        <div class="page">
            <div class="page-container">
                <div class="page-list">
                    <!-- Previous Page Link -->
                    @if ($currentPage > 1)
                        <a href="?page={{ $currentPage - 1 }}&type={{ request('type') }}&search={{ request('search') }}" class="page-prev">Previous</a>
                    @endif

                    <!-- Page Links -->
                    @for ($i = max(1, $currentPage - 5); $i <= min($currentPage + 4, $totalPages); $i++)
                        <a href="?page={{ $i }}&type={{ request('type') }}&search={{ request('search') }}" class="page-number">{{ $i }}</a>
                    @endfor

                    <!-- Next Page Link -->
                    @if ($currentPage < $totalPages)
                        <a href="?page={{ $currentPage + 1 }}&type={{ request('type') }}&search={{ request('search') }}" class="page-next">Next</a>
                    @endif
                </div>
                <form method="GET" action="" class="page-form">
                    <label for="pageBox" class="my-4"> Go to page: </label>
                    <input type="number" id="pageBox" name="page" class="pageBox" min="1" max="{{ $totalPages }} " placeholder="Page #">
                    <button type="submit"> Go</button>
                    <p class="current-page"> Page {{ $currentPage }} of {{ $totalPages }}</p>
                </form>
                
                
            </div>
        </div>
        
    </section>
@endsection
