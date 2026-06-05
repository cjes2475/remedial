<?php

namespace App\Http\Controllers;

use App\Models\FavoriteItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FavoriteItemController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'total_foods' => FavoriteItem::where('category', 'Food')->count(),
            'total_drinks' => FavoriteItem::where('category', 'Drink')->count(),
            'average_rating' => round((float) FavoriteItem::avg('rating'), 1),
            'highest_rated' => FavoriteItem::orderByDesc('rating')->orderByDesc('favorite_level')->first(),
            'recent' => FavoriteItem::latest()->first(),
        ];

        return view('favorites.dashboard', [
            'stats' => $stats,
            'topTen' => FavoriteItem::orderByDesc('rating')->orderByDesc('favorite_level')->limit(10)->get(),
            'mostExpensive' => FavoriteItem::orderByDesc('price')->first(),
            'cheapest' => FavoriteItem::orderBy('price')->first(),
            'highestCalorie' => FavoriteItem::orderByDesc('calories')->first(),
            'mostRecommended' => FavoriteItem::orderByDesc('favorite_level')->orderByDesc('rating')->orderByDesc('battle_wins')->first(),
        ]);
    }

    public function index(Request $request): View
    {
        $favorites = FavoriteItem::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->string('category')))
            ->when($request->filled('rating'), fn ($query) => $query->where('rating', '>=', (float) $request->input('rating')))
            ->orderByDesc('favorite_level')
            ->orderByDesc('rating')
            ->paginate(9)
            ->withQueryString();

        return view('favorites.index', [
            'favorites' => $favorites,
            'categories' => FavoriteItem::CATEGORIES,
        ]);
    }

    public function create(): View
    {
        return view('favorites.create', [
            'favorite' => new FavoriteItem(['mood_tags' => []]),
            'categories' => FavoriteItem::CATEGORIES,
            'moods' => FavoriteItem::MOODS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $favorite = FavoriteItem::create($this->validatedData($request));

        return redirect()
            ->route('favorites.show', $favorite)
            ->with('status', "{$favorite->name} was added to your collection.");
    }

    public function show(FavoriteItem $favorite): View
    {
        $similar = FavoriteItem::where('category', $favorite->category)
            ->whereKeyNot($favorite->id)
            ->orderByDesc('rating')
            ->limit(4)
            ->get();

        return view('favorites.show', compact('favorite', 'similar'));
    }

    public function edit(FavoriteItem $favorite): View
    {
        return view('favorites.edit', [
            'favorite' => $favorite,
            'categories' => FavoriteItem::CATEGORIES,
            'moods' => FavoriteItem::MOODS,
        ]);
    }

    public function update(Request $request, FavoriteItem $favorite): RedirectResponse
    {
        $favorite->update($this->validatedData($request, $favorite));

        return redirect()
            ->route('favorites.show', $favorite)
            ->with('status', "{$favorite->name} was updated.");
    }

    public function destroy(FavoriteItem $favorite): RedirectResponse
    {
        $favoriteName = $favorite->name;
        $this->deleteUploadedImage($favorite);
        $favorite->delete();

        return redirect()
            ->route('favorites.index')
            ->with('status', "{$favoriteName} was removed from your collection.");
    }

    public function mood(Request $request): View
    {
        $selectedMood = $request->string('mood')->toString();
        $recommendations = collect();

        if ($selectedMood !== '') {
            $recommendations = FavoriteItem::where('mood_tags', 'like', '%"'.$selectedMood.'"%')
                ->orderByDesc('rating')
                ->orderByDesc('favorite_level')
                ->limit(8)
                ->get();
        }

        return view('favorites.mood', [
            'moods' => FavoriteItem::MOODS,
            'selectedMood' => $selectedMood,
            'recommendations' => $recommendations,
        ]);
    }

    public function surprise(): View
    {
        return view('favorites.surprise', [
            'favorite' => FavoriteItem::inRandomOrder()->first(),
        ]);
    }

    public function battle(Request $request): View
    {
        if ($request->filled('rounds') || $request->boolean('reset')) {
            $rounds = (int) $request->input('rounds', 3);
            $rounds = in_array($rounds, [3, 5, 10], true) ? $rounds : 3;

            $request->session()->put('food_battle', [
                'round' => 1,
                'rounds' => $rounds,
                'scores' => [],
                'finished' => false,
            ]);
        }

        if (! $request->session()->has('food_battle')) {
            $request->session()->put('food_battle', [
                'round' => 1,
                'rounds' => 3,
                'scores' => [],
                'finished' => false,
            ]);
        }

        $battle = $request->session()->get('food_battle');
        $winner = null;

        if ($battle['finished'] ?? false) {
            $winnerId = collect($battle['scores'] ?? [])
                ->sortDesc()
                ->keys()
                ->first();

            $winner = $winnerId ? FavoriteItem::find($winnerId) : null;
        }

        return view('favorites.battle', [
            'items' => ($battle['finished'] ?? false) ? collect() : FavoriteItem::inRandomOrder()->limit(2)->get(),
            'battle' => $battle,
            'winner' => $winner,
            'roundOptions' => [3, 5, 10],
        ]);
    }

    public function voteBattle(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'winner_id' => ['required', 'integer', 'exists:favorite_items,id'],
            'loser_id' => ['required', 'integer', 'exists:favorite_items,id', 'different:winner_id'],
        ]);

        FavoriteItem::whereKey($validated['winner_id'])->increment('battle_wins');
        FavoriteItem::whereKey($validated['winner_id'])->update(['last_battled_at' => now()]);
        FavoriteItem::whereKey($validated['loser_id'])->increment('battle_losses');
        FavoriteItem::whereKey($validated['loser_id'])->update(['last_battled_at' => now()]);

        $battle = $request->session()->get('food_battle', [
            'round' => 1,
            'rounds' => 3,
            'scores' => [],
            'finished' => false,
        ]);
        $winnerKey = (string) $validated['winner_id'];
        $battle['scores'][$winnerKey] = ($battle['scores'][$winnerKey] ?? 0) + 1;

        if ($battle['round'] >= $battle['rounds']) {
            $battle['finished'] = true;
            $message = 'Food Battle finished. The winner is ready.';
        } else {
            $battle['round']++;
            $message = "Battle vote saved. Round {$battle['round']} is ready.";
        }

        $request->session()->put('food_battle', $battle);

        return redirect()
            ->route('favorites.battle')
            ->with('status', $message);
    }

    public function image(string $path)
    {
        abort_if(str_contains($path, '..'), 404);
        abort_unless(Storage::disk('public')->exists($path), 404);

        return Storage::disk('public')->response($path);
    }

    private function validatedData(Request $request, ?FavoriteItem $favorite = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'category' => ['required', Rule::in(FavoriteItem::CATEGORIES)],
            'description' => ['nullable', 'string', 'max:1000'],
            'rating' => ['required', 'numeric', 'min:1', 'max:5'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999', 'regex:/^\d+(\.\d{1,2})?$/'],
            'calories' => ['nullable', 'integer', 'min:0', 'max:5000'],
            'favorite_level' => ['required', 'integer', 'min:1', 'max:10'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'reaction' => ['nullable', 'string', 'max:16'],
            'mood_tags' => ['nullable', 'array'],
            'mood_tags.*' => [Rule::in(FavoriteItem::MOODS)],
        ]);

        $validated['mood_tags'] = $validated['mood_tags'] ?? [];
        unset($validated['image']);

        if ($request->hasFile('image')) {
            if ($favorite) {
                $this->deleteUploadedImage($favorite);
            }

            $validated['image_url'] = $request->file('image')->store('favorites', 'public');
        }

        return $validated;
    }

    private function deleteUploadedImage(FavoriteItem $favorite): void
    {
        if (! $favorite->image_url || str_starts_with($favorite->image_url, 'http')) {
            return;
        }

        Storage::disk('public')->delete($favorite->image_url);
    }
}
