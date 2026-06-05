@extends('layouts.app')

@section('title', 'Dashboard - My Ultimate Food & Drink Collection')

@section('content')
    <section class="hero">
        <div>
            <h1>My Ultimate Food & Drink Collection</h1>
            <p>A Laravel recommendation app for favorite meals, drinks, cravings, ratings, prices, calories, and personal ranking.</p>
            <div class="actions">
                <a class="button primary" href="{{ route('favorites.create') }}">Add Favorite</a>
                <a class="button soft" href="{{ route('favorites.index') }}">Browse Collection</a>
                <a class="button" href="{{ route('favorites.surprise') }}">Surprise Me</a>
            </div>
        </div>
        <div class="hero-visual">
            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80" alt="Colorful table of food and drinks">
        </div>
    </section>

    <section class="band">
        <div class="section-head">
            <div>
                <h2>Favorites Dashboard</h2>
                <p class="muted">Quick statistics from the seeded database.</p>
            </div>
        </div>
        <div class="grid tight">
            <div class="stat"><h3>{{ $stats['total_foods'] }}</h3><p class="muted">Total Foods</p></div>
            <div class="stat"><h3>{{ $stats['total_drinks'] }}</h3><p class="muted">Total Drinks</p></div>
            <div class="stat"><h3>{{ number_format($stats['average_rating'], 1) }}</h3><p class="muted">Average Rating</p></div>
            <div class="stat"><h3>{{ optional($stats['highest_rated'])->name ?? 'None yet' }}</h3><p class="muted">Highest-Rated Item</p></div>
            <div class="stat"><h3>{{ optional($stats['recent'])->name ?? 'None yet' }}</h3><p class="muted">Recently Added Favorite</p></div>
        </div>
    </section>

    <section class="band">
        <div class="section-head">
            <div>
                <h2>Dynamic Ranking</h2>
                <p class="muted">Top 10 plus the standout items requested in the activity.</p>
            </div>
        </div>

        <div class="grid tight">
            <div class="panel"><h2>{{ optional($mostRecommended)->name ?? 'None' }}</h2><p class="muted">User's Most Recommended</p></div>
            <div class="panel"><h2>{{ optional($mostExpensive)->name ?? 'None' }}</h2><p class="muted">Most Expensive: {{ $mostExpensive ? 'PHP '.number_format((float) $mostExpensive->price, 2) : 'N/A' }}</p></div>
            <div class="panel"><h2>{{ optional($cheapest)->name ?? 'None' }}</h2><p class="muted">Cheapest: {{ $cheapest ? 'PHP '.number_format((float) $cheapest->price, 2) : 'N/A' }}</p></div>
            <div class="panel"><h2>{{ optional($highestCalorie)->name ?? 'None' }}</h2><p class="muted">Highest Calorie: {{ $highestCalorie ? number_format($highestCalorie->calories).' cal' : 'N/A' }}</p></div>
        </div>

        <div class="panel" style="margin-top: 16px;">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Rating</th>
                            <th>Favorite Level</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topTen as $favorite)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('favorites.show', $favorite) }}">{{ $favorite->name }}</a></td>
                                <td>{{ $favorite->category }}</td>
                                <td>{{ number_format((float) $favorite->rating, 1) }}</td>
                                <td>{{ $favorite->favorite_level }}/10</td>
                                <td>PHP {{ number_format((float) $favorite->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
