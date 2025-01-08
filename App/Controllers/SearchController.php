<?php

namespace App\Controllers;

use App\Models\Search;

class SearchController extends Controller
{
    public function index()
    {
        // Lấy giá trị tìm kiếm từ URL
        $query = isset($_GET['query']) ? $_GET['query'] : '';

        $results = [];

        // Nếu có từ khóa tìm kiếm
        if ($query) {
            // Tạo đối tượng Search và tìm kiếm sản phẩm
            $search = new Search(PDO());
            $results = $search->searchProducts($query);
        }

        // Gửi kết quả đến view
        $this->sendPage('search/index', [
            'results' => $results,
            'query' => $query
        ]);
    }
}
