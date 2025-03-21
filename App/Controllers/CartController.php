<?php
namespace App\Controllers;

use App\Models\Cart;

class CartController extends Controller
{
    // Thêm sản phẩm vào giỏ hàng
    public function add($productId): void
    {
        $userId = $_SESSION['user_id']; // Lấy ID người dùng từ session
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        // Lưu giỏ hàng vào cơ sở dữ liệu
        Cart::addToCart($userId, (int)$productId, $quantity);

        redirect('/cart');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($productId): void
    {
        $userId = $_SESSION['user_id'];
        Cart::removeFromCart($userId, (int)$productId);
        redirect('/cart');
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function update($productId): void
    {
        $userId = $_SESSION['user_id'];
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        if ($quantity < 1) {
            $quantity = 1; // Đảm bảo số lượng ít nhất là 1
        }
        Cart::updateQuantity($userId, (int)$productId, $quantity);
        redirect('/cart');
    }

    // Hiển thị giỏ hàng
    public function index(): void
    {
        $userId = $_SESSION['user_id'];
        $cart  = Cart::getCart($userId);
        $total = Cart::getTotal($userId);
        $this->sendPage('cart/index', [
            'cart'  => $cart,
            'total' => $total
        ]);
    }
}
