<!-- views/user/order/list.php -->

<h1>Danh sách đơn hàng của bạn</h1>

<table border="1">
    <thead>
        <tr>
            <th>ID Đơn Hàng</th>
            <th>Tổng Tiền</th>
            <th>Trạng Thái</th>
            <th>Ngày Tạo</th>
            <th>Hành Động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= htmlspecialchars($order['id']) ?></td>
            <td><?= number_format($order['total_price'], 2) ?> VND</td>
            <td>
                <?php
                    switch ($order['status']) {
                        case 0: echo 'Đang chờ xử lý'; break;
                        case 1: echo 'Đang giao hàng'; break;
                        case 2: echo 'Đã hoàn thành'; break;
                        default: echo 'Không xác định';
                    }
                ?>
            </td>
            <td><?= htmlspecialchars($order['created_at']) ?></td>
            <td>
                <a href="/order/confirm/<?= $order['id'] ?>">Xem chi tiết</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
