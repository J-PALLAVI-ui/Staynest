
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | StayNest</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #172342;
            background: #f6f8fc;
        }

        header {
            background: white;
            border-bottom: 1px solid #e5e9f2;
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .brand {
            color: #315bea;
            font-size: 26px;
            font-weight: 800;
            text-decoration: none;
        }

        nav { display: flex; gap: 18px; flex-wrap: wrap; }

        nav a, .back {
            color: #43516a;
            text-decoration: none;
            font-size: 14px;
        }

        .container { width: min(1120px, 92%); margin: auto; }

        .hero {
            padding: 45px 0;
            background: linear-gradient(120deg, #e9efff, #f8faff);
        }

        .eyebrow {
            color: #315bea;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        h1 { font-size: clamp(29px, 4vw, 42px); margin: 12px 0; }

        .muted { color: #69758b; line-height: 1.7; }

        .summary {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 22px;
        }

        .summary span {
            background: white;
            border: 1px solid #e2e8f4;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 13px;
        }

        main { padding: 35px 0 60px; }

        .heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .heading h2 { margin: 0 0 8px; }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            border: 1px solid #e3e8f1;
            border-radius: 16px;
            overflow: hidden;
            transition: .2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px #17234212;
        }

        .photo {
            height: 190px;
            background: linear-gradient(135deg, #e6ecff, #f4f6fb);
            display: grid;
            place-items: center;
            color: #69758b;
            font-size: 14px;
        }

        .photo img { width: 100%; height: 100%; object-fit: cover; }

        .content { padding: 18px; }

        .content h3 { margin: 0 0 9px; font-size: 19px; }

        .area { font-size: 13px; color: #69758b; }

        .rent { margin: 18px 0 6px; font-size: 23px; font-weight: bold; }

        .rent small { font-size: 12px; color: #69758b; font-weight: normal; }

        .chips { display: flex; flex-wrap: wrap; gap: 7px; margin: 13px 0; }

        .chips span {
            padding: 7px 9px;
            background: #f0f3f9;
            border-radius: 7px;
            font-size: 11px;
            color: #48546a;
        }

        .button {
            display: block;
            margin-top: 15px;
            padding: 12px;
            border-radius: 9px;
            text-align: center;
            color: white;
            background: #315bea;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .empty {
            padding: 28px;
            border: 1px dashed #cbd4e5;
            border-radius: 14px;
            background: white;
            color: #69758b;
            line-height: 1.8;
        }

        footer { background: #172342; color: white; padding: 25px 5%; }

        @media (max-width: 850px) {
            .grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 560px) {
            header { align-items: flex-start; flex-direction: column; }
            .grid { grid-template-columns: 1fr; }
            .heading { align-items: flex-start; flex-direction: column; }
        }
    </style>
</head>

<body>
<header>
    <a class="brand" href="{{ route('home') }}">StayNest</a>

    <nav>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('boys.index') }}">Boys PGs</a>
        <a href="{{ route('girls.index') }}">Girls PGs</a>
    </nav>
</header>

<section class="hero">
    <div class="container">
        <a class="back" href="{{ route('home') }}">← Back to homepage</a>

        <p class="eyebrow">COLLEGE-FIRST PG DISCOVERY</p>
        <h1>{{ $title }}</h1>

        <p class="muted">
            Explore {{ $genderType }} accommodation options associated with
            {{ $college->name }}. Compare available room types and rent before
            contacting a property owner.
        </p>

        <div class="summary">
            <span>🎓 {{ $college->name }}</span>
            <span>📍 {{ $college->area ?: $college->city }}</span>
            <span>🏠 {{ $pgs->count() }} matching listings</span>
            <span>{{ $genderType === 'girls' ? '👩‍🎓 Girls PGs' : '🧑‍🎓 Boys PGs' }}</span>
        </div>
    </div>
</section>

<main class="container">
    <div class="heading">
        <div>
            <h2>Accommodation near your college</h2>
            <p class="muted">
                {{ $pgs->count() }} matching {{ $pgs->count() === 1 ? 'listing' : 'listings' }} found.
            </p>
        </div>

        <a href="{{ route($section . '.index') }}">Browse all {{ $genderType }} PGs →</a>
    </div>

    @if ($pgs->isEmpty())
        <div class="empty">
            <h3>No matching PGs found in the selected radius.</h3>
            <p>
                There may be no listings within 5 km of this college, or the
                demo PG coordinates may be missing or inaccurate.
            </p>
            <a class="button" style="display:inline-block"
               href="{{ route($section . '.index') }}">
                Browse all {{ $genderType }} PGs
            </a>
        </div>
    @else
        <div class="grid">
            @foreach ($pgs as $pg)
                <article class="card">
                    <a href="{{ route($section . '.show', ['pg' => $pg->slug]) }}">
                        <div class="photo">
                            @if ($pg->coverPhoto && $pg->coverPhoto->url)
                                <img src="{{ $pg->coverPhoto->url }}"
                                     alt="{{ $pg->name }}" loading="lazy">
                            @else
                                <span>🏠 Photo coming soon</span>
                            @endif
                        </div>
                    </a>

                    <div class="content">
                        <h3>{{ $pg->name }}</h3>

                        <div class="area">
                            📍 {{ $pg->area ?: 'Bangalore' }}
                        </div>

                        @php
                            $lowestRent = $pg->roomTypes->min('rent');
                        @endphp

                        <div class="rent">
                            @if ($lowestRent !== null)
                                ₹{{ number_format($lowestRent) }}
                                <small>/ month onwards</small>
                            @else
                                <small>Rent details unavailable</small>
                            @endif
                        </div>

                        <div class="chips">
                            <span>{{ $pg->roomTypes->count() }} room options</span>
                            <span>{{ $pg->amenities->count() }} listed amenities</span>
                        </div>

                        <a class="button"
                           href="{{ route($section . '.show', ['pg' => $pg->slug]) }}">
                            View PG details →
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</main>

<footer>
    <div class="container">
        <strong>StayNest</strong>
        <p>Helping students explore accommodation options in Bangalore.</p>
        <small>Demo listings may contain unverified sample information.</small>
    </div>
</footer>
</body>
</html>
