
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title); ?> | StayNest</title>

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
    <a class="brand" href="<?php echo e(route('home')); ?>">StayNest</a>

    <nav>
        <a href="<?php echo e(route('home')); ?>">Home</a>
        <a href="<?php echo e(route('boys.index')); ?>">Boys PGs</a>
        <a href="<?php echo e(route('girls.index')); ?>">Girls PGs</a>
    </nav>
</header>

<section class="hero">
    <div class="container">
        <a class="back" href="<?php echo e(route('home')); ?>">← Back to homepage</a>

        <p class="eyebrow">COLLEGE-FIRST PG DISCOVERY</p>
        <h1><?php echo e($title); ?></h1>

        <p class="muted">
            Explore <?php echo e($genderType); ?> accommodation options associated with
            <?php echo e($college->name); ?>. Compare available room types and rent before
            contacting a property owner.
        </p>

        <div class="summary">
            <span>🎓 <?php echo e($college->name); ?></span>
            <span>📍 <?php echo e($college->area ?: $college->city); ?></span>
            <span>🏠 <?php echo e($pgs->count()); ?> matching listings</span>
            <span><?php echo e($genderType === 'girls' ? '👩‍🎓 Girls PGs' : '🧑‍🎓 Boys PGs'); ?></span>
        </div>
    </div>
</section>

<main class="container">
    <div class="heading">
        <div>
            <h2>Accommodation near your college</h2>
            <p class="muted">
                <?php echo e($pgs->count()); ?> matching <?php echo e($pgs->count() === 1 ? 'listing' : 'listings'); ?> found.
            </p>
        </div>

        <a href="<?php echo e(route($section . '.index')); ?>">Browse all <?php echo e($genderType); ?> PGs →</a>
    </div>

    <?php if($pgs->isEmpty()): ?>
        <div class="empty">
            <h3>No matching PGs found in the selected radius.</h3>
            <p>
                There may be no listings within 5 km of this college, or the
                demo PG coordinates may be missing or inaccurate.
            </p>
            <a class="button" style="display:inline-block"
               href="<?php echo e(route($section . '.index')); ?>">
                Browse all <?php echo e($genderType); ?> PGs
            </a>
        </div>
    <?php else: ?>
        <div class="grid">
            <?php $__currentLoopData = $pgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="card">
                    <a href="<?php echo e(route($section . '.show', ['pg' => $pg->slug])); ?>">
                        <div class="photo">
                            <?php if($pg->coverPhoto && $pg->coverPhoto->url): ?>
                                <img src="<?php echo e($pg->coverPhoto->url); ?>"
                                     alt="<?php echo e($pg->name); ?>" loading="lazy">
                            <?php else: ?>
                                <span>🏠 Photo coming soon</span>
                            <?php endif; ?>
                        </div>
                    </a>

                    <div class="content">
                        <h3><?php echo e($pg->name); ?></h3>

                        <div class="area">
                            📍 <?php echo e($pg->area ?: 'Bangalore'); ?>

                        </div>

                        <?php
                            $lowestRent = $pg->roomTypes->min('rent');
                        ?>

                        <div class="rent">
                            <?php if($lowestRent !== null): ?>
                                ₹<?php echo e(number_format($lowestRent)); ?>

                                <small>/ month onwards</small>
                            <?php else: ?>
                                <small>Rent details unavailable</small>
                            <?php endif; ?>
                        </div>

                        <div class="chips">
                            <span><?php echo e($pg->roomTypes->count()); ?> room options</span>
                            <span><?php echo e($pg->amenities->count()); ?> listed amenities</span>
                        </div>

                        <a class="button"
                           href="<?php echo e(route($section . '.show', ['pg' => $pg->slug])); ?>">
                            View PG details →
                        </a>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
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
<?php /**PATH D:\p project\staynest\resources\views/pgs/near-college.blade.php ENDPATH**/ ?>