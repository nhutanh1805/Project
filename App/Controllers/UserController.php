<?php
namespace App\Controllers;

use App\Models\Account;
use App\Models\User;

class UserController extends Controller
{
    // Phương thức hiển thị trang thông tin người dùng
    public function user()
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa (có session user_id không)
        if (!isset($_SESSION['user_id'])) {
            // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập hoặc trang khác
            header('Location: /login');
            exit();
        }

        // Lấy thông tin người dùng từ database
        $userId = $_SESSION['user_id'];  // Lấy ID người dùng từ session
        $user = new Account(PDO());
        $userInfo = $user->getUserById($userId);  // Lấy thông tin người dùng từ model

        // Nếu không tìm thấy người dùng, có thể redirect đến trang đăng nhập
        if (!$userInfo) {
            header('Location: /login');
            exit();
        }

        // Gửi thông tin người dùng đến view
        $this->sendPage('user/account', [
            'user' => $userInfo  // Dữ liệu người dùng để hiển thị
        ]);
    }
}
