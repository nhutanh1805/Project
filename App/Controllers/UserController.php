<?php
namespace App\Controllers;

use App\Models\Account;

class UserController extends Controller
{
    // Phương thức hiển thị trang thông tin người dùng
    public function user()
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!isset($_SESSION['user_id'])) {
            // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
            header('Location: /login');
            exit();
        }

        // Lấy thông tin người dùng từ database
        $userId = $_SESSION['user_id'];  // Lấy ID người dùng từ session
        $user = new Account(PDO());
        $userInfo = $user->getUserById($userId);

        // Nếu không tìm thấy người dùng, redirect đến trang đăng nhập
        if (!$userInfo) {
            header('Location: /login');
            exit();
        }

        // Gửi thông tin người dùng đến view
        $this->sendPage('user/account', [
            'user' => $userInfo
        ]);
    }

    // Phương thức hiển thị trang cập nhật thông tin người dùng
    public function updateUser()
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!isset($_SESSION['user_id'])) {
            // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
            header('Location: /login');
            exit();
        }

        // Lấy ID người dùng từ session
        $userId = $_SESSION['user_id'];
        $user = new Account(PDO());

        // Kiểm tra nếu form đã được submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            // Cập nhật thông tin người dùng
            $updateResult = $user->updateUser($userId, $name, $email, $phone, $address);

            // Nếu cập nhật thành công
            if ($updateResult) {
                $message = 'Cập nhật thông tin thành công!';
                $messageType = 'success';
            } else {
                $message = 'Có lỗi xảy ra. Vui lòng thử lại!';
                $messageType = 'danger';
            }

            // Gửi thông báo và thông tin người dùng đến view
            $userInfo = $user->getUserById($userId);
            $this->sendPage('user/update', [
                'user' => $userInfo,
                'message' => $message,
                'messageType' => $messageType
            ]);
        } else {
            // Nếu không phải là POST request, chỉ lấy thông tin người dùng
            $userInfo = $user->getUserById($userId);
            $this->sendPage('user/update', [
                'user' => $userInfo
            ]);
        }
    }
}
