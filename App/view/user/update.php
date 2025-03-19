<?php $this->layout("layouts/default", ["title" => "Cập Nhật Thông Tin Người Dùng"]) ?>

<?php $this->start("page") ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Cập Nhật Thông Tin Người Dùng</h1>

    <?php if (isset($message)): ?>
    <div class="alert alert-<?= htmlspecialchars($messageType) ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>


    <form method="POST" action="/account/update">
        <div class="form-group">
            <label for="name">Tên:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Địa chỉ:</label>
            <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($user['address']) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>

<?php $this->stop() ?>
