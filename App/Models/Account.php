<?php
namespace App\Models;

class Account
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Phương thức lấy thông tin người dùng từ ID
    public function getUserById($userId)
    {
        // Cập nhật câu lệnh SQL để lấy các trường name, email, password, created_at, phone, address và role
        $stmt = $this->pdo->prepare("SELECT id, name, email, password, created_at, phone, address, role FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        $stmt->execute();

        // Lấy kết quả người dùng và trả về (mảng hoặc false nếu không tìm thấy)
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Nếu người dùng tồn tại và có trường role, chúng ta có thể xử lý role
        if ($user) {
            // Xử lý role: nếu role = 1 là admin, nếu role = 0 là người dùng thường
            $user['role'] = $user['role'] == 1 ? 'Người quản trị' : 'Khách hàng';
        }

        return $user;
    }
}


