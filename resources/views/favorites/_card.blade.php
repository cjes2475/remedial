<article class="card">
    <a class="card-media" href="{{ route('favorites.show', $favorite) }}">
        @if ($favorite->imageSource())
            <img src="{{ $favorite->imageSource() }}" alt="{{ $favorite->name }}">
        @else
            <div class="placeholder">{{ $favorite->category }}</div>
        @endif
    </a>
    <div class="card-body">
        <h3><a href="{{ route('favorites.show', $favorite) }}">{{ $favorite->name }}</a></h3>
        <div class="meta">
            <span class="pill cool">{{ $favorite->category }}</span>
            <span class="pill hot">{{ number_format((float) $favorite->rating, 1) }} rating</span>
            <span class="pill">Level {{ $favorite->favorite_level }}/10</span>
        </div>
        <p class="muted">{{ $favorite->description ? \Illuminate\Support\Str::limit($favorite->description, 110) : 'No description added.' }}</p>
        <div class="actions">
            <a class="button soft" href="{{ route('favorites.show', $favorite) }}">View</a>
            <a class="button" href="{{ route('favorites.edit', $favorite) }}">Edit</a>
        </div>
    </div>
</article>
