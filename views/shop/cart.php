<?php $content = ob_start(); ?>

<h1 class="mb-4">سبد خرید شما</h1>

<?php if (empty($cartItems)): // نام متغیر اصلاح شد ?>
    <div class="alert alert-info">سبد خرید شما خالی است.</div>
<?php else: ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>نام محصول</th>
                <th>تعداد</th>
                <th>قیمت واحد</th>
                <th>جمع جزء</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item): // نام متغیر اصلاح شد ?>
                <tr>
                    <td><?= htmlspecialchars($item['product']->name) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($item['product']->price) ?> تومان</td>
                    <td><?= number_format($item['subtotal']) ?> تومان</td>
                    <td>
                        <form action="<?= get_base_path() ?>/cart/remove" method="POST" onsubmit="return confirm('آیا از حذف این محصول اطمینان دارید؟');">
                            <input type="hidden" name="product_id" value="<?= $item['product']->id ?>">
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h4>جمع کل: <?= number_format($totalPrice) ?> تومان</h4>

    <a href="<?= get_base_path() ?>/checkout" class="btn btn-success mt-3 me-2">نهایی کردن خرید</a>
<?php endif; ?>

<a href="<?= get_base_path() ?>/products" class="btn btn-secondary mt-3">بازگشت به محصولات</a>

<?php $content = ob_get_clean(); ?>
<?php include ROOT_PATH . '/views/layout.php'; ?>
