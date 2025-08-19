<?php
declare(strict_types=1);

class OrderController extends Controller
{
    public function createForm(): void
    {
        $this->requireRole(['client']);
        $products = Product::all();
        $cart = $_SESSION['cart'] ?? [];
        $this->view('client/order_create', compact('products', 'cart'));
    }

    public function createPost(): void
    {
        $this->requireRole(['client']);
        $clientId = (int)$_SESSION['user']['id'];
        $payment = $_POST['payment_method'] ?? 'cash';
        $category = $_POST['category'] ?? 'Flats';
        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $this->redirect('/client/cart');
        }
        $orderId = Order::create($clientId, $payment, $category, $cart);
        if ($payment === 'due') {
            Order::updateStatus($orderId, 'due_requested');
        }
        unset($_SESSION['cart']);
        $this->redirect('/client/orders');
    }

    public function history(): void
    {
        $this->requireRole(['client']);
        $orders = Order::ordersForClient((int)$_SESSION['user']['id']);
        $this->view('client/orders', compact('orders'));
    }

    public function invoice(): void
    {
        $this->requireRole(['client']);
        $orderId = (int)($_GET['id'] ?? 0);
        $orders = Order::ordersForClient((int)$_SESSION['user']['id']);
        $order = null;
        foreach ($orders as $o) {
            if ((int)$o['id'] === $orderId) { $order = $o; break; }
        }
        if (!$order) {
            http_response_code(404);
            echo 'Invoice not found';
            return;
        }
        $items = Order::itemsForOrder($orderId);
        $this->view('client/invoice', compact('order', 'items'));
    }
}

