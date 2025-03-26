<?php
namespace App\Controllers;

use App\Models\Cart;
use App\Models\Order;

class OrderController extends Controller
{
    // Thanh toán và tạo đơn hàng
    public function checkout(): void
    {
        $userId = $_SESSION['user_id']; // Lấy ID người dùng từ session

        // Lấy giỏ hàng của người dùng
        $cart = Cart::getCart($userId);
        $total = Cart::getTotal($userId);

        // Kiểm tra xem giỏ hàng có sản phẩm không
        if (empty($cart)) {
            // Nếu giỏ hàng rỗng, chuyển hướng đến trang giỏ hàng
            redirect('/cart');
            return;
        }

        // Tạo đơn hàng
        $orderId = Order::createOrder($userId, $total);

        // Thêm sản phẩm vào đơn hàng
        foreach ($cart as $item) {
            $productId = $item['id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $totalPrice = $item['total_price'];

            Order::createOrderItems($orderId, $productId, $quantity, $price, $totalPrice);
        }

        // Sau khi thanh toán, xóa giỏ hàng của người dùng
        Cart::clearCart($userId);

        // Cập nhật trạng thái đơn hàng (đang chờ xử lý)
        Order::updateOrderStatus($orderId, 0);

        // Chuyển hướng đến trang xác nhận thanh toán
        redirect('/order/xacnhan/' . $orderId);
    }

    // Xác nhận đơn hàng
    public function confirm($orderId): void
    {
        // Lấy thông tin đơn hàng và các sản phẩm trong đơn hàng
        $order = Order::getOrderById($orderId);
        $orderItems = Order::getOrderItems($orderId);
        $totalPrice = array_sum(array_column($orderItems, 'total_price'));

        // Gửi dữ liệu đến view
        $this->sendPage('order/xacnhan', [
            'order' => $order,
            'orderItems' => $orderItems,
            'totalPrice' => $totalPrice
        ]);
    }

    // Xem tất cả đơn hàng của người dùng (Admin có thể xem của tất cả người dùng)
    public function listOrders(): void
    {
        $userId = $_SESSION['user_id'];
        $role = $_SESSION['role'];

        if ($role == 1) { // Admin
            $orders = Order::getAllOrders();
        } else {
            $orders = Order::getOrdersByUserId($userId);
        }

        $this->sendPage('order/list', ['orders' => $orders]);
    }
}
