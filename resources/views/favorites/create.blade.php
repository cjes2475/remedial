@extends('layouts.app')

@section('title', 'Add Favorite - My Ultimate Food & Drink Collection')

@section('content')
    <section class="page-title">
        <h1>Add New Favorite</h1>
        <p>Record a food or drink with category, rating, price, calories, favorite level, mood tags, and an optional image.</p>
    </section>

    <form class="form-box" method="POST" action="{{ route('favorites.store') }}" enctype="multipart/form-data" style="margin-top: 22px;">
        @csrf
        @include('favorites._form')
        <div class="actions">
            <button class="button primary" type="submit">Save Favorite</button>
            <a class="button" href="{{ route('favorites.index') }}">Cancel</a>
        </div>
    </form>
@endsection
