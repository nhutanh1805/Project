<?php
namespace App\Controllers;

use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
        // Lấy giỏ hàng và tổng tiền từ lớp Cart
        $cart = Cart::getCart();
        $total = Cart::getTotal();
        
        // Truyền dữ liệu sang view
        $this->sendPage('cart/index', [
            'cart' => $cart,
            'total' => $total
        ]);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add($productId)
    {
        $quantity = $_POST['quantity'] ?? 1; // Số lượng mặc định là 1 nếu không có dữ liệu từ form
        Cart::addToCart($productId, $quantity); // Thêm sản phẩm vào giỏ hàng

        // Sau khi thêm xong, chuyển hướng về trang giỏ hàng
        redirect('/cart');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($productId)
    {
        Cart::removeFromCart($productId); // Xóa sản phẩm khỏi giỏ hàng

        // Sau khi xóa xong, chuyển hướng về trang giỏ hàng
        redirect('/cart');
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function update($productId)
    {
        $quantity = $_POST['quantity'] ?? 1; // Lấy số lượng mới từ form, mặc định là 1
        Cart::updateQuantity($productId, $quantity); // Cập nhật số lượng cho sản phẩm

        // Sau khi cập nhật xong, chuyển hướng về trang giỏ hàng
        redirect('/cart');
    }
}
