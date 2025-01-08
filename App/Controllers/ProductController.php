<?php
class ProductController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    // Phương thức xử lý yêu cầu tìm kiếm
    public function searchAction($keyword) {

        $products = $this->model->search($keyword);

        include('views/search/index.php');
    }
}
?>
