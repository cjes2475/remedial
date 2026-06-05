<article class="card">
    <a class="card-media" href="{{ route('favorites.show', $favorite) }}">
        @if ($favorite->image_url)
            <img src="{{ str_starts_with($favorite->image_url, 'http') ? $favorite->image_url : asset('storage/'.$favorite->image_url) }}" alt="{{ $favorite->name }}">
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
        <p class="muted">{{ \Illuminate\Support\Str::limit($favorite->description, 110) }}</p>
        <div class="actions">
            <a class="button soft" href="{{ route('favorites.show', $favorite) }}">View</a>
            <a class="button" href="{{ route('favorites.edit', $favorite) }}">Edit</a>
        </div>
    </div>
</article>
