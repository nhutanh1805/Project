<?php $this->layout("layouts/default", ["title" => "Chi Tiết Đơn Hàng"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Chi Tiết Đơn Hàng</h2>

        <h3>Thông tin đơn hàng</h3>
        <p><strong>Mã đơn hàng:</strong> <?= $order['id'] ?></p>
        <p><strong>Trạng thái:</strong> <?= $order['status'] ?></p>
        <p><strong>Tên người nhận:</strong> <?= $order['name'] ?></p>
        <p><strong>Địa chỉ:</strong> <?= $order['address'] ?></p>
        <p><strong>Phương thức thanh toán:</strong> <?= $order['payment_method'] ?></p>
        <?php if ($order['payment_method'] == 'credit_card'): ?>
            <p><strong>Số thẻ tín dụng:</strong> <?= $order['card_number'] ?></p>
        <?php endif; ?>

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
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price'], 0, ',', '.') ?> VNĐ</td>
                        <td><?= number_format($item['total_price'], 0, ',', '.') ?> VNĐ</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h4>Tổng tiền: <?= number_format($order['total_price'], 0, ',', '.') ?> VNĐ</h4>
    </div>
</main>

<?php $this->stop() ?>
