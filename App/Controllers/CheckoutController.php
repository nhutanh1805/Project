<?php
namespace App\Controllers;

use App\Models\Cart;

class CheckoutController extends Controller
{
    // Hiển thị trang thanh toán
    public function index()
    {
        // Lấy userId từ session
        $userId = $_SESSION['user_id'];

        // Lấy giỏ hàng và tổng tiền từ model Cart
        $cart = Cart::getCart($userId);
        $total = Cart::getTotal($userId);

        // Truyền dữ liệu sang view
        $this->sendPage('checkout/index', [
            'cart' => $cart,
            'total' => $total
        ]);
    }

    // Xử lý thanh toán
    public function process()
    {
        // Lấy thông tin từ form
        $name = $_POST['name'] ?? '';
        $address = $_POST['address'] ?? '';
        $paymentMethod = $_POST['payment_method'] ?? '';
        $cardNumber = $_POST['card_number'] ?? '';

        // Kiểm tra phương thức thanh toán
        if ($paymentMethod === 'cod') {
            // Xử lý nhận tiền khi giao hàng
            $this->processCOD($name, $address);
        } elseif ($paymentMethod === 'online') {
            // Chuyển hướng người dùng đến trang giao dịch online
            return $this->redirectToOnlinePayment($cardNumber);
        }

        // Quá trình thanh toán xong, chuyển hướng đến trang cảm ơn
        redirect('/thank-you');
    }

    // Xử lý nhận tiền khi giao hàng
    private function processCOD($name, $address)
    {
        // Giả lập lưu thông tin đơn hàng và xử lý COD
        // Ví dụ: Lưu thông tin vào database, gửi email xác nhận, v.v.
        // Bạn có thể xử lý logic lưu đơn hàng vào cơ sở dữ liệu ở đây.
        echo "Đơn hàng của bạn sẽ được giao đến địa chỉ $address. Thanh toán khi nhận hàng!";
    }

    // Chuyển hướng người dùng đến trang giao dịch online
    private function redirectToOnlinePayment($cardNumber)
    {
        // Giả lập chuyển hướng đến một trang thanh toán online (ví dụ PayPal, Stripe)
        // Bạn có thể sử dụng API của PayPal, Stripe, v.v.
        // Ở đây bạn chỉ cần chuyển hướng đến một trang thanh toán.
        return header('Location: /payment-online');
    }

    // Trang cảm ơn sau khi thanh toán thành công
    public function thankYou()
    {
        // Hiển thị trang cảm ơn sau khi thanh toán thành công
        $this->sendPage('checkout/thank-you');
    }
}
