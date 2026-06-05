@extends('layouts.app')

@section('title', 'Surprise Me - My Ultimate Food & Drink Collection')

@section('content')
    <section class="page-title">
        <h1>Surprise Me</h1>
        <p>The random food generator selects one item from the database each time you refresh or press the button.</p>
    </section>

    @if ($favorite)
        <div style="margin-top: 22px;">
            @include('favorites._card', ['favorite' => $favorite])
        </div>
        <div class="actions">
            <a class="button primary" href="{{ route('favorites.surprise') }}">Pick Another</a>
            <a class="button" href="{{ route('favorites.show', $favorite) }}">View Details</a>
        </div>
    @else
        <div class="panel" style="margin-top: 22px;">
            <h2>No favorites available</h2>
            <p class="muted">Seed the database or add your first favorite item.</p>
        </div>
    @endif
@endsection
