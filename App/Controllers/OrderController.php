<?php
namespace App\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Exception;

class OrderController extends Controller
{
    // Tạo đơn hàng từ giỏ hàng
    public function create(): void
    {
        $userId = $_SESSION['user_id'];  // Lấy ID người dùng từ session
        $address = isset($_POST['address']) ? $_POST['address'] : ''; // Địa chỉ người dùng nhập vào

        if (empty($address)) {
            // Nếu không có địa chỉ, thông báo lỗi
            $this->sendPage('order/create', ['error' => 'Địa chỉ không được để trống']);
            return;
        }

        try {
            // Tạo đơn hàng từ giỏ hàng
            $orderId = Order::createOrder($userId, $address);
            // Chuyển hướng đến trang đơn hàng đã tạo
            redirect("/order/view/{$orderId}");
        } catch (Exception $e) {
            // Nếu có lỗi khi tạo đơn hàng, hiển thị lỗi
            $this->sendPage('order/create', ['error' => $e->getMessage()]);
        }
    }

    // Xem chi tiết đơn hàng
    public function view($orderId): void
    {
        $userId = $_SESSION['user_id'];

        // Lấy thông tin đơn hàng từ model Order
        $order = Order::getOrder($orderId);

        if (empty($order)) {
            // Nếu không tìm thấy đơn hàng, thông báo lỗi
            $this->sendPage('order/view', ['error' => 'Không tìm thấy đơn hàng']);
            return;
        }

        // Kiểm tra nếu người dùng không phải chủ đơn hàng
        if ($order[0]['user_id'] != $userId) {
            $this->sendPage('order/view', ['error' => 'Bạn không có quyền xem đơn hàng này']);
            return;
        }

        // Hiển thị chi tiết đơn hàng
        $this->sendPage('order/view', ['order' => $order]);
    }

    // Xem tất cả đơn hàng của người dùng
    public function index(): void
    {
        $userId = $_SESSION['user_id'];

        // Lấy tất cả đơn hàng của người dùng từ model Order
        $orders = Order::getUserOrders($userId);

        // Hiển thị danh sách đơn hàng
        $this->sendPage('order/index', ['orders' => $orders]);
    }

    // Cập nhật địa chỉ giao hàng cho đơn hàng
    public function updateAddress($orderId): void
    {
        $userId = $_SESSION['user_id'];
        $newAddress = isset($_POST['address']) ? $_POST['address'] : '';

        if (empty($newAddress)) {
            // Nếu địa chỉ mới không có, thông báo lỗi
            $this->sendPage('order/updateAddress', ['error' => 'Địa chỉ không được để trống']);
            return;
        }

        try {
            // Cập nhật địa chỉ giao hàng của đơn hàng
            Order::updateOrderAddress($orderId, $newAddress);
            redirect("/order/view/{$orderId}");
        } catch (Exception $e) {
            // Nếu có lỗi, hiển thị thông báo lỗi
            $this->sendPage('order/updateAddress', ['error' => $e->getMessage()]);
        }
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus($orderId): void
    {
        $userId = $_SESSION['user_id'];
        $status = isset($_POST['status']) ? $_POST['status'] : '';

        // Kiểm tra trạng thái hợp lệ
        if (!in_array($status, ['Processing', 'Shipped', 'Delivered', 'Cancelled'])) {
            // Nếu trạng thái không hợp lệ, thông báo lỗi
            $this->sendPage('order/updateStatus', ['error' => 'Trạng thái không hợp lệ']);
            return;
        }

        // Kiểm tra nếu người dùng có quyền cập nhật trạng thái đơn hàng (có thể chỉ admin hoặc người tạo đơn)
        $order = Order::getOrder($orderId);
        if ($order[0]['user_id'] != $userId) {
            $this->sendPage('order/updateStatus', ['error' => 'Bạn không có quyền cập nhật trạng thái của đơn hàng này']);
            return;
        }

        try {
            // Cập nhật trạng thái của đơn hàng
            Order::updateOrderStatus($orderId, $status);
            redirect("/order/view/{$orderId}");
        } catch (Exception $e) {
            // Nếu có lỗi, hiển thị thông báo lỗi
            $this->sendPage('order/updateStatus', ['error' => $e->getMessage()]);
        }
    }

    // Hủy đơn hàng
    public function cancel($orderId): void
    {
        $userId = $_SESSION['user_id'];

        // Kiểm tra nếu người dùng có quyền hủy đơn hàng (có thể chỉ admin hoặc người tạo đơn)
        $order = Order::getOrder($orderId);
        if ($order[0]['user_id'] != $userId) {
            $this->sendPage('order/view', ['error' => 'Bạn không có quyền hủy đơn hàng này']);
            return;
        }

        try {
            // Hủy đơn hàng
            Order::cancelOrder($orderId);
            redirect('/order');
        } catch (Exception $e) {
            // Nếu có lỗi, hiển thị thông báo lỗi
            $this->sendPage('order/view', ['error' => $e->getMessage()]);
        }
    }
}
?>
