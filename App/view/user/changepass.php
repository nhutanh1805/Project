<?php if (isset($message)): ?>
    <div class="alert alert-<?php echo $messageType; ?>" role="alert">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<h2>Thay đổi mật khẩu</h2>

<form method="POST" action="/user/changepass">
    <div class="mb-3">
        <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
        <input type="password" class="form-control" id="current_password" name="current_password" required>
    </div>
    <div class="mb-3">
        <label for="new_password" class="form-label">Mật khẩu mới</label>
        <input type="password" class="form-control" id="new_password" name="new_password" required>
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
    </div>
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
</form>
