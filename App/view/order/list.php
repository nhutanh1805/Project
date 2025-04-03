<!-- File: src/Views/order/list.php -->
<h1>Danh sách đơn hàng</h1>
<table>
    <thead>
        <tr>
            <th>Mã đơn hàng</th>
            <th>Địa chỉ</th>
            <th>Tổng tiền</th>
            <th>Ngày tạo</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order['id'] ?></td>
            <td><?= $order['address'] ?></td>
            <td><?= number_format($order['total_amount'], 0, ',', '.') ?> VNĐ</td>
            <td><?= $order['created_at'] ?></td>
            <td><?= $order['status'] ?? 'Chưa xác nhận' ?></td>
            <td>
                <a href="/order/view/<?= $order['id'] ?>">Xem</a> |
                <a href="/order/confirm/<?= $order['id'] ?>">Xác nhận</a> |
                <a href="/order/cancel/<?= $order['id'] ?>">Hủy</a> |
                <a href="/order/delete/<?= $order['id'] ?>">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
