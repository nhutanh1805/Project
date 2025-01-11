<?php $this->layout("layouts/default", ["title" => "Cảm ơn"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Cảm ơn bạn đã mua hàng tại <?= CONGNGHE ?>!</h2>
        <p class="text-center">Đơn hàng của bạn đã được xử lý thành công. Chúng tôi sẽ liên hệ với bạn sớm nhất có thể.</p>
        <p class="text-center">Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua email hoặc điện thoại.</p>
        <div class="text-center">
            <a href="/home" class="btn btn-primary">Quay lại trang chủ</a>
        </div>
    </div>
</main>
<?php $this->stop() ?>
