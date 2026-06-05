@extends('layouts.app')

@section('title', 'Mood Recommendation - My Ultimate Food & Drink Collection')

@section('content')
    <section class="page-title">
        <h1>What are you craving today?</h1>
        <p>Choose a mood and the system recommends matching foods and drinks from your database.</p>
    </section>

    <form class="form-box" method="GET" action="{{ route('favorites.mood') }}" style="margin: 22px 0;">
        <div class="form-grid">
            <label>
                Craving Mood
                <select name="mood" required>
                    <option value="">Select a mood</option>
                    @foreach ($moods as $mood)
                        <option value="{{ $mood }}" @selected($selectedMood === $mood)>{{ $mood }}</option>
                    @endforeach
                </select>
            </label>
            <div class="actions" style="align-items: end;">
                <button class="button primary" type="submit">Recommend</button>
            </div>
        </div>
    </form>

    @if ($selectedMood)
        <section class="band">
            <div class="section-head">
                <h2>{{ $selectedMood }} Recommendations</h2>
            </div>
            @if ($recommendations->count())
                <div class="grid">
                    @foreach ($recommendations as $favorite)
                        @include('favorites._card', ['favorite' => $favorite])
                    @endforeach
                </div>
            @else
                <div class="panel">
                    <h2>No match yet</h2>
                    <p class="muted">Add a new favorite and tag it with {{ $selectedMood }}.</p>
                </div>
            @endif
        </section>
    @endif
@endsection
