<?php $this->layout("layouts/default", ["title" => "Chi Tiết Đơn Hàng"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Đơn hàng #<?= htmlspecialchars($order[0]['id']) ?></h2>

        <p class="text-center">Địa chỉ giao hàng: <?= htmlspecialchars($order[0]['address']) ?></p>
        <p class="text-center">Trạng thái: <?= htmlspecialchars($order[0]['status']) ?></p>

        <h3>Chi tiết sản phẩm:</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <!-- <th>Ảnh</th> -->
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $totalAmount = 0; // Khởi tạo biến để tính tổng tiền
                ?>
                <?php if (isset($orderItems) && !empty($orderItems)): ?>
                    <?php foreach ($orderItems as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['product_name'], ENT_QUOTES, 'UTF-8') ?></td>
                            <!-- <td>
                                <?php 
                                    // Kiểm tra nếu hình ảnh hợp lệ, nếu không thì gán một ảnh mặc định
                                    $productImage = !empty($item['product_img']) ? $item['product_img'] : '/images/default-image.jpg'; 
                                    
                                    // Kiểm tra đường dẫn hình ảnh tuyệt đối
                                    if (strpos($productImage, 'http') === false) {
                                        // Nếu không phải đường dẫn đầy đủ (không chứa http), thêm đường dẫn gốc
                                        $productImage = '/path/to/your/images' . $productImage; // Thay đổi /path/to/your/images thành đường dẫn thực tế
                                    }
                                ?>
                                <img src="<?= htmlspecialchars($productImage, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($item['product_name'], ENT_QUOTES, 'UTF-8') ?>" style="max-width:150px;">
                            </td> -->
                            <td><?= htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                            <td><?= number_format($item['quantity'] * $item['price'], 0, ',', '.') ?> VND</td>
                        </tr>
                        <?php 
                            // Cộng tổng tiền của từng sản phẩm vào tổng đơn hàng
                            $totalAmount += $item['quantity'] * $item['price']; 
                        ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Không có sản phẩm nào trong đơn hàng này.</td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="3" class="text-right"><strong>Tổng tiền:</strong></td>
                    <td><strong><?= number_format($totalAmount, 0, ',', '.') ?> VND</strong></td>
                </tr>
            </tbody>
        </table>

    </div>
</main>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<?php $this->stop() ?>
