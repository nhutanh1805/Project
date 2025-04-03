<?php
namespace App\Controllers;

use App\Models\Order;
use Exception;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng của người dùng
    public function index()
    {
        $userId = $_SESSION['user_id']; // Lấy userId từ session

        try {
            // Lấy tất cả các đơn hàng của người dùng
            $orders = Order::getOrdersByUserId($userId);
            $this->sendPage('order/index', ['orders' => $orders]); // Truyền dữ liệu ra view
        } catch (Exception $e) {
            echo "Lỗi khi lấy danh sách đơn hàng: " . $e->getMessage();
        }
    }

    // Hiển thị chi tiết đơn hàng
    public function show($orderId)
    {
        try {
            // Lấy thông tin chi tiết đơn hàng
            $orderDetails = Order::getOrderDetails($orderId);
            $this->sendPage('order/show', ['orderDetails' => $orderDetails]);
        } catch (Exception $e) {
            echo "Lỗi khi lấy chi tiết đơn hàng: " . $e->getMessage();
        }
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus($orderId)
    {
        $status = $_POST['status'] ?? ''; // Trạng thái mới (ví dụ: 'Đang xử lý', 'Đã giao', v.v.)

        try {
            // Cập nhật trạng thái của đơn hàng
            Order::updateOrderStatus($orderId, $status);
            redirect("/orders"); // Chuyển hướng về danh sách đơn hàng sau khi cập nhật
        } catch (Exception $e) {
            echo "Lỗi khi cập nhật trạng thái đơn hàng: " . $e->getMessage();
        }
    }

    // Xóa đơn hàng
    public function delete($orderId)
    {
        try {
            // Xóa đơn hàng
            Order::deleteOrder($orderId);
            redirect("/orders"); // Chuyển hướng về danh sách đơn hàng sau khi xóa
        } catch (Exception $e) {
            echo "Lỗi khi xóa đơn hàng: " . $e->getMessage();
        }
    }
}
