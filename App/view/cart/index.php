<?php $this->layout("layouts/default", ["title" => "Giỏ Hàng"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Giỏ Hàng</h2>

        <?php if (empty($cart)): ?>
            <p class="text-center">Giỏ hàng của bạn đang trống.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $productId => $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>
                                <!-- Form cập nhật số lượng -->
                                <form action="/cart/update/<?= $productId ?>" method="POST">
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" required>
                                    <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                                </form>
                            </td>
                            <td><?= number_format($item['price'], 0, ',', '.') ?> VNĐ</td>
                            <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VNĐ</td>
                            <td>
                                <!-- Form xóa sản phẩm -->
                                <form action="/cart/remove/<?= $productId ?>" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');">
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Tổng tiền:</strong></td>
                        <td><strong><?= number_format($total, 0, ',', '.') ?> VNĐ</strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <!-- Link đến trang thanh toán -->
            <a href="/checkout" class="btn btn-success">Thanh toán</a>
        <?php endif; ?>
    </div>
</main>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<?php $this->stop() ?>
