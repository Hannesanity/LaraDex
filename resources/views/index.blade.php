<html lang="en">
<head>
    <title>Welcome to PokeDex!</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Press+Start+2P&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body>
    
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
                    <option value="lowestNumber">Lowest Number (First)</option>
                    <option value="highestNumber">Highest Number (First)</option>
                    <option value="alphabeticalAsc">A - Z</option>
                    <option value="alphabeticalDesc">Z - A</option>
                </select>
            </div>
        </div>

        <div class="pokemon-list">
        @foreach ($pokemonDetails as $pokeList)

            <div class="pokeCards">
                <div class="pokedex-pokemon">
                    <a href="/pokemon/{{ $pokeList['id'] }}" class="pokedex-image">
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

                <form method="GET" action="" class="page-form">
                    <label for="pageBox" class="my-4"> Go to page: </label>
                    <input type="number" id="pageBox" name="page" class="pageBox" min="1" max="{{ $totalPages }} " placeholder="Page #">
                    <button type="submit"> Go</button>
                    <p class="current-page"> Page {{ $currentPage }} of {{ $totalPages }}</p>
                </form>
                
                
            </div>
        </div>
        
    </section>
</body>
</html>