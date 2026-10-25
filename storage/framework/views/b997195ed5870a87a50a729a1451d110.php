
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayNest | Find a PG Near Your College</title>

    <style>
        :root {
            --blue: #315bea;
            --blue-dark: #203fc1;
            --navy: #172342;
            --muted: #68748b;
            --bg: #f6f8fc;
            --white: #ffffff;
            --border: #e6eaf2;
            --rose: #df527e;
            --green: #13845e;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            background: var(--bg);
            color: var(--navy);
        }

        a { color: inherit; text-decoration: none; }

        .container {
            width: min(1160px, 92%);
            margin: auto;
        }

        header {
            background: white;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .nav {
            min-height: 76px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand {
            font-size: 27px;
            font-weight: 850;
            letter-spacing: -1px;
            color: var(--blue);
        }

        .brand span { color: var(--navy); }

        .navlinks {
            display: flex;
            align-items: center;
            gap: 23px;
            color: #4e5a70;
            font-size: 14px;
        }

        .navlinks a:hover { color: var(--blue); }

        .nav-button, .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 18px;
            border: 0;
            border-radius: 11px;
            background: var(--blue);
            color: white;
            font-weight: 700;
            cursor: pointer;
            font-size: 14px;
        }

        .button:hover, .nav-button:hover {
            background: var(--blue-dark);
        }

        .hero {
            padding: 68px 0 56px;
            background:
                radial-gradient(ellipse at 90% 0%, #dbe5ff 0%, transparent 38%),
                linear-gradient(135deg, #edf2ff, #f9fbff 68%, #fdf1f5);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            align-items: center;
            gap: 40px;
        }

        .eyebrow {
            display: inline-block;
            color: var(--blue);
            background: #e3eaff;
            padding: 8px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .5px;
        }

        h1 {
            font-size: clamp(36px, 5vw, 57px);
            line-height: 1.09;
            letter-spacing: -2px;
            margin: 20px 0;
        }

        h1 span { color: var(--blue); }

        .hero-copy {
            color: var(--muted);
            line-height: 1.8;
            font-size: 17px;
            max-width: 570px;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 25px;
        }

        .button.secondary {
            background: white;
            color: var(--navy);
            border: 1px solid var(--border);
        }

        .hero-panel {
            background: white;
            border: 1px solid #e6eafa;
            border-radius: 24px;
            padding: 27px;
            box-shadow: 0 24px 65px #233e8015;
        }

        .hero-panel h2 { margin: 0 0 8px; font-size: 23px; }
        .subtext { color: var(--muted); font-size: 14px; line-height: 1.6; }

        .mini-feature {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 15px 0;
            border-bottom: 1px solid var(--border);
        }

        .mini-feature:last-child { border-bottom: 0; }

        .mini-icon {
            display: grid;
            place-items: center;
            width: 43px;
            height: 43px;
            border-radius: 13px;
            background: #edf1ff;
            font-size: 21px;
            flex-shrink: 0;
        }

        .mini-feature strong { display: block; margin-bottom: 4px; }
        .mini-feature small { color: var(--muted); line-height: 1.5; }

        .section { padding: 47px 0; }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 20px;
            margin-bottom: 23px;
        }

        .section-heading h2 {
            font-size: clamp(24px, 3vw, 31px);
            margin: 0 0 8px;
            letter-spacing: -.8px;
        }

        .section-heading p {
            color: var(--muted);
            margin: 0;
            line-height: 1.6;
        }

        .college-box {
            background: white;
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 27px;
            box-shadow: 0 10px 35px #20345e08;
        }

        .college-form {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 13px;
            margin-top: 20px;
        }

        label {
            display: block;
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 8px;
        }

        select, input {
            width: 100%;
            padding: 14px;
            border: 1px solid #dbe1ee;
            border-radius: 11px;
            background: white;
            color: var(--navy);
            font-size: 14px;
            outline-color: var(--blue);
        }

        .college-note {
            margin-top: 14px;
            font-size: 12px;
            color: var(--muted);
            line-height: 1.6;
        }

        .recommend-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
            margin-top: 23px;
        }

        .recommend-card {
            padding: 23px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 20px;
        }

        .recommend-top {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
            margin-bottom: 12px;
        }

        .recommend-top h3 { margin: 0; font-size: 20px; }

        .gender-icon {
            display: grid;
            place-items: center;
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: #eaf0ff;
            font-size: 23px;
        }

        .girls .gender-icon { background: #ffedf3; }

        .recommend-card p {
            color: var(--muted);
            line-height: 1.6;
            font-size: 14px;
        }

        .recommend-card .button { width: 100%; margin-top: 10px; }

        .tag {
            display: inline-block;
            background: #edf8f3;
            color: var(--green);
            font-size: 11px;
            padding: 6px 9px;
            border-radius: 20px;
            font-weight: 800;
        }

        .girls .tag { background: #fff0f5; color: #bf3e69; }

        .pg-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .pg-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            transition: transform .18s, box-shadow .18s;
        }

        .pg-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px #1a2b5012;
        }

        .pg-photo {
            height: 185px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #e4eaff, #f3f5fb);
            color: #6979a2;
            font-size: 14px;
            overflow: hidden;
        }

        .pg-photo img { width: 100%; height: 100%; object-fit: cover; }

        .pg-content { padding: 19px; }

        .pg-content h3 { margin: 0 0 9px; font-size: 18px; }

        .pg-area { color: var(--muted); font-size: 13px; }

        .rent {
            font-size: 23px;
            font-weight: 850;
            margin: 17px 0 5px;
        }

        .rent small {
            color: var(--muted);
            font-weight: 400;
            font-size: 12px;
        }

        .pg-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin: 14px 0;
        }

        .pg-meta span {
            font-size: 11px;
            background: #f1f4f9;
            padding: 7px 9px;
            border-radius: 7px;
            color: #4e5a70;
        }

        .details-link {
            display: block;
            border-top: 1px solid var(--border);
            padding-top: 14px;
            margin-top: 13px;
            color: var(--blue);
            font-weight: 750;
            font-size: 13px;
        }

        .empty {
            background: white;
            border: 1px dashed #cbd4e5;
            border-radius: 15px;
            padding: 25px;
            color: var(--muted);
            line-height: 1.7;
        }

        .how-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .how-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px;
        }

        .how-card .number {
            display: grid;
            place-items: center;
            width: 37px;
            height: 37px;
            border-radius: 12px;
            background: #e9eeff;
            color: var(--blue);
            font-weight: 850;
        }

        .how-card h3 { font-size: 17px; }
        .how-card p { color: var(--muted); line-height: 1.7; font-size: 14px; }

        footer {
            background: #172342;
            color: #dbe3f4;
            padding: 32px 0;
            margin-top: 25px;
        }

        footer p { color: #aebbd4; font-size: 13px; line-height: 1.7; }

        @media (max-width: 800px) {
            .hero-grid { grid-template-columns: 1fr; }
            .hero { padding: 45px 0; }
            .pg-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .navlinks { gap: 12px; }
            .recommend-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 540px) {
            .nav { padding: 14px 0; align-items: flex-start; }
            .navlinks { flex-wrap: wrap; justify-content: flex-end; font-size: 12px; }
            .brand { font-size: 23px; }
            .college-form { grid-template-columns: 1fr; }
            .pg-grid, .how-grid { grid-template-columns: 1fr; }
            .section { padding: 32px 0; }
            .hero-panel, .college-box { padding: 20px; }
            h1 { letter-spacing: -1px; }
        }
    </style>
</head>

<body>
<header>
    <div class="container nav">
        <a class="brand" href="<?php echo e(route('home')); ?>">Stay<span>Nest</span></a>

        <nav class="navlinks">
            <a href="<?php echo e(route('home')); ?>">Home</a>
            <a href="<?php echo e(route('boys.index')); ?>">Boys PGs</a>
            <a href="<?php echo e(route('girls.index')); ?>">Girls PGs</a>
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(url('/dashboard')); ?>">Dashboard</a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main>
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow">YOUR COLLEGE. YOUR NEIGHBOURHOOD. YOUR HOME.</span>

                <h1>College life starts with finding the <span>right place.</span></h1>

                <p class="hero-copy">
                    Find a paying guest accommodation in Bangalore that fits your
                    college, budget and lifestyle. Start with your university and
                    explore available boys' and girls' PGs.
                </p>

                <div class="hero-actions">
                    <a class="button" href="#college-finder">Find PGs near my college</a>
                    <a class="button secondary" href="#featured">Explore all PGs</a>
                </div>
            </div>

            <div class="hero-panel">
                <h2>Make your college commute easier</h2>
                <p class="subtext">
                    Start your search with the place where you study.
                </p>

                <div class="mini-feature">
                    <div class="mini-icon">🎓</div>
                    <div>
                        <strong>Choose your college</strong>
                        <small>Search using your university or campus.</small>
                    </div>
                </div>

                <div class="mini-feature">
                    <div class="mini-icon">📍</div>
                    <div>
                        <strong>Explore nearby accommodation</strong>
                        <small>Use available location information to compare PGs.</small>
                    </div>
                </div>

                <div class="mini-feature">
                    <div class="mini-icon">🏠</div>
                    <div>
                        <strong>Choose boys' or girls' PGs</strong>
                        <small>Browse the accommodation category you need.</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="college-finder">
        <div class="container">
            <div class="section-heading">
                <div>
                    <h2>Where do you study?</h2>
                    <p>Choose your college to explore accommodation in that area.</p>
                </div>
            </div>

            <div class="college-box">
                <label for="college-select">Select your college or campus</label>

                <select id="college-select">
                    <option value="">Choose your college</option>

                    <?php $__currentLoopData = $colleges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $college): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($college->slug); ?>">
                            <?php echo e($college->name); ?>

                            <?php if($college->area): ?>
                                — <?php echo e($college->area); ?>

                            <?php endif; ?>
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <div class="college-note">
                    Select your campus carefully. For universities with multiple
                    campuses, choose the campus you attend.
                </div>

                <div class="recommend-grid">
                    <div class="recommend-card">
                        <div class="recommend-top">
                            <h3>Boys PGs</h3>
                            <div class="gender-icon">🧑‍🎓</div>
                        </div>

                        <span class="tag">BOYS ACCOMMODATION</span>

                        <p>
                            Explore boys' PG listings near your selected college.
                            Compare rent, room options and available details.
                        </p>

                        <a class="button" id="boys-college-link"
                           href="<?php echo e(route('boys.index')); ?>">
                            Find Boys PGs
                        </a>
                    </div>

                    <div class="recommend-card girls">
                        <div class="recommend-top">
                            <h3>Girls PGs</h3>
                            <div class="gender-icon">👩‍🎓</div>
                        </div>

                        <span class="tag">GIRLS ACCOMMODATION</span>

                        <p>
                            Explore girls' PG listings near your selected college.
                            Browse accommodation separately for easier comparison.
                        </p>

                        <a class="button" id="girls-college-link"
                           href="<?php echo e(route('girls.index')); ?>">
                            Find Girls PGs
                        </a>
                    </div>
                </div>

                <p class="college-note">
                    Recommendations depend on the college and PG location data
                    available in StayNest. Distance and availability are not
                    guaranteed for unverified demo listings.
                </p>
            </div>
        </div>
    </section>

    <section class="section" id="featured">
        <div class="container">
            <div class="section-heading">
                <div>
                    <h2>Featured Boys PGs</h2>
                    <p>Explore our current boys' accommodation listings.</p>
                </div>
                <a href="<?php echo e(route('boys.index')); ?>">View all →</a>
            </div>

            <div class="pg-grid">
                <?php $__empty_1 = true; $__currentLoopData = $boysPgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="pg-card">
                        <a href="<?php echo e(route('boys.show', ['pg' => $pg->slug])); ?>">
                            <div class="pg-photo">
                                <?php if($pg->coverPhoto && $pg->coverPhoto->url): ?>
                                    <img src="<?php echo e($pg->coverPhoto->url); ?>"
                                         alt="<?php echo e($pg->name); ?>"
                                         loading="lazy">
                                <?php else: ?>
                                    <span>🏠 PG photo coming soon</span>
                                <?php endif; ?>
                            </div>
                        </a>

                        <div class="pg-content">
                            <h3>
                                <a href="<?php echo e(route('boys.show', ['pg' => $pg->slug])); ?>">
                                    <?php echo e($pg->name); ?>

                                </a>
                            </h3>

                            <div class="pg-area">
                                📍 <?php echo e($pg->area ?? 'Bangalore'); ?>

                            </div>

                            <?php
                                $lowestRent = $pg->roomTypes->min('rent');
                            ?>

                            <div class="rent">
                                <?php if($lowestRent !== null): ?>
                                    ₹<?php echo e(number_format($lowestRent)); ?>

                                    <small>/ month, starting</small>
                                <?php else: ?>
                                    Rent on enquiry
                                <?php endif; ?>
                            </div>

                            <div class="pg-meta">
                                <span><?php echo e($pg->roomTypes->count()); ?> room options</span>
                                <span><?php echo e($pg->amenities->count()); ?> listed amenities</span>
                            </div>

                            <a class="details-link"
                               href="<?php echo e(route('boys.show', ['pg' => $pg->slug])); ?>">
                                View PG details →
                            </a>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="empty">No boys' PG listings are currently available.</div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="section" style="background:#fff4f7">
        <div class="container">
            <div class="section-heading">
                <div>
                    <h2>Featured Girls PGs</h2>
                    <p>Browse our current girls' accommodation listings.</p>
                </div>
                <a href="<?php echo e(route('girls.index')); ?>">View all →</a>
            </div>

            <div class="pg-grid">
                <?php $__empty_1 = true; $__currentLoopData = $girlsPgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="pg-card">
                        <a href="<?php echo e(route('girls.show', ['pg' => $pg->slug])); ?>">
                            <div class="pg-photo">
                                <?php if($pg->coverPhoto && $pg->coverPhoto->url): ?>
                                    <img src="<?php echo e($pg->coverPhoto->url); ?>"
                                         alt="<?php echo e($pg->name); ?>"
                                         loading="lazy">
                                <?php else: ?>
                                    <span>🏠 PG photo coming soon</span>
                                <?php endif; ?>
                            </div>
                        </a>

                        <div class="pg-content">
                            <h3>
                                <a href="<?php echo e(route('girls.show', ['pg' => $pg->slug])); ?>">
                                    <?php echo e($pg->name); ?>

                                </a>
                            </h3>

                            <div class="pg-area">
                                📍 <?php echo e($pg->area ?? 'Bangalore'); ?>

                            </div>

                            <?php
                                $lowestRent = $pg->roomTypes->min('rent');
                            ?>

                            <div class="rent">
                                <?php if($lowestRent !== null): ?>
                                    ₹<?php echo e(number_format($lowestRent)); ?>

                                    <small>/ month, starting</small>
                                <?php else: ?>
                                    Rent on enquiry
                                <?php endif; ?>
                            </div>

                            <div class="pg-meta">
                                <span><?php echo e($pg->roomTypes->count()); ?> room options</span>
                                <span><?php echo e($pg->amenities->count()); ?> listed amenities</span>
                            </div>

                            <a class="details-link"
                               href="<?php echo e(route('girls.show', ['pg' => $pg->slug])); ?>">
                                View PG details →
                            </a>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="empty">No girls' PG listings are currently available.</div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-heading">
                <div>
                    <h2>How StayNest works</h2>
                    <p>A simpler way to begin your accommodation search.</p>
                </div>
            </div>

            <div class="how-grid">
                <div class="how-card">
                    <div class="number">1</div>
                    <h3>Choose your college</h3>
                    <p>Select your university and campus from the available college list.</p>
                </div>

                <div class="how-card">
                    <div class="number">2</div>
                    <h3>Explore your options</h3>
                    <p>Open boys' or girls' listings and compare rent, rooms and facilities.</p>
                </div>

                <div class="how-card">
                    <div class="number">3</div>
                    <h3>Check the details</h3>
                    <p>Review the listing information before contacting the accommodation owner.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<footer>
    <div class="container">
        <a class="brand" href="<?php echo e(route('home')); ?>" style="color:white">
            Stay<span style="color:#aebfff">Nest</span>
        </a>
        <p>
            Find a place to call home. StayNest helps students explore
            paying guest accommodation in Bangalore.
        </p>
        <p>Demo listings may contain sample information that has not been verified.</p>
    </div>
</footer>

<script>
    const collegeSelect = document.getElementById('college-select');
    const boysLink = document.getElementById('boys-college-link');
    const girlsLink = document.getElementById('girls-college-link');

    collegeSelect.addEventListener('change', function () {
        const slug = this.value;

        if (!slug) {
            boysLink.href = <?php echo json_encode(route('boys.index'), 15, 512) ?>;
            girlsLink.href = <?php echo json_encode(route('girls.index'), 15, 512) ?>;
            boysLink.textContent = 'Find Boys PGs';
            girlsLink.textContent = 'Find Girls PGs';
            return;
        }

        const baseUrl = <?php echo json_encode(url('/'), 15, 512) ?>;

        boysLink.href = baseUrl + '/boys/near/' + encodeURIComponent(slug);
        girlsLink.href = baseUrl + '/girls/near/' + encodeURIComponent(slug);

        boysLink.textContent = 'Find Boys PGs near this college';
        girlsLink.textContent = 'Find Girls PGs near this college';
    });
</script>
</body>
</html>
<?php /**PATH D:\p project\staynest\resources\views/home.blade.php ENDPATH**/ ?>