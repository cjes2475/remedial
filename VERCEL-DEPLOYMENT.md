# Vercel Deployment

This Laravel project includes:

- `api/index.php` as the Vercel PHP function entrypoint
- `vercel.json` using the community PHP runtime
- `.vercelignore` so Vercel installs dependencies during build

## Important Database Note

Vercel cannot connect to Railway's private MySQL host. Do not use:

```env
DB_HOST=${{MySQL.RAILWAY_PRIVATE_DOMAIN}}
```

Use a public database host instead. If you keep Railway MySQL, enable/use the MySQL TCP Proxy and copy the public proxy domain and port.

## Vercel Environment Variables

Set these in Vercel Project Settings > Environment Variables:

```env
APP_NAME=My Ultimate Food & Drink Collection
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:PASTE_APP_KEY_HERE
APP_URL=https://YOUR_VERCEL_DOMAIN.vercel.app

LOG_CHANNEL=stderr
CACHE_STORE=array
SESSION_DRIVER=cookie
QUEUE_CONNECTION=sync
MAIL_MAILER=log

DB_CONNECTION=mysql
DB_HOST=YOUR_PUBLIC_MYSQL_HOST
DB_PORT=YOUR_PUBLIC_MYSQL_PORT
DB_DATABASE=YOUR_MYSQL_DATABASE
DB_USERNAME=YOUR_MYSQL_USERNAME
DB_PASSWORD=YOUR_MYSQL_PASSWORD
```

For Railway MySQL public TCP proxy, use:

```env
DB_HOST=RAILWAY_TCP_PROXY_DOMAIN
DB_PORT=RAILWAY_TCP_PROXY_PORT
```

Use the real values from the MySQL service. Do not use the private Railway domain on Vercel.

## Deploy Steps

1. Push the project to GitHub.
2. In Vercel, import the GitHub repository.
3. Framework preset: Other.
4. Add the environment variables above.
5. Deploy.

## Migrations

Vercel does not run Laravel migrations automatically on every request. Run migrations from your local machine against the same public database connection:

```bash
php artisan migrate --force
php artisan db:seed --force
```

Before running those commands locally, set `.env` to the same public database values used in Vercel.
