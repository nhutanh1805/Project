<?php $this->layout("layouts/default", ["title" => "Đơn Hàng Của Bạn"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Đơn Hàng Của Bạn</h2>

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
                        <th>Tiến Trình</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr id="order_<?= $order['id'] ?>">
                            <td><?= htmlspecialchars($order['id'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <?php
                                // Hiển thị tổng tiền với định dạng VNĐ
                                $totalAmount = $order['total_amount'] ?? 0;
                                echo number_format($totalAmount, 0, ',', '.') . ' VNĐ';
                                ?>
                            </td>
                            <td id="status_<?= $order['id'] ?>">
                                <?php
                                // Hiển thị trạng thái đơn hàng
                                switch ($order['status']) {
                                    case 'Processing':
                                        echo '<span class="badge bg-warning">Đơn hàng đang được xử lý</span>';
                                        break;
                                    case 'Shipped':
                                        echo '<span class="badge bg-primary">Đơn hàng đang được giao</span>';
                                        break;
                                    case 'Delivered':
                                        echo '<span class="badge bg-success">Đơn hàng đã giao</span>';
                                        break;
                                    case 'Cancelled':
                                        echo '<span class="badge bg-danger">Đơn hàng đã hủy</span>';
                                        break;
                                    default:
                                        echo '<span class="badge bg-secondary">Trạng thái chưa xác định</span>';
                                        break;
                                }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($order['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
                            
                            <!-- Thanh tiến trình với Icon -->
                            <td>
                                <?php 
                                // Xác định tiến trình của đơn hàng và icon đi kèm
                                $progress = 0;
                                $icon = '';
                                switch ($order['status']) {
                                    case 'Processing':
                                        $progress = 33; 
                                        $icon = '<i class="fas fa-cogs"></i> Đang xử lý';
                                        break;
                                    case 'Shipped':
                                        $progress = 66;
                                        $icon = '<i class="fas fa-truck" style="font-size: 24px; color: #0d6efd;"></i> Đang giao hàng'; // Icon xe tải ở đây
                                        break;
                                    case 'Delivered':
                                        $progress = 100;
                                        $icon = '<i class="fas fa-check-circle"></i> Đã giao';
                                        break;
                                    case 'Cancelled':
                                        $progress = 0;
                                        $icon = '<i class="fas fa-times-circle"></i> Đã hủy';
                                        break;
                                    default:
                                        $progress = 0;
                                        $icon = '<i class="fas fa-question-circle"></i> Chưa xác định';
                                        break;
                                }
                                ?>

                                <!-- Progress Bar -->
                                <div class="d-flex align-items-center">
                                    <!-- Icon nằm ngoài thanh tiến trình -->
                                    <div class="me-3"><?= $icon ?></div>

                                    <!-- Thanh tiến trình -->
                                    <div class="progress" style="flex-grow: 1;">
                                        <div class="progress-bar" role="progressbar" style="width: <?= $progress ?>%" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <a href="/order/view/<?= $order['id'] ?>" class="btn btn-info">Chi tiết</a>

                         <!-- Hiển thị trường nhập bình luận nếu trạng thái là "Delivered" -->
<?php if ($order['status'] == 'Delivered'): ?>
    <form action="/order/comment/<?= $order['id'] ?>" method="post">
        <div class="mb-3">
            <label for="comment" class="form-label">Bình luận của bạn</label>
            <textarea name="comment" id="comment" class="form-control" rows="3" placeholder="Nhập bình luận về đơn hàng của bạn..."></textarea>
        </div>
        <!-- Liên kết trực tiếp tới trang cmt.php -->
        <a href="cmt.php" class="btn btn-primary">Gửi bình luận</a>
    </form>
<?php endif; ?>


                                <!-- Xóa đơn hàng ở mọi trạng thái -->
                                <!-- <a href="/order/delete/<?= $order['id'] ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">Xóa</a> -->

                                <!-- Cập nhật trạng thái đơn hàng, chỉ cho phép hủy đơn nếu trạng thái là 'Processing' -->
                                <?php if ($order['status'] == 'Processing'): ?>
                                    <form action="/order/updateStatus/<?= $order['id'] ?>" method="post" class="status-form" style="display:inline;">
                                        <label for="status_<?= $order['id'] ?>" class="form-label">Trạng thái:</label>
                                        <select name="status" id="status_select_<?= $order['id'] ?>" class="form-select" onchange="this.form.submit()">
                                            <option value="Cancelled" <?= $order['status'] == 'Cancelled' ? 'selected' : '' ?>>Hủy đơn?</option>
                                            <option value="Cancelled" <?= $order['status'] == 'Cancelled' ? 'selected' : '' ?>>Xác nhận hủy</option>
                                        </select>
                                    </form>
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
