@php
    $selectedMoods = old('mood_tags', $favorite->mood_tags ?? []);
@endphp

<div class="form-grid">
    <label>
        Food/Drink Name
        <input name="name" value="{{ old('name', $favorite->name) }}" required maxlength="120">
    </label>

    <label>
        Category
        <select name="category" required>
            @foreach ($categories as $category)
                <option value="{{ $category }}" @selected(old('category', $favorite->category) === $category)>{{ $category }}</option>
            @endforeach
        </select>
    </label>

    <label>
        Rating (1 to 5)
        <input type="number" name="rating" value="{{ old('rating', $favorite->rating) }}" min="1" max="5" step="0.1" required>
    </label>

    <label>
        Favorite Level (1 to 10)
        <input type="number" name="favorite_level" value="{{ old('favorite_level', $favorite->favorite_level) }}" min="1" max="10" required>
    </label>

    <label>
        Price
        <input type="number" name="price" value="{{ old('price', $favorite->price) }}" min="0" max="99999" step="0.01" required>
    </label>

    <label>
        Calories
        <input type="number" name="calories" value="{{ old('calories', $favorite->calories) }}" min="0" max="5000" required>
    </label>

    <label class="full">
        Description
        <textarea name="description" required maxlength="1000">{{ old('description', $favorite->description) }}</textarea>
    </label>

    <label>
        Image URL
        <input type="url" name="image_url" value="{{ old('image_url', $favorite->image_url) }}" placeholder="https://example.com/photo.jpg">
    </label>

    <label>
        Emoji Reaction or Short Reaction
        <input name="reaction" value="{{ old('reaction', $favorite->reaction) }}" maxlength="16" placeholder="yum">
    </label>

    <div class="full">
        <strong>Mood Tags</strong>
        <div class="checkboxes" style="margin-top: 8px;">
            @foreach ($moods as $mood)
                <label>
                    <input type="checkbox" name="mood_tags[]" value="{{ $mood }}" @checked(in_array($mood, $selectedMoods, true))>
                    {{ $mood }}
                </label>
            @endforeach
        </div>
    </div>
</div>
