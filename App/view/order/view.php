<!-- File: src/Views/order/view.php -->
<h1>Chi tiết đơn hàng #<?= $orderDetails[0]['id'] ?></h1>
<table>
    <thead>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Tổng tiền</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orderDetails as $item): ?>
        <tr>
            <td><?= $item['name'] ?></td>
            <td><?= number_format($item['price'], 0, ',', '.') ?> VNĐ</td>
            <td><?= $item['quantity'] ?></td>
            <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VNĐ</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p>Địa chỉ giao hàng: <?= $orderDetails[0]['address'] ?></p>
<p>Tổng tiền: <?= number_format($orderDetails[0]['total_amount'], 0, ',', '.') ?> VNĐ</p>
<p>Ngày tạo: <?= $orderDetails[0]['created_at'] ?></p>
