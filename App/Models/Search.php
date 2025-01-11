<?php
namespace App\Models;

use PDO;

class Search
{
    private PDO $db;  // Biến này sẽ lưu trữ kết nối PDO đến cơ sở dữ liệu

    /**
     * Hàm khởi tạo lớp Search, nhận vào đối tượng PDO để thiết lập kết nối cơ sở dữ liệu.
     *
     * @param PDO $pdo Đối tượng PDO dùng để kết nối với cơ sở dữ liệu.
     */
    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;  // Lưu đối tượng PDO vào thuộc tính $db để sử dụng trong các phương thức sau
    }

    /**
     * Tìm kiếm sản phẩm trong cơ sở dữ liệu theo từ khóa.
     *
     * @param string $query Từ khóa tìm kiếm (có thể là tên hoặc mô tả sản phẩm).
     * @return array Một mảng chứa các sản phẩm tìm được (dưới dạng mảng kết hợp), tối đa 10 sản phẩm.
     */
    public function searchProducts(string $query): array
    {
        // Câu truy vấn SQL để tìm sản phẩm có tên hoặc mô tả chứa từ khóa tìm kiếm
        $stmt = $this->db->prepare('
            SELECT * FROM product
            WHERE name LIKE :query OR description LIKE :query
            LIMIT 10
        ');

        // Gắn giá trị cho tham số :query trong câu truy vấn
        // Dấu % được thêm vào trước và sau từ khóa để tìm kiếm bất kỳ tên hoặc mô tả sản phẩm nào chứa từ khóa
        $stmt->bindValue(':query', '%' . $query . '%');

        // Thực thi câu truy vấn
        $stmt->execute();

        // Trả về danh sách sản phẩm tìm được dưới dạng mảng kết hợp
        // PDO::FETCH_ASSOC trả về kết quả dưới dạng mảng kết hợp với tên cột là key và giá trị là giá trị của cột
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
