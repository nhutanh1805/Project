<?php
namespace App\Controllers;

use App\Models\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        // Lấy giỏ hàng và tổng tiền từ session hoặc Cart model
        $cart = Cart::getCart();
        $total = Cart::getTotal();

        // Truyền dữ liệu sang view
        $this->sendPage('checkout/index', [
            'cart' => $cart,
            'total' => $total
        ]);
    }

    // Phương thức xử lý thanh toán
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
    }

    // Chuyển hướng người dùng đến trang giao dịch online
    private function redirectToOnlinePayment($cardNumber)
    {
        // Giả lập chuyển hướng đến một trang thanh toán online (ví dụ PayPal, Stripe)
        // Bạn có thể sử dụng API của PayPal, Stripe, v.v.
        return header('Location: /payment-online');
    }

    public function thankYou()
    {
        // Hiển thị trang cảm ơn sau khi thanh toán thành công
        $this->sendPage('checkout/thank-you');
    }
}
