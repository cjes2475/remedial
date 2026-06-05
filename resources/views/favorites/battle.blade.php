@extends('layouts.app')

@section('title', 'Food Battle - My Ultimate Food & Drink Collection')

@section('content')
    <section class="page-title">
        <h1>Food Battle</h1>
        <p>Two random favorites go head-to-head. Vote which one is better and the battle record updates.</p>
    </section>

    @if ($items->count() === 2)
        <section class="band">
            <div class="grid">
                @foreach ($items as $item)
                    <article class="card">
                        <div class="card-media">
                            @if ($item->image_url)
                                <img src="{{ str_starts_with($item->image_url, 'http') ? $item->image_url : asset('storage/'.$item->image_url) }}" alt="{{ $item->name }}">
                            @else
                                <div class="placeholder">{{ $item->category }}</div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h3>{{ $item->name }}</h3>
                            <div class="meta">
                                <span class="pill cool">{{ $item->category }}</span>
                                <span class="pill hot">{{ number_format((float) $item->rating, 1) }} rating</span>
                                <span class="pill">{{ $item->battle_wins }} wins</span>
                            </div>
                            <p class="muted">{{ \Illuminate\Support\Str::limit($item->description, 120) }}</p>
                            <form method="POST" action="{{ route('favorites.battle.vote') }}">
                                @csrf
                                <input type="hidden" name="winner_id" value="{{ $item->id }}">
                                <input type="hidden" name="loser_id" value="{{ $items->firstWhere('id', '!=', $item->id)->id }}">
                                <button class="button primary" type="submit">Vote {{ $item->name }}</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="actions">
                <a class="button" href="{{ route('favorites.battle') }}">New Matchup</a>
            </div>
        </section>
    @else
        <div class="panel" style="margin-top: 22px;">
            <h2>Need at least two favorites</h2>
            <p class="muted">Seed the database or add more records before starting a battle.</p>
        </div>
    @endif
@endsection
