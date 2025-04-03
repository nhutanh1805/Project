<?php $this->layout("layouts/default", ["title" => "Danh Sách Đơn Hàng"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Danh Sách Đơn Hàng</h2>

        <table class="table">
            <thead>
                <tr>
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
                        <td><?= htmlspecialchars($order['address']) ?></td>
                        <td><?= number_format($order['total_amount'], 0, ',', '.') ?> VNĐ</td>
                        <td><?= $order['created_at'] ?></td>
                        <td><?= $order['status'] ?></td>
                        <td>
                            <a href="/order/<?= $order['id'] ?>" class="btn btn-info">Chi tiết</a>
                            <form action="/order/<?= $order['id'] ?>/delete" method="post" style="display:inline-block;">
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<?php $this->stop() ?>
