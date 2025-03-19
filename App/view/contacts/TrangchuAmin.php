<?php $this->layout("layouts/default", ["title" => CONGNGHE]) ?>
<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>

<!-- Phần nội dung chính -->
<main>

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

    <div class="container">
        <div class="text-center">
            <h2>Chọn Mục</h2>
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
                <li class="nav-item">
              <a class="nav-link" href="/contacts/create/"><i class=""></i>THÊM SẢN PHẨM</a>
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
                                    <div class="row mx-1">

                                        <form class="col-6" action="<?= '/contacts/delete/' . $this->e($contact->id) ?>" method="POST">
                                            <button type="submit" class="btn btn-secondary" name="delete-contact">
                                                <i alt="Delete" class="fa fa-trash"></i> Xóa sản phẩm
                                            </button>
                                        </form>
                                        <a href="<?= '/contacts/edit/' . $this->e($contact->id) ?>" class="btn btn-primary col-6 "><i alt="Edit" class="fa fa-pencil"></i> Chỉnh sửa</a>
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
            <a class="backtop position-fixed text-center rounded-circle text-muted active" href="#"> <i class="bi bi-house-door"></i></a>
</main>
<!-- Phần chân trang -->

<?php $this->stop() ?>

