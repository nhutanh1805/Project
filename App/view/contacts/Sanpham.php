<?php $this->layout("layouts/default", ["title" => CONGNGHE]) ?>
<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>

<!-- Phần nội dung chính -->
<main>
  <div class="container">
    <div class="text-center">
      <h2 style="color:  rgb(3, 41, 119);" class="font-weight-bold">SẢN PHẨM</h2>
      <ul class="nav nav-tabs" id="categoryTabs">
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#category1">Laptop</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#category2">Điện thoại</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#category3">Máy tính bảng</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#category4">Đồng hồ</a>
        </li>
      </ul>
    </div>
    <!-- PHẦN LAPTOP -->
    <div class="col-12">
      <div id="laptops" class="brand row m-1">
        <div class="row ms-1 mt-3">
          <?php foreach ($contacts as $contact): ?>
            <div class="col-lg-4 col-sm-6 mb-3">
              <div class="card">
                <img src="<?= htmlspecialchars($contact->img) ?>" alt=" của <?= htmlspecialchars($contact->name) ?>">
                <div class="card-body">
                  <div class="d-flex justify-content-center gap-2 mb-3">
                    <span class="badge bg-secondary text-decoration-line-through"><?= number_format(html_escape($contact->priceGoc), 0, ',', '.'); ?> VNĐ</span>
                    <span class="badge bg-danger"><?= number_format(html_escape($contact->price), 0, ',', '.'); ?> VNĐ</span>
                  </div>
                  <h5 class="card-title"><?= html_escape($contact->name) ?></h5>
                  <p class="card-text"><?= html_escape($contact->description) ?></p>
                </div>
                <div class="card-footer">
                  <div class="mt-1 text-center">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#productModal-<?= $contact->id ?>">
                      <i class="bi bi-info-circle"></i> Chi tiết
                    </button>
                    <a href="/cart/add/<?= $contact->id ?>/<?= urlencode($contact->name) ?>" class="btn btn-primary">
                      <i class="bi bi-bag-plus-fill"></i> Mua Hàng
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal thông tin chi tiết sản phẩm -->
            <div class="modal fade" id="productModal-<?= $contact->id ?>" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Thông Tin Sản Phẩm: <?= htmlspecialchars($contact->name) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li><strong>CPU:</strong> <?= htmlspecialchars($contact->cpu) ?></li>
                      <li><strong>RAM:</strong> <?= htmlspecialchars($contact->ram) ?></li>
                      <li><strong>Bộ nhớ:</strong> <?= htmlspecialchars($contact->storage) ?></li>
                      <li><strong>Dung lượng PIN:</strong> <?= htmlspecialchars($contact->battery_capacity) ?></li>
                      <li><strong>CAMERA:</strong> <?= htmlspecialchars($contact->camera_resolution) ?></li>
                      <li><strong>Màn hình:</strong> <?= htmlspecialchars($contact->screen_size) ?> inch</li>
                      <li><strong>Hệ điều hành:</strong> <?= htmlspecialchars($contact->os) ?></li>
                      <li><strong>Chất liệu dây đeo:</strong> <?= htmlspecialchars($contact->strap_material) ?></li>
                      <li><strong>Chống nước:</strong> <?= htmlspecialchars($contact->water_resistance) ?></li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        <li class="page-item disabled">
          <a class="page-link">Previous</a>
        </li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#">Next</a>
        </li>
      </ul>
    </nav>
    <!-- Nút Back to Top -->
    <button id="backToTopBtn" class="btn btn-primary" style="display: none; position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
      <i class="bi bi-arrow-up"></i> Lên trên
    </button>
    <a class="backtop position-fixed text-center rounded-circle text-muted active" href="#"> <i class="bi bi-house-door"></i></a>
</main>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<script>
  let table = new DataTable('#contacts', {
    responsive: true,
    pagingType: 'simple_numbers'
  });
</script>
<?php $this->stop() ?>