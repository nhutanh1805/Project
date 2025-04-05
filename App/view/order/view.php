<?php $this->layout("layouts/default", ["title" => "Chi Tiết Đơn Hàng"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Chi Tiết Đơn Hàng</h2>

        <?php if (isset($orderItems) && !empty($orderItems)): ?>
            <!-- Thông tin đơn hàng -->
            <h3>Thông tin đơn hàng</h3>
            <p><strong>Mã đơn hàng:</strong> <?= htmlspecialchars($orderItems[0]['order_id']) ?></p>
            <p><strong>Trạng thái:</strong> <?= htmlspecialchars($orderItems[0]['status']) ?></p>
            <p><strong>Tên người mua:</strong> <?= htmlspecialchars($orderItems[0]['user_name']) ?></p>
            <p><strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($orderItems[0]['address']) ?></p>

            <!-- Danh sách sản phẩm -->
            <h3>Danh Sách Sản Phẩm</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderItems as $item): ?>
                        <tr>
                            <td>
                                <img src="<?= htmlspecialchars($item['product_img']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" width="50" height="50">
                                <?= htmlspecialchars($item['product_name']) ?>
                            </td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['price'], 0, ',', '.') ?> VNĐ</td>
                            <td><?= number_format($item['total_price'], 0, ',', '.') ?> VNĐ</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Tổng tiền của đơn hàng -->
            <h4>Tổng tiền: <?= number_format($orderItems[0]['total_amount'], 0, ',', '.') ?> VNĐ</h4>

        <?php else: ?>
            <p>Không có thông tin chi tiết đơn hàng.</p>
        <?php endif; ?>
    </div>
</main>

<?php $this->stop() ?>
