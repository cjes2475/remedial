@extends('layouts.app')

@section('title', 'Food Battle - My Ultimate Food & Drink Collection')

@section('content')
    <section class="page-title">
        <h1>Food Battle</h1>
        <p>Two random favorites go head-to-head across a fixed number of rounds. Vote each round and see the winner at the end.</p>
    </section>

    <form class="form-box" method="GET" action="{{ route('favorites.battle') }}" style="margin: 22px 0;">
        <div class="form-grid">
            <label>
                Number of Rounds
                <select name="rounds">
                    @foreach ($roundOptions as $roundOption)
                        <option value="{{ $roundOption }}" @selected(($battle['rounds'] ?? 3) === $roundOption)>{{ $roundOption }} rounds</option>
                    @endforeach
                </select>
            </label>
            <div class="actions" style="align-items: end;">
                <button class="button primary" type="submit">Start Battle</button>
                <a class="button" href="{{ route('favorites.battle', ['reset' => 1, 'rounds' => $battle['rounds'] ?? 3]) }}">Reset</a>
            </div>
        </div>
    </form>

    @if (($battle['finished'] ?? false) && $winner)
        <section class="band">
            <div class="panel">
                <h2>{{ $winner->name }} wins the Food Battle</h2>
                <p class="muted">Final score: {{ $battle['scores'][(string) $winner->id] ?? 0 }} vote(s) across {{ $battle['rounds'] }} rounds.</p>
                <div class="actions">
                    <a class="button primary" href="{{ route('favorites.battle', ['reset' => 1, 'rounds' => $battle['rounds']]) }}">Start Again</a>
                    <a class="button" href="{{ route('favorites.show', $winner) }}">View Winner</a>
                </div>
            </div>
        </section>
    @elseif ($items->count() === 2)
        <section class="band">
            <div class="section-head">
                <div>
                    <h2>Round {{ $battle['round'] }} of {{ $battle['rounds'] }}</h2>
                    <p class="muted">Pick one winner to advance to the next round.</p>
                </div>
            </div>
            <div class="grid">
                @foreach ($items as $item)
                    <article class="card">
                        <div class="card-media">
                            @if ($item->imageSource())
                                <img src="{{ $item->imageSource() }}" alt="{{ $item->name }}">
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
                            <p class="muted">{{ $item->description ? \Illuminate\Support\Str::limit($item->description, 120) : 'No description added.' }}</p>
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
