<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فروشگاه من</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        /* Add some custom styles here if needed */
        .navbar-brand, .nav-link { font-weight: bold; }
        .card-img-top { height: 200px; object-fit: cover; } /* برای تصاویر محصولات */
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= get_base_path() ?>/">فروشگاه من</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="navbar-nav">
                    <a class="nav-link" href="<?= get_base_path() ?>/products">محصولات</a>
                    <a class="nav-link" href="<?= get_base_path() ?>/cart">سبد خرید</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <span class="nav-link text-white">سلام، <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                        <a class="nav-link" href="<?= get_base_path() ?>/logout">خروج</a>
                    <?php else: ?>
                        <a class="nav-link" href="<?= get_base_path() ?>/login">ورود</a>
                        <a class="nav-link" href="<?= get_base_path() ?>/register">ثبت‌نام</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if (!empty($session_error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($session_error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($session_success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($session_success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?= $content ?? '' ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>