<?php $this->layout("layouts/default", ["title" => CONGNGHE]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>
<?php $this->start("page") ?>

<!-- Phần nội dung chính -->
<main>
  <div class="container mt-1">

    <!-- Hiển thị thông báo lỗi nếu có -->
    <?php if (!empty($_SESSION['error_message'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['error_message'], ENT_QUOTES, 'UTF-8') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['error_message']);
      ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success_message'])): ?>
      <div class="alert alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['success_message'], ENT_QUOTES, 'UTF-8') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['success_message']);
      ?>
    <?php endif; ?>

    <!-- Phần carousel -->
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="img/iphone 16 pro.png" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="img/asus Zenbook pro.png" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="img/Galaxy watch.png" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="img/Turquoise Blue Photo Collage Summer Sea Vacation Facebook Cover.png" class="d-block w-100" alt="...">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <div class="row">

      <!-- Khuyến mãi -->
      <div class="container mt-4">
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
          <i class="fa-solid fa-gift fa-2x me-3"></i>
          <div>
            <h4 class="alert-heading">Khuyến mãi đặc biệt!</h4>
            <p>Giảm giá <strong>99%</strong> cho tất cả các sản phẩm trong tháng này.</p>
            <a href="#" class="btn btn-outline-success">Khám Phá Ngay</a>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>

      <!-- Thanh danh mục -->
      <div class="col-lg-3 col-12">
        <div class="m-0 bg-white">
          <h5 class="p-2 mt-1">DANH MỤC</h5>
          <div class="list-group">
            <!-- Các liên kết danh mục -->
            <a href="#laptops" class="list-group-item list-group-item-action">Laptop</a>
            <a href="#phones" class="list-group-item list-group-item-action">Điện Thoại</a>
            <a href="#tablets" class="list-group-item list-group-item-action">Máy Tính Bảng</a>
            <a href="#watches" class="list-group-item list-group-item-action">Đồng Hồ</a>
            <!-- Thêm nhiều danh mục nếu cần -->
          </div>
        </div>
      </div>
      <!-- Các phần sản phẩm -->
      <div class="col-lg-9 col-12">
        <div id="laptops" class="brand row m-1">
          <h3 class="col-6 text-center text-white mt-2">
            SẢN PHẨM NỔI BẬC
          </h3>
          <div class="col-6 text-end text-white mt-1">
            <a href="/product" class="float-end text-white text-decoration-none">Xem thêm <i class="fa-solid fa-angles-right"></i></a>
          </div>
          <div class="row ms-1">
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
                      <!-- Nút chi tiết -->
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

    </div>
</main>

    <a class="backtop position-fixed text-center rounded-circle text-muted active" href="#"> <i class="bi bi-house-door"></i></a>

<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>

<script>
  let table = new DataTable('#contacts', {
    responsive: true,
    pagingType: 'simple_numbers'
  });

  const deleteButtons = document.querySelectorAll('button[name="delete-contact"]');

  deleteButtons.forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      const form = button.closest('form');
      const nameTd = button.closest('tr').querySelector('td:first-child');
      if (nameTd) {
        document.querySelector('.modal-body').textContent =
          `Do you want to delete "${nameTd.textContent}"?`;
      }
      const submitForm = function() {
        form.submit();
      };
      document.getElementById('delete').addEventListener('click', submitForm, {
        once: true
      });
      const modalEl = document.getElementById('delete-confirm');
      modalEl.addEventListener('hidden.bs.modal', function() {
        document.getElementById('delete').removeEventListener('click', submitForm);
      });
      const confirmModal = new bootstrap.Modal(modalEl, {
        backdrop: 'static',
        keyboard: false
      });
      confirmModal.show();
    });
  });
</script>
<?php $this->stop() ?>