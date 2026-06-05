@extends('layouts.app')

@section('title', 'Collection - My Ultimate Food & Drink Collection')

@section('content')
    <section class="page-title">
        <h1>Favorites Collection</h1>
        <p>Search, filter, edit, delete, and inspect every food and drink entry in the database.</p>
    </section>

    <form class="form-box" method="GET" action="{{ route('favorites.index') }}" style="margin: 22px 0;">
        <div class="form-grid">
            <label>
                Search
                <input name="search" value="{{ request('search') }}" placeholder="Name or description">
            </label>
            <label>
                Category
                <select name="category">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                    @endforeach
                </select>
            </label>
            <label>
                Minimum Rating
                <select name="rating">
                    <option value="">Any rating</option>
                    @foreach ([5, 4.5, 4, 3.5, 3] as $rating)
                        <option value="{{ $rating }}" @selected((string) request('rating') === (string) $rating)>{{ $rating }} and up</option>
                    @endforeach
                </select>
            </label>
            <div class="actions" style="align-items: end;">
                <button class="button primary" type="submit">Apply Filters</button>
                <a class="button" href="{{ route('favorites.index') }}">Clear</a>
            </div>
        </div>
    </form>

    @if ($favorites->count())
        <div class="grid">
            @foreach ($favorites as $favorite)
                @include('favorites._card', ['favorite' => $favorite])
            @endforeach
        </div>

        <div class="pagination">
            {{ $favorites->links() }}
        </div>
    @else
        <div class="panel">
            <h2>No favorites found</h2>
            <p class="muted">Try clearing the filters or add a new favorite item.</p>
            <div class="actions">
                <a class="button primary" href="{{ route('favorites.create') }}">Add Favorite</a>
            </div>
        </div>
    @endif
@endsection
