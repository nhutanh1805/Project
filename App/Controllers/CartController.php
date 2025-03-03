<?php
namespace App\Controllers;

use App\Models\Cart;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index(): void
    {
        $cart  = Cart::getCart();
        $total = Cart::getTotal();
        $this->sendPage('cart/index', [
            'cart'  => $cart,
            'total' => $total
        ]);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add($productId): void
    {
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        Cart::addToCart((int)$productId, $quantity);
        redirect('/cart');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($productId): void
    {
        Cart::removeFromCart((int)$productId);
        redirect('/cart');
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function update($productId): void
    {
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        Cart::updateQuantity((int)$productId, $quantity);
        redirect('/cart');
    }
}
