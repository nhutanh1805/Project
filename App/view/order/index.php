<?php $this->layout("layouts/default", ["title" => "Đơn Hàng"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Danh Sách Đơn Hàng</h2>

        <?php if (empty($orders)): ?>
            <p class="text-center">Bạn chưa có đơn hàng nào. Hãy thử mua sắm ngay!</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Đơn Hàng</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Ngày Tạo</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['id'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <?php
                                $totalAmount = $order['total_amount'] ?? 0; // Kiểm tra nếu 'total_amount' không tồn tại
                                echo number_format($totalAmount, 0, ',', '.') . ' VNĐ';
                                ?>
                            </td>
                            <td>
                                <?php
                                // Hiển thị trạng thái của đơn hàng (nếu có)
                                echo htmlspecialchars($order['status'] ?? 'Chưa xác định', ENT_QUOTES, 'UTF-8');
                                ?>
                            </td>
                            <td><?= htmlspecialchars($order['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <a href="/order/view/<?= $order['id'] ?>" class="btn btn-info">Chi tiết</a>
                                <!-- Nếu trạng thái là 'Processing', có thể cập nhật trạng thái hoặc hủy đơn hàng -->
                                <?php if ($order['status'] == 'Processing'): ?>
                                    <a href="/order/updateStatus/<?= $order['id'] ?>" class="btn btn-warning">Cập nhật trạng thái</a>
                                    <a href="/order/cancel/<?= $order['id'] ?>" class="btn btn-danger">Hủy đơn</a>
                                <?php elseif ($order['status'] == 'Shipped' || $order['status'] == 'Delivered'): ?>
                                    <span class="badge bg-success">Đã giao hàng</span>
                                <?php elseif ($order['status'] == 'Cancelled'): ?>
                                    <span class="badge bg-danger">Đã hủy</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>
<?php $this->stop() ?>
