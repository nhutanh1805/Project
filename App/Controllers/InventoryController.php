<?php
namespace App\Controllers;

use App\Models\Inventory;

class InventoryController extends Controller
{
    // Hiển thị danh sách kho hàng
    public function index(): void
    {
        $inventory = Inventory::getAllProductsInStock();  // Lấy tất cả sản phẩm trong kho
        $this->sendPage('inventory/index', [
            'inventory' => $inventory
        ]);
    }

    // Thêm sản phẩm vào kho
    public function add($productId): void
    {
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1; // Lấy số lượng sản phẩm từ form

        if ($quantity > 0) {
            Inventory::addToInventory((int)$productId, $quantity);  // Thêm vào kho
        }

        redirect('/inventory');  // Điều hướng lại đến trang kho hàng
    }

    // Cập nhật số lượng sản phẩm trong kho
    public function update($productId): void
    {
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1; // Lấy số lượng sản phẩm từ form

        if ($quantity >= 0) {
            Inventory::updateStock($productId, $quantity);  // Cập nhật số lượng trong kho
        }

        redirect('/inventory');  // Điều hướng lại đến trang kho hàng
    }

    // Xóa sản phẩm khỏi kho
    public function remove($productId): void
    {
        Inventory::removeFromInventory((int)$productId);  // Xóa sản phẩm khỏi kho
        redirect('/inventory');  // Điều hướng lại đến trang kho hàng
    }
}
