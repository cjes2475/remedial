# My Ultimate Food & Drink Collection

A Laravel remedial activity system that works like a mini food and drink recommendation app. Users can browse favorite foods and drinks, rate them, categorize them, add new entries, manage the collection, get craving-based recommendations, use a random generator, and vote in food battles.

## Requirements Covered

- Migration: `database/migrations/2026_06_04_000000_create_favorite_items_table.php`
- Model: `app/Models/FavoriteItem.php`
- Controller: `app/Http/Controllers/FavoriteItemController.php`
- Factory: `database/factories/FavoriteItemFactory.php`
- Seeder: `database/seeders/DatabaseSeeder.php`
- Seed data: 30 records total, including Matcha Latte, Sisig, Ramen, Coffee, and Mango Graham Shake
- Dynamic ranking: Top 10, most expensive, cheapest, highest calorie, and most recommended
- CRUD: add, edit, delete, view details
- Add form fields: name, category, description, rating, price, calories, favorite level, image URL, reaction, mood tags
- Extra twists: Mood Recommendation, Random Food Generator, Food Battle, Favorites Dashboard, Search and Filter
- Responsive custom CSS UI

## Setup

```bash
cd C:\Users\VINCE\Desktop\remedial
composer install
copy .env.example .env
php artisan key:generate
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate:fresh --seed
php artisan serve
```

Open:

```text
http://127.0.0.1:8000
```

## Useful Commands

```bash
php artisan migrate:fresh --seed
php artisan test
php artisan route:list
```

## Pages

- Dashboard: `/`
- Collection CRUD: `/favorites`
- Add Favorite: `/favorites/create`
- Mood Recommendation: `/mood`
- Random Food Generator: `/surprise-me`
- Food Battle: `/food-battle`
- JSON Top 10 API: `/api/favorites/top-10`

## Database Table

Main table: `favorite_items`

Important columns:

- `name`
- `category`
- `description`
- `rating`
- `calories`
- `price`
- `favorite_level`
- `image_url`
- `mood_tags`
- `reaction`
- `battle_wins`
- `battle_losses`

## GitHub Submission

```bash
git init
git add .
git commit -m "Build Laravel food and drink recommendation app"
git branch -M main
git remote add origin YOUR_GITHUB_REPOSITORY_URL
git push -u origin main
```

GitHub repository link:

```text
PASTE_YOUR_GITHUB_LINK_HERE
```

## Render Deployment Notes

Create a new Render Web Service from your GitHub repository.

Build command:

```bash
composer install --no-dev --optimize-autoloader && php artisan key:generate --force && php artisan migrate --force --seed
```

Start command:

```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

Live deployed website link:

```text
PASTE_YOUR_LIVE_LINK_HERE
```

## Required Screenshots And Recording

Take these after running `php artisan migrate:fresh --seed` and `php artisan serve`:

- Screenshot of `favorite_items` database table
- Screenshot of Factory and Seeder output
- Screenshot of the running dashboard
- Screenshot of CRUD pages or add favorite form
- Screen recording explaining dashboard, CRUD, mood recommendation, surprise generator, and food battle

## Deadline

June 5, 2026 at 11:59 PM.
