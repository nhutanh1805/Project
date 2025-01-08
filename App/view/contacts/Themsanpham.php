<?php $this->layout("layouts/default", ["title" => CONGNGHE]) ?>
<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<style>
    /* Style cho form container */
    .form-container {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Title */
    .form-container h2 {
        font-family: 'Arial', sans-serif;
        font-size: 2rem;
        color: #333;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .form-container .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .form-container .invalid-feedback {
        font-size: 0.875rem;
        color: #e74a3b;
    }

    .form-container button {
        background-color: #007bff;
        border: none;
        padding: 10px 20px;
        font-size: 1.125rem;
        border-radius: 5px;
        color: white;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .form-container button:hover {
        background-color: #0056b3;
    }

    .form-container .form-control {
        font-size: 1rem;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px; /* Khoảng cách giữa các ô input */
    }

    /* Chia form thành 2 phần */
    .row {
        display: flex;
        flex-wrap: wrap;
    }

    /* Phần thông tin cơ bản */
    .basic-info {
        flex: 1 1 100%;  /* chiếm toàn bộ chiều rộng */
        margin-bottom: 20px;
    }

    /* Phần chi tiết sản phẩm */
    .product-details {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Khoảng cách giữa các cột trong phần chi tiết */
    }

    .product-details > div {
        flex: 1 1 48%;  /* Mỗi cột chiếm 48% chiều rộng */
    }

    /* Gạch ngang phân tách */
    .separator {
        border-top: 2px solid #ccc;
        margin: 20px 0;
    }

    /* Media query cho màn hình nhỏ */
    @media (max-width: 768px) {
        .container {
            max-width: 90%;
        }

        /* Chi tiết sản phẩm chuyển thành 1 cột trên thiết bị di động */
        .product-details > div {
            flex: 1 1 100%;  /* Chiếm toàn bộ chiều rộng khi màn hình nhỏ */
        }
    }
</style>
<?php $this->stop() ?>

<?php $this->start("page") ?>

<div class="container text-center mt-5 form-container">
    <form action="/contacts" method="POST" class="row g-3 w-75 m-auto" enctype="multipart/form-data">
        <h2 class="text-center animate__animated animate__bounce">THÊM SẢN PHẨM MỚI</h2>

        <!-- Thông tin cơ bản (1 cột) -->
        <div class="basic-info">
            <!-- Tên sản phẩm -->
            <div class="col-md-12 col-sm-12">
                <input type="text" name="name" class="form-control<?= isset($errors['name']) ? ' is-invalid' : '' ?>" maxlength="255" id="name" placeholder="Tên sản phẩm" value="<?= isset($old['name']) ? $this->e($old['name']) : '' ?>" />
                <?php if (isset($errors['name'])) : ?>
                    <span class="invalid-feedback">
                        <strong><?= $this->e($errors['name']) ?></strong>
                    </span>
                <?php endif ?>
            </div>

            <!-- Hình ảnh sản phẩm -->
            <div class="col-md-12 col-sm-12">
                <input type="file" name="img" class="form-control<?= isset($errors['img']) ? ' is-invalid' : '' ?>" id="img" value="<?= isset($old['img']) ? $this->e($old['img']) : '' ?>" />
                <?php if (isset($errors['img'])) : ?>
                    <span class="invalid-feedback">
                        <strong><?= $this->e($errors['img']) ?></strong>
                    </span>
                <?php endif ?>
            </div>

            <!-- Mô tả sản phẩm -->
            <div class="col-md-12 col-sm-12">
                <input type="text" name="description" class="form-control<?= isset($errors['description']) ? ' is-invalid' : '' ?>" maxlength="255" id="description" placeholder="Mô tả của sản phẩm" value="<?= isset($old['description']) ? $this->e($old['description']) : '' ?>" />
                <?php if (isset($errors['description'])) : ?>
                    <span class="invalid-feedback">
                        <strong><?= $this->e($errors['description']) ?></strong>
                    </span>
                <?php endif ?>
            </div>

             <!-- Giá góc sản phẩm -->
             <div class="col-md-12 col-sm-12">
                <input type="text" name="priceGoc" class="form-control<?= isset($errors['priceGoc']) ? ' is-invalid' : '' ?>" maxlength="255" id="price" placeholder="Nhập Giá ban đầu của sản phẩm" value="<?= isset($old['priceGoc']) ? $this->e($old['priceGoc']) : '' ?>" />
                <?php if (isset($errors['priceGoc'])) : ?>
                    <span class="invalid-feedback">
                        <strong><?= $this->e($errors['price']) ?></strong>
                    </span>
                <?php endif ?>
            </div>

            <!-- Giá sản phẩm -->
            <div class="col-md-12 col-sm-12">
                <input type="text" name="price" class="form-control<?= isset($errors['price']) ? ' is-invalid' : '' ?>" maxlength="255" id="price" placeholder="Nhập Giá của sản phẩm" value="<?= isset($old['price']) ? $this->e($old['price']) : '' ?>" />
                <?php if (isset($errors['price'])) : ?>
                    <span class="invalid-feedback">
                        <strong><?= $this->e($errors['price']) ?></strong>
                    </span>
                <?php endif ?>
            </div>

            <!-- Loại sản phẩm -->
            <div class="col-md-12 col-sm-12">
                <select name="product_type" class="form-control<?= isset($errors['product_type']) ? ' is-invalid' : '' ?>" id="product_type" required>
                    <option value="Điện thoại" <?= isset($old['product_type']) && $old['product_type'] == 'Điện thoại' ? 'selected' : '' ?>>Điện thoại</option>
                    <option value="Laptop" <?= isset($old['product_type']) && $old['product_type'] == 'Laptop' ? 'selected' : '' ?>>Laptop</option>
                    <option value="Máy tính bảng" <?= isset($old['product_type']) && $old['product_type'] == 'Máy tính bảng' ? 'selected' : '' ?>>Máy tính bảng</option>
                    <option value="Đồng hồ" <?= isset($old['product_type']) && $old['product_type'] == 'Đồng hồ' ? 'selected' : '' ?>>Đồng hồ</option>
                </select>
                <?php if (isset($errors['product_type'])) : ?>
                    <span class="invalid-feedback">
                        <strong><?= $this->e($errors['product_type']) ?></strong>
                    </span>
                <?php endif ?>
            </div>
        </div>

        <!-- Gạch ngang phân tách -->
        <div class="separator"></div>
        <h3 class="text-center animate__animated animate__bounce">CHI TIẾT SẢN PHẨM</h3>
        <!-- Chi tiết sản phẩm (2 cột) -->
        <div class="product-details">
            <!-- Cột 1 -->
            <div>
                <!-- CPU -->
                <div class="col-md-12 col-sm-12">
                    <input type="text" name="cpu" class="form-control<?= isset($errors['cpu']) ? ' is-invalid' : '' ?>" id="cpu" placeholder="CPU của sản phẩm" value="<?= isset($old['cpu']) ? $this->e($old['cpu']) : '' ?>" />
                    <?php if (isset($errors['cpu'])) : ?>
                        <span class="invalid-feedback">
                            <strong><?= $this->e($errors['cpu']) ?></strong>
                        </span>
                    <?php endif ?>
                </div>

                <!-- RAM -->
                <div class="col-md-12 col-sm-12">
                    <input type="text" name="ram" class="form-control<?= isset($errors['ram']) ? ' is-invalid' : '' ?>" id="ram" placeholder="RAM của sản phẩm" value="<?= isset($old['ram']) ? $this->e($old['ram']) : '' ?>" />
                    <?php if (isset($errors['ram'])) : ?>
                        <span class="invalid-feedback">
                            <strong><?= $this->e($errors['ram']) ?></strong>
                        </span>
                    <?php endif ?>
                </div>

                <!-- Bộ nhớ -->
                <div class="col-md-12 col-sm-12">
                    <input type="text" name="storage" class="form-control<?= isset($errors['storage']) ? ' is-invalid' : '' ?>" id="storage" placeholder="Bộ nhớ của sản phẩm" value="<?= isset($old['storage']) ? $this->e($old['storage']) : '' ?>" />
                    <?php if (isset($errors['storage'])) : ?>
                        <span class="invalid-feedback">
                            <strong><?= $this->e($errors['storage']) ?></strong>
                        </span>
                    <?php endif ?>
                </div>

                <!-- Dung lượng pin -->
                <div class="col-md-12 col-sm-12">
                    <input type="text" name="battery_capacity" class="form-control<?= isset($errors['battery_capacity']) ? ' is-invalid' : '' ?>" id="battery_capacity" placeholder="Dung lượng pin của sản phẩm" value="<?= isset($old['battery_capacity']) ? $this->e($old['battery_capacity']) : '' ?>" />
                    <?php if (isset($errors['battery_capacity'])) : ?>
                        <span class="invalid-feedback">
                            <strong><?= $this->e($errors['battery_capacity']) ?></strong>
                        </span>
                    <?php endif ?>
                </div>

                 <!-- Khả năng chống nước -->
                 <div class="col-md-12 col-sm-12">
                    <input type="text" name="water_resistance" class="form-control<?= isset($errors['water_resistance']) ? ' is-invalid' : '' ?>" id="water_resistance" placeholder="Khả năng chống nước" value="<?= isset($old['water_resistance']) ? $this->e($old['water_resistance']) : '' ?>" />
                    <?php if (isset($errors['water_resistance'])) : ?>
                        <span class="invalid-feedback">
                            <strong><?= $this->e($errors['water_resistance']) ?></strong>
                        </span>
                    <?php endif ?>
                </div>
            </div>

            <!-- Cột 2 -->
            <div>
                <!-- Độ phân giải camera -->
                <div class="col-md-12 col-sm-12">
                    <input type="text" name="camera_resolution" class="form-control<?= isset($errors['camera_resolution']) ? ' is-invalid' : '' ?>" id="camera_resolution" placeholder="Độ phân giải camera" value="<?= isset($old['camera_resolution']) ? $this->e($old['camera_resolution']) : '' ?>" />
                    <?php if (isset($errors['camera_resolution'])) : ?>
                        <span class="invalid-feedback">
                            <strong><?= $this->e($errors['camera_resolution']) ?></strong>
                        </span>
                    <?php endif ?>
                </div>

                <!-- Kích thước màn hình -->
                <div class="col-md-12 col-sm-12">
                    <input type="text" name="screen_size" class="form-control<?= isset($errors['screen_size']) ? ' is-invalid' : '' ?>" id="screen_size" placeholder="Kích thước màn hình" value="<?= isset($old['screen_size']) ? $this->e($old['screen_size']) : '' ?>" />
                    <?php if (isset($errors['screen_size'])) : ?>
                        <span class="invalid-feedback">
                            <strong><?= $this->e($errors['screen_size']) ?></strong>
                        </span>
                    <?php endif ?>
                </div>

                <!-- Hệ điều hành -->
                <div class="col-md-12 col-sm-12">
                    <input type="text" name="os" class="form-control<?= isset($errors['os']) ? ' is-invalid' : '' ?>" id="os" placeholder="Hệ điều hành" value="<?= isset($old['os']) ? $this->e($old['os']) : '' ?>" />
                    <?php if (isset($errors['os'])) : ?>
                        <span class="invalid-feedback">
                            <strong><?= $this->e($errors['os']) ?></strong>
                        </span>
                    <?php endif ?>
                </div>

                <!-- Băng tần -->
                <div class="col-md-12 col-sm-12">
                    <input type="text" name="band" class="form-control<?= isset($errors['band']) ? ' is-invalid' : '' ?>" id="band" placeholder="Băng tần" value="<?= isset($old['band']) ? $this->e($old['band']) : '' ?>" />
                    <?php if (isset($errors['band'])) : ?>
                        <span class="invalid-feedback">
                            <strong><?= $this->e($errors['band']) ?></strong>
                        </span>
                    <?php endif ?>
                </div>

                <!-- Chất liệu dây đeo (Chỉ cho đồng hồ) -->
                <div class="col-md-12 col-sm-12">
                    <input type="text" name="strap_material" class="form-control<?= isset($errors['strap_material']) ? ' is-invalid' : '' ?>" id="strap_material" placeholder="Chất liệu dây đeo" value="<?= isset($old['strap_material']) ? $this->e($old['strap_material']) : '' ?>" />
                    <?php if (isset($errors['strap_material'])) : ?>
                        <span class="invalid-feedback">
                            <strong><?= $this->e($errors['strap_material']) ?></strong>
                        </span>
                    <?php endif ?>
                </div>

            </div>
        </div>

        <!-- Submit -->
        <button type="submit" name="submit" id="submit" class="btn btn-primary mb-3">Thêm sản phẩm</button>
    </form>
</div>

<?php $this->stop() ?>
