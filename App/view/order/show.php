<?php $this->layout("layouts/default", ["title" => "Chi Tiết Đơn Hàng"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Chi Tiết Đơn Hàng</h2>

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
                <?php foreach ($orderDetails as $detail): ?>
                    <tr>
                        <td><?= htmlspecialchars($detail['name']) ?></td>
                        <td><?= $detail['quantity'] ?></td>
                        <td><?= number_format($detail['price'], 0, ',', '.') ?> VNĐ</td>
                        <td><?= number_format($detail['total_price'], 0, ',', '.') ?> VNĐ</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <form action="/order/<?= $orderId ?>/update-status" method="post">
            <div class="form-group">
                <label for="status">Cập nhật trạng thái</label>
                <select class="form-control" id="status" name="status">
                    <option value="processing">Đang xử lý</option>
                    <option value="shipped">Đã giao</option>
                    <option value="canceled">Hủy</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
        </form>
    </div>
</main>
<?php $this->stop() ?>
