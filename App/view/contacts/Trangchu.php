<?php $this->layout("layouts/default", ["title" => CONGNGHE]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<style>
  /* Animation cho phần danh mục */
  .category-list {
    transition: all 0.5s ease-in-out;
  }

  .category-toggle {
    cursor: pointer;
    transition: all 0.3s;
  }

  .category-toggle:hover {
    color: #007bff;
  }

  /* Hiệu ứng ẩn/hiện */
  .category-collapse {
    display: none;
  }

  .category-collapse.show {
    display: block;
  }

  /* Phần tin tức nổi bật */
  #newsList {
    margin-top: 10px;
  }

  .list-group-item h6 a {
    font-size: 1rem;
    font-weight: 600;
  }

  .list-group-item p {
    font-size: 0.875rem;
    color: #6c757d;
  }
</style>
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
      <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success_message'])): ?>
      <div class="alert alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['success_message'], ENT_QUOTES, 'UTF-8') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['success_message']); ?>
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

      <!-- Thanh danh mục (được di chuyển sang bên phải) -->
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

      <!-- Thanh danh mục chuyển sang bên phải và có thể toggle -->
      <div class="col-lg-3 col-12">
        <div class="m-0 bg-white">
          <h5 class="p-2 mt-1 category-toggle" data-bs-toggle="collapse" data-bs-target="#categoryList">DANH MỤC <i class="fa-solid fa-caret-down"></i></h5>
          <div id="categoryList" class="category-list category-collapse">
            <div class="list-group">
              <a href="#laptops" class="list-group-item list-group-item-action">Laptop</a>
              <a href="#phones" class="list-group-item list-group-item-action">Điện Thoại</a>
              <a href="#tablets" class="list-group-item list-group-item-action">Máy Tính Bảng</a>
              <a href="#watches" class="list-group-item list-group-item-action">Đồng Hồ</a>
            </div>
          </div>
        </div>

        <!-- Phần Tin Tức Nổi Bật -->
        <div class="m-0 bg-light mt-4 p-3">
          <h5 class="category-toggle" data-bs-toggle="collapse" data-bs-target="#newsList">TIN TỨC NỔI BẬT <i class="fa-solid fa-caret-down"></i></h5>
          <div id="newsList" class="category-list category-collapse">
            <ul class="list-group">
              <li class="list-group-item">
                <h6><a href="#" class="text-decoration-none">Tin tức 1: Giảm giá lớn tháng này</a></h6>
                <p class="text-muted">Đọc ngay các chương trình khuyến mãi đặc biệt cho tháng này.</p>
              </li>
              <li class="list-group-item">
                <h6><a href="#" class="text-decoration-none">Tin tức 2: Sản phẩm mới ra mắt</a></h6>
                <p class="text-muted">Khám phá các sản phẩm công nghệ mới nhất.</p>
              </li>
              <li class="list-group-item">
                <h6><a href="#" class="text-decoration-none">Tin tức 3: Tính năng mới cho sản phẩm</a></h6>
                <p class="text-muted">Đọc về những cải tiến mới trong sản phẩm của chúng tôi.</p>
              </li>
            </ul>
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
  // Mã JavaScript để toggle (ẩn/hiện) phần danh mục
  const categoryToggle = document.querySelector('.category-toggle');
  const categoryList = document.querySelector('#categoryList');

  categoryToggle.addEventListener('click', function() {
    categoryList.classList.toggle('show');
    const icon = categoryToggle.querySelector('i');
    icon.classList.toggle('fa-caret-up');
    icon.classList.toggle('fa-caret-down');
  });
</script>
<?php $this->stop() ?>
