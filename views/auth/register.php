<?php $content = ob_start(); ?>
<div class="container mt-5">
    <h2>ثبت‌ نام کاربر جدید</h2>

    <form action="<?= get_base_path() ?>/register" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">نام و نام خانوادگی</label>
            <input type="text" name="name" id="name" class="form-control" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">ایمیل</label>
            <input type="email" name="email" id="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">رمز عبور</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">ثبت‌نام</button>
    </form>

    <p class="mt-3">قبلا ثبت‌نام کرده‌اید؟ <a href="<?= get_base_path() ?>/login">وارد شوید</a></p>
</div>
<?php $content = ob_get_clean(); ?>
<?php include ROOT_PATH . '/views/layout.php'; ?>
