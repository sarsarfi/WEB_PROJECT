<?php $content = ob_start(); ?>
<div class="container mt-4">
    <h2>لیست محصولات</h2>
    <div class="row">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100"> <?php if (!empty($product->image)): ?>
                        <img src="<?= get_base_path() ?>/uploads/<?= htmlspecialchars($product->image) ?>" class="card-img-top" alt="<?= htmlspecialchars($product->name) ?>">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column"> <h5 class="card-title"><?= htmlspecialchars($product->name) ?></h5>
                            <p class="card-text flex-grow-1"><?= htmlspecialchars(substr($product->description, 0, 100)) ?><?php if (strlen($product->description) > 100) echo '...'; ?></p>
                            <p class="card-text"><strong>قیمت: <?= number_format($product->price) ?> تومان</strong></p>
                            <form action="<?= get_base_path() ?>/cart/add" method="POST" class="mt-auto">
                                <input type="hidden" name="product_id" value="<?= $product->id ?>">
                                <div class="input-group mb-3">
                                    <input type="number" name="quantity" class="form-control" value="1" min="1" <?php if (isset($product->stock) && $product->stock > 0): ?>max="<?= $product->stock ?>"<?php endif; ?>>
                                    <button class="btn btn-primary" type="submit" <?php if (isset($product->stock) && $product->stock <= 0): ?>disabled<?php endif; ?>>
                                        <?php if (isset($product->stock) && $product->stock <= 0): ?>ناموجود<?php else: ?>افزودن به سبد<?php endif; ?>
                                    </button>
                                </div>
                            </form>
                            <a href="<?= get_base_path() ?>/product/<?= $product->id ?>" class="btn btn-info btn-sm mt-2">جزئیات</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>محصولی برای نمایش وجود ندارد.</p>
        <?php endif; ?>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php include ROOT_PATH . '/views/layout.php'; ?>
