<?php $this->layout("layouts/default", ["title" => "Tìm kiếm - " . CONGNGHE]) ?>

<?php $this->start("page") ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Kết quả tìm kiếm</h1>

    <!-- Hiển thị kết quả tìm kiếm -->
    <?php if (!empty($results)): ?>
        <div class="row">
            <?php foreach ($results as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?= $product['image_url'] ?? '/img/default_product.jpg' ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                            <p class="card-text text-danger"><?= number_format($product['price'], 0, ',', '.') ?> VND</p>
                            <a href="/product/<?= $product['id']; ?>" class="btn btn-success">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif (isset($_GET['query'])): ?>
        <p class="text-center">Không tìm thấy sản phẩm nào phù hợp với từ khóa "<?php echo htmlspecialchars($_GET['query']); ?>".</p>
    <?php endif; ?>
</div>

<?php $this->stop() ?>
