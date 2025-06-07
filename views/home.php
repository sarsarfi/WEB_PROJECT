<h2>محصولات فروشگاه</h2>
<div class="row">
    <?php if (!empty($products)): ?>
        <?php foreach($products as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <?php if (!empty($product->image)): ?>
                    <img src="<?= get_base_path() ?>/uploads/<?= htmlspecialchars($product->image) ?>" class="card-img-top" alt="<?= htmlspecialchars($product->name) ?>">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($product->name) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($product->description) ?></p>
                    <p class="card-text"><strong>قیمت: </strong><?= number_format($product->price) ?> تومان</p>
                    <form method="POST" action="<?= get_base_path() ?>/cart/add">
                        <input type="hidden" name="product_id" value="<?= $product->id ?>">
                        <input type="number" name="quantity" value="1" min="1" class="form-control mb-2" />
                        <button type="submit" class="btn btn-primary">افزودن به سبد خرید</button>
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
