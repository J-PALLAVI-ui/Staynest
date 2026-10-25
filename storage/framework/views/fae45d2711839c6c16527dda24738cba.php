
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(ucfirst($genderType)); ?> PGs | StayNest</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #172033;
            background: #f5f7fb;
        }

        a { text-decoration: none; color: #2563eb; }

        header {
            padding: 18px 7%;
            background: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            box-shadow: 0 2px 10px #0000000b;
        }

        header h2 { color: #2563eb; margin: 0; }
        header nav { display: flex; flex-wrap: wrap; gap: 16px; }

        .hero {
            padding: 42px 7%;
            background: linear-gradient(120deg, #eaf2ff, #f4edff);
        }

        .hero h1 { margin: 0 0 10px; font-size: clamp(28px, 4vw, 40px); }
        .hero p { color: #64748b; margin-bottom: 0; }

        .container {
            max-width: 1200px;
            margin: 28px auto;
            padding: 0 20px;
        }

        .filters {
            background: white;
            padding: 18px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            box-shadow: 0 3px 14px #00000008;
        }

        input, select, button {
            padding: 12px;
            border: 1px solid #dbe2ee;
            border-radius: 8px;
            font-size: 14px;
        }

        input, select { background: white; }

        button {
            background: #2563eb;
            color: white;
            border: 0;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover { background: #1d4ed8; }

        .reset {
            padding: 10px;
            font-weight: bold;
        }

        .results-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 18px;
        }

        .results-heading h2 { margin: 0; }
        .muted { color: #64748b; }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 22px;
        }

        .card {
            display: block;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 18px #0000000a;
            color: inherit;
            transition: transform .18s, box-shadow .18s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 28px #00000012;
        }

        .photo-wrap {
            height: 205px;
            background: #e2e8f0;
            position: relative;
        }

        .photo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .demo-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #fff7ed;
            color: #9a3412;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .card-body { padding: 19px; }
        .card h3 { margin: 0 0 8px; font-size: 20px; }
        .area { color: #64748b; margin: 0 0 14px; }

        .rent {
            font-size: 23px;
            font-weight: bold;
            color: #2563eb;
            margin: 10px 0;
        }

        .rent small {
            font-size: 13px;
            font-weight: normal;
            color: #64748b;
        }

        .tags { display: flex; flex-wrap: wrap; gap: 7px; margin: 12px 0; }

        .tag {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            padding: 6px 9px;
            border-radius: 20px;
            font-size: 12px;
        }

        .description {
            font-size: 14px;
            line-height: 1.5;
            color: #475569;
        }

        .card-footer {
            border-top: 1px solid #edf0f5;
            padding: 14px 19px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #2563eb;
            font-weight: bold;
            font-size: 14px;
        }

        .empty {
            padding: 35px;
            background: white;
            border-radius: 12px;
            text-align: center;
        }

        footer {
            text-align: center;
            padding: 28px;
            color: #64748b;
        }

        @media (max-width: 600px) {
            header { padding: 18px 5%; }
            .hero { padding: 32px 5%; }
            .container { padding: 0 14px; }
            .filters > input, .filters > select, .filters > button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
<header>
    <h2>StayNest</h2>
    <nav>
        <a href="<?php echo e(url('/')); ?>">Home</a>
        <a href="<?php echo e(url('/boys')); ?>">Boys PGs</a>
        <a href="<?php echo e(url('/girls')); ?>">Girls PGs</a>
        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(url('/dashboard')); ?>">Dashboard</a>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>">Login</a>
        <?php endif; ?>
    </nav>
</header>

<section class="hero">
    <h1><?php echo e(ucfirst($genderType)); ?> PG Accommodation</h1>
    <p>Compare rooms, rent, facilities and nearby colleges before choosing your stay.</p>
</section>

<main class="container">
    <form class="filters" method="GET" action="<?php echo e(url('/' . $section)); ?>">
        <input type="number" name="min_price" min="0"
               placeholder="Minimum rent (₹)"
               value="<?php echo e(request('min_price')); ?>">

        <input type="number" name="max_price" min="0"
               placeholder="Maximum rent (₹)"
               value="<?php echo e(request('max_price')); ?>">

        <select name="sharing">
            <option value="">All room-sharing types</option>
            <?php $__currentLoopData = [1, 2, 3, 4]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($count); ?>"
                    <?php if((string) request('sharing') === (string) $count): echo 'selected'; endif; ?>>
                    <?php echo e($count); ?>-sharing
                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select name="area">
            <option value="">All areas</option>
            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($area); ?>"
                    <?php if(request('area') === $area): echo 'selected'; endif; ?>>
                    <?php echo e($area); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <button type="submit">Search PGs</button>
        <a class="reset" href="<?php echo e(url('/' . $section)); ?>">Reset</a>
    </form>

    <div class="results-heading">
        <div>
            <h2>Available <?php echo e(ucfirst($genderType)); ?> PGs</h2>
            <p class="muted"><?php echo e($pgs->total()); ?> accommodation(s) found</p>
        </div>
    </div>

    <?php if($pgs->count()): ?>
        <div class="cards">
            <?php $__currentLoopData = $pgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="card"
                   href="<?php echo e(route($section . '.show', ['pg' => $pg->slug])); ?>"
                   aria-label="View details for <?php echo e($pg->name); ?>">

                    <div class="photo-wrap">
                        <?php if($pg->coverPhoto): ?>
                            <img
                                src="<?php echo e($pg->coverPhoto->url); ?>"
                                alt="<?php echo e($pg->coverPhoto->alt_text ?: $pg->name); ?>"
                                loading="lazy"
                                onerror="this.style.display='none'">
                        <?php else: ?>
                            <img
                                src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=900&q=75"
                                alt="Sample accommodation interior"
                                loading="lazy">
                        <?php endif; ?>

                        <span class="demo-badge">
                            <?php echo e($pg->verified ? 'Verified' : 'Demo listing'); ?>

                        </span>
                    </div>

                    <div class="card-body">
                        <h3><?php echo e($pg->name); ?></h3>
                        <p class="area">📍 <?php echo e($pg->area ?? 'Bangalore'); ?>, <?php echo e($pg->city ?? 'Bangalore'); ?></p>

                        <?php
                            $lowestRent = $pg->roomTypes->min('rent');
                        ?>

                        <?php if($lowestRent !== null): ?>
                            <p class="rent">
                                ₹<?php echo e(number_format($lowestRent)); ?>

                                <small>/ month onwards</small>
                            </p>
                        <?php endif; ?>

                        <div class="tags">
                            <?php $__currentLoopData = $pg->roomTypes->sortBy('sharing'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="tag">
                                    <?php echo e($room->sharing); ?>-sharing
                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <p class="description">
                            <?php echo e(\Illuminate\Support\Str::limit(
                                $pg->description ?: 'Explore room options, facilities and accommodation details.',
                                125
                            )); ?>

                        </p>

                        <p class="muted" style="font-size:13px">
                            <?php echo e($pg->roomTypes->sum('beds_free')); ?> sample available beds ·
                            <?php echo e($pg->amenities->count()); ?> listed amenities
                        </p>
                    </div>

                    <div class="card-footer">
                        <span>View property details</span>
                        <span aria-hidden="true">→</span>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div style="margin-top:28px">
            <?php echo e($pgs->links()); ?>

        </div>
    <?php else: ?>
        <div class="empty">
            <h3>No PGs found</h3>
            <p>Try a different budget, area or room-sharing option.</p>
            <a href="<?php echo e(url('/' . $section)); ?>">Clear all filters</a>
        </div>
    <?php endif; ?>
</main>

<footer>
    StayNest — Find a place to call home.
    <p style="font-size:12px">
        Demo listing information, prices, availability and images may not represent actual properties.
    </p>
</footer>
</body>
</html>
<?php /**PATH D:\p project\staynest\resources\views/pgs/index.blade.php ENDPATH**/ ?>