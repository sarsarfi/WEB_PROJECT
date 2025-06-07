<?php $content = ob_start(); ?>
<div class="container mt-5">
    <h2>ورود</h2>
    <form action="<?= get_base_path() ?>/login" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">ایمیل:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">رمز عبور:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">ورود</button>
    </form>
    <p class="mt-3">حساب کاربری ندارید؟ <a href="<?= get_base_path() ?>/register">ثبت‌نام کنید</a></p>
</div>
<?php $content = ob_get_clean(); ?>

<?php include ROOT_PATH . '/views/layout.php'; ?>
