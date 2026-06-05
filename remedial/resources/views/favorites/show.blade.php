@extends('layouts.app')

@section('title', $favorite->name.' - My Ultimate Food & Drink Collection')

@section('content')
    <section class="hero">
        <div>
            <div class="meta">
                <span class="pill cool">{{ $favorite->category }}</span>
                <span class="pill hot">{{ number_format((float) $favorite->rating, 1) }} rating</span>
                <span class="pill">Level {{ $favorite->favorite_level }}/10</span>
            </div>
            <h1>{{ $favorite->name }}</h1>
            <p>{{ $favorite->description }}</p>
            <div class="actions">
                <a class="button primary" href="{{ route('favorites.edit', $favorite) }}">Edit</a>
                <a class="button" href="{{ route('favorites.index') }}">Back to Collection</a>
                <form method="POST" action="{{ route('favorites.destroy', $favorite) }}" onsubmit="return confirm('Delete {{ $favorite->name }} from the collection?');">
                    @csrf
                    @method('DELETE')
                    <button class="button danger" type="submit">Delete</button>
                </form>
            </div>
        </div>
        <div class="hero-visual">
            @if ($favorite->image_url)
                <img src="{{ $favorite->image_url }}" alt="{{ $favorite->name }}">
            @else
                <div class="placeholder">{{ $favorite->category }}</div>
            @endif
        </div>
    </section>

    <section class="band">
        <div class="grid tight">
            <div class="stat"><h3>PHP {{ number_format((float) $favorite->price, 2) }}</h3><p class="muted">Price</p></div>
            <div class="stat"><h3>{{ number_format($favorite->calories) }}</h3><p class="muted">Calories</p></div>
            <div class="stat"><h3>{{ $favorite->reaction ?: 'None' }}</h3><p class="muted">Reaction</p></div>
            <div class="stat"><h3>{{ $favorite->battle_wins }} - {{ $favorite->battle_losses }}</h3><p class="muted">Battle Record</p></div>
            <div class="stat"><h3>{{ $favorite->battleWinRate() }}%</h3><p class="muted">Battle Win Rate</p></div>
        </div>
    </section>

    <section class="band">
        <div class="section-head">
            <div>
                <h2>Mood Tags</h2>
                <p class="muted">Used by the craving recommendation feature.</p>
            </div>
        </div>
        <div class="meta">
            @forelse (($favorite->mood_tags ?? []) as $mood)
                <span class="pill">{{ $mood }}</span>
            @empty
                <span class="muted">No moods tagged yet.</span>
            @endforelse
        </div>
    </section>

    @if ($similar->count())
        <section class="band">
            <div class="section-head">
                <div>
                    <h2>Similar Favorites</h2>
                    <p class="muted">More {{ strtolower($favorite->category) }} entries you may like.</p>
                </div>
            </div>
            <div class="grid">
                @foreach ($similar as $item)
                    @include('favorites._card', ['favorite' => $item])
                @endforeach
            </div>
        </section>
    @endif
@endsection
