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
            
            <div class="sortBy">
                <label for="pokeSearch">Sort by:</label>
                <select name="pokeSearch" id="pokeSearch" class="pokeSearch">
                    <option value="lowestNumber">Lowest Number</option>
                    <option value="highestNumber">Highest Number</option>
                    <option value="alphabeticalAsc">A - Z</option>
                    <option value="alphabeticalDesc">Z - A</option>
                </select>
            </div>
        </div>

        <div class="pokemon-list">
        @foreach ($pokemonDetails as $pokeList)

            <div class="pokeCards">
                <div class="pokedex-pokemon">
                    <a href="/pokemon/{{ $pokeList['id'] }}" class="pokedex-image" aria-label="View details of {{ ucfirst($pokeList['name']) }}">
                        <img src="{{ $pokeList['sprite'] }}" alt="{{ ucfirst($pokeList['name']) }}">
                    </a>
                    <p class="font-semibold text-md"># {{ $pokeList['id'] }}<p>
                    <h5 class="font-bold text-2xl">{{ ucfirst($pokeList['name']) }}</h5>
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
                        <a href="?page={{ $currentPage - 1 }}&search={{ request('search') }}" class="page-prev">Previous</a>
                    @endif

                    <!-- Page Links -->
                    @for ($i = max(1, $currentPage - 5); $i <= min($currentPage + 4, $totalPages); $i++)
                        <a href="?page={{ $i }}&search={{ request('search') }}" class="page-number">{{ $i }}</a>
                    @endfor

                    <!-- Next Page Link -->
                    @if ($currentPage < $totalPages)
                        <a href="?page={{ $currentPage + 1 }}&search={{ request('search') }}" class="page-next">Next</a>
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
