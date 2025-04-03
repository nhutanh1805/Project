<?php $this->layout("layouts/default", ["title" => "Kho Hàng"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Danh Sách Sản Phẩm Trong Kho</h2>

        <?php if (empty($inventory)): ?>
            <p class="text-center">
                Kho hàng của bạn đang trống. <span class="font-weight-bold text-danger">Hãy thêm sản phẩm vào kho</span> để bắt đầu bán hàng!
                <br>
                <a href="/product" class="btn btn-lg btn-warning mt-3 px-4 py-2 text-white shadow-sm hover-shadow-lg">Quản lý sản phẩm</a>
            </p>
        <?php else: ?>
            <table class="table" id="inventoryTable">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Ảnh</th>
                        <th>Số lượng trong kho</th>
                        <th>Giá</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventory as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($item['img'] ?? '', ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($item['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" style="max-width:150px;">
                            </td>
                            <td>
                                <form action="/inventory/update/<?= htmlspecialchars($item['product_id'] ?? '', ENT_QUOTES, 'UTF-8') ?>" method="POST">
                                    <input type="number" name="quantity_in_stock" value="<?= htmlspecialchars($item['quantity_in_stock'] ?? '', ENT_QUOTES, 'UTF-8') ?>" min="0" required>
                                    <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                                </form>
                            </td>
                            <td><?= number_format($item['price'], 0, ',', '.') ?> VNĐ</td>
                            <td>
                                <form action="/inventory/remove/<?= htmlspecialchars($item['product_id'] ?? '', ENT_QUOTES, 'UTF-8') ?>" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa sản phẩm này khỏi kho?');">
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#inventoryTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [10, 25, 50, 100],
            "language": {
                "search": "Tìm kiếm:",
                "lengthMenu": "Hiển thị _MENU_ mục",
                "info": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                "infoEmpty": "Không có dữ liệu",
                "infoFiltered": "(Lọc từ _MAX_ mục)",
                "paginate": {
                    "previous": "Trước",
                    "next": "Tiếp"
                }
            }
        });
    });
</script>
<?php $this->stop() ?>
