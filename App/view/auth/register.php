<?php $this->layout("layouts/default", ["title" => CONGNGHE]) ?>

<?php $this->start("page") ?>
<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2">

      <div class="card mt-3">
        <div class="card-header fw-bold text-uppercase text-center">ĐĂNG NHẬP</div>
        <div class="card-body bg-body-tertiary">

          <form method="POST" action="/register">
            <div class="mb-3 row">
              <label for="name" class="offset-md-2 col-md-3 col-form-label">Tên Người Dùng</label>
              <div class="col-md-5">
                <input id="name" type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" name="name" value="<?= isset($old['name']) ? $this->e($old['name']) : '' ?>" required autofocus>

                <?php if (isset($errors['name'])) : ?>
                  <span class="invalid-feedback">
                    <strong><?= $this->e($errors['name']) ?></strong>
                  </span>
                <?php endif ?>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="email" class="offset-md-2 col-md-3 col-form-label">Địa chỉ E-Mail</label>
              <div class="col-md-5">
                <input id="email" type="email" class="form-control <?= isset($errors['email']) ? ' is-invalid' : '' ?>" name="email" value="<?= isset($old['email']) ? $this->e($old['email']) : '' ?>" required>

                <?php if (isset($errors['email'])) : ?>
                  <span class="invalid-feedback">
                    <strong><?= $this->e($errors['email']) ?></strong>
                  </span>
                <?php endif ?>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="password" class="offset-md-2 col-md-3 col-form-label">Mật khẩu</label>
              <div class="col-md-5">
                <input id="password" type="password" class="form-control <?= isset($errors['password']) ? ' is-invalid' : '' ?>" name="password" required>

                <?php if (isset($errors['password'])) : ?>
                  <span class="invalid-feedback">
                    <strong><?= $this->e($errors['password']) ?></strong>
                  </span>
                <?php endif ?>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="password-confirm" class="offset-md-2 col-md-3 col-form-label">Xác nhận mật khẩu</label>
              <div class="col-md-5">
                <input id="password-confirm" type="password" class="form-control <?= isset($errors['password_confirmation']) ? ' is-invalid' : '' ?>" name="password_confirmation" required>

                <?php if (isset($errors['password_confirmation'])) : ?>
                  <span class="invalid-feedback">
                    <strong><?= $this->e($errors['password_confirmation']) ?></strong>
                  </span>
                <?php endif ?>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="phone" class="offset-md-2 col-md-3 col-form-label">Số điện thoại</label>
              <div class="col-md-5">
                <input id="phone" type="password" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" name="phone" value="<?= isset($old['phone']) ? $this->e($old['phone']) : '' ?>" required autofocus>

                <?php if (isset($errors['phone'])) : ?>
                  <span class="invalid-feedback">
                    <strong><?= $this->e($errors['phone']) ?></strong>
                  </span>
                <?php endif ?>
              </div>
            </div>

            <div class="mb-3 row">
              <div class="col-md-5 offset-md-5">
                <button type="submit" class="btn btn-primary">
                  Đăng ký
                </button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->stop() ?>