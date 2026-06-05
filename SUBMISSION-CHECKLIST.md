# Submission Checklist

- [ ] Run `composer install`
- [ ] Run `copy .env.example .env`
- [ ] Run `php artisan key:generate`
- [ ] Run `php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"`
- [ ] Run `php artisan migrate:fresh --seed`
- [ ] Run `php artisan test`
- [ ] Run `php artisan serve`
- [ ] Screenshot the `favorite_items` database table
- [ ] Screenshot Factory and Seeder output
- [ ] Screenshot the running dashboard
- [ ] Record a short explanation of the system
- [ ] Push to GitHub
- [ ] Deploy to Render or Vercel
- [ ] Send the GitHub and live website links via PM
