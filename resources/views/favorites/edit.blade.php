@extends('layouts.app')

@section('title', 'Edit '.$favorite->name.' - My Ultimate Food & Drink Collection')

@section('content')
    <section class="page-title">
        <h1>Edit Favorite</h1>
        <p>Update the details for {{ $favorite->name }}.</p>
    </section>

    <form class="form-box" method="POST" action="{{ route('favorites.update', $favorite) }}" style="margin-top: 22px;">
        @csrf
        @method('PUT')
        @include('favorites._form')
        <div class="actions">
            <button class="button primary" type="submit">Update Favorite</button>
            <a class="button" href="{{ route('favorites.show', $favorite) }}">Cancel</a>
        </div>
    </form>
@endsection
