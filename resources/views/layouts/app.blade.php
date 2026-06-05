<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'My Ultimate Food & Drink Collection')</title>
    <style>
        :root {
            --ink: #202124;
            --muted: #62646a;
            --line: #dedbd2;
            --paper: #fffdf8;
            --panel: #ffffff;
            --mint: #d6f2e5;
            --tomato: #f26b5e;
            --berry: #a3436c;
            --teal: #217c7e;
            --gold: #f5b84b;
            --shadow: 0 12px 34px rgba(31, 35, 40, .08);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            color: var(--ink);
            background: var(--paper);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            line-height: 1.5;
        }

        a { color: inherit; text-decoration: none; }

        img { display: block; max-width: 100%; }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(255, 253, 248, .92);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(14px);
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            max-width: 1160px;
            margin: 0 auto;
            padding: 14px 20px;
        }

        .brand {
            display: grid;
            gap: 0;
            font-weight: 800;
        }

        .brand span:last-child {
            color: var(--muted);
            font-size: .84rem;
            font-weight: 600;
        }

        .navlinks {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
        }

        .navlinks a,
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            padding: 9px 14px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--panel);
            color: var(--ink);
            font-weight: 700;
            cursor: pointer;
            box-shadow: none;
        }

        .button.primary {
            border-color: var(--teal);
            background: var(--teal);
            color: white;
        }

        .button.danger {
            border-color: #cf4a3f;
            background: #cf4a3f;
            color: white;
        }

        .button.soft { background: var(--mint); border-color: #b2e1cf; }

        .container {
            max-width: 1160px;
            margin: 0 auto;
            padding: 28px 20px 56px;
        }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(280px, .95fr);
            align-items: center;
            gap: 32px;
            min-height: 420px;
            padding: 26px 0 34px;
        }

        .hero h1,
        .page-title h1 {
            margin: 0;
            max-width: 760px;
            font-size: clamp(2rem, 5vw, 4.8rem);
            line-height: 1.02;
        }

        .hero p,
        .page-title p {
            max-width: 640px;
            color: var(--muted);
            font-size: 1.05rem;
        }

        .hero-visual {
            min-height: 320px;
            overflow: hidden;
            border-radius: 8px;
            background: #ece6d7;
            box-shadow: var(--shadow);
        }

        .hero-visual img {
            width: 100%;
            height: 100%;
            min-height: 320px;
            object-fit: cover;
        }

        .band {
            margin-top: 22px;
            padding: 24px 0;
            border-top: 1px solid var(--line);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
        }

        .grid.tight { grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); }

        .card,
        .panel,
        .stat,
        .form-box {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--panel);
            box-shadow: var(--shadow);
        }

        .card {
            display: grid;
            grid-template-rows: 180px 1fr;
            overflow: hidden;
        }

        .card-media {
            background: var(--mint);
            overflow: hidden;
        }

        .card-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .placeholder {
            display: grid;
            place-items: center;
            height: 100%;
            min-height: 160px;
            background: linear-gradient(135deg, #d6f2e5, #fff0c7);
            color: var(--teal);
            font-weight: 800;
        }

        .card-body,
        .panel,
        .stat,
        .form-box {
            padding: 18px;
        }

        .meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 10px 0;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
            padding: 4px 9px;
            border-radius: 999px;
            background: #f4efe4;
            color: #4e4b46;
            font-size: .82rem;
            font-weight: 800;
        }

        .pill.hot { background: #ffe0da; color: #9d2f25; }
        .pill.cool { background: #d9eff0; color: #145f61; }

        .section-head {
            display: flex;
            flex-wrap: wrap;
            align-items: end;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .section-head h2,
        .card h3,
        .panel h2,
        .stat h3 {
            margin: 0;
        }

        .muted { color: var(--muted); }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 14px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        label {
            display: grid;
            gap: 6px;
            font-weight: 800;
        }

        input,
        select,
        textarea {
            width: 100%;
            min-height: 42px;
            padding: 10px 12px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fff;
            color: var(--ink);
            font: inherit;
        }

        textarea { min-height: 140px; resize: vertical; }

        .full { grid-column: 1 / -1; }

        .checkboxes {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .checkboxes label {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            min-height: 36px;
            padding: 8px 10px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fff;
        }

        .checkboxes input { width: auto; min-height: auto; }

        .notice {
            margin-bottom: 18px;
            padding: 12px 14px;
            border: 1px solid #b8dfc9;
            border-radius: 8px;
            background: #ebfff2;
            font-weight: 700;
        }

        .errors {
            margin-bottom: 18px;
            padding: 12px 16px;
            border: 1px solid #efaaa2;
            border-radius: 8px;
            background: #fff0ee;
            color: #8e2f28;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 680px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            vertical-align: middle;
        }

        th { color: var(--muted); font-size: .84rem; }

        .pagination { margin-top: 18px; }

        @media (max-width: 820px) {
            .hero { grid-template-columns: 1fr; min-height: auto; }
            .hero h1, .page-title h1 { font-size: 2.2rem; }
            .form-grid { grid-template-columns: 1fr; }
            .nav { align-items: flex-start; flex-direction: column; }
            .navlinks { justify-content: flex-start; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <nav class="nav">
            <a class="brand" href="{{ route('dashboard') }}">
                <span>My Ultimate Food & Drink Collection</span>
                <span>Laravel Recommendation App</span>
            </a>
            <div class="navlinks" aria-label="Main navigation">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('favorites.index') }}">Collection</a>
                <a href="{{ route('favorites.mood') }}">Mood</a>
                <a href="{{ route('favorites.surprise') }}">Surprise Me</a>
                <a href="{{ route('favorites.battle') }}">Food Battle</a>
                <a class="button primary" href="{{ route('favorites.create') }}">Add Favorite</a>
            </div>
        </nav>
    </header>

    <main class="container">
        @if (session('status'))
            <div class="notice">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="errors">
                <strong>Please fix the highlighted fields.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
    <script>
        document.querySelectorAll('[data-decimal-money]').forEach((input) => {
            input.addEventListener('input', () => {
                let value = input.value.replace(/[^\d.]/g, '');
                const dotIndex = value.indexOf('.');

                if (dotIndex !== -1) {
                    value = value.slice(0, dotIndex + 1) + value.slice(dotIndex + 1).replace(/\./g, '');
                    const [whole, decimal = ''] = value.split('.');
                    value = `${whole.slice(0, 5)}.${decimal.slice(0, 2)}`;
                } else {
                    value = value.slice(0, 5);
                }

                input.value = value;
            });
        });
    </script>
</body>
</html>
