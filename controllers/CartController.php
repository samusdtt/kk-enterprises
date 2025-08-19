<?php
declare(strict_types=1);

class CartController extends Controller
{
    public function view(): void
    {
        $this->requireRole(['client']);
        $cart = $_SESSION['cart'] ?? [];
        $items = [];
        $total = 0.0;
        foreach ($cart as $line) {
            $product = Product::findById((int)$line['product_id']);
            if ($product) {
                $lineTotal = (float)$product['price'] * (int)$line['quantity'];
                $items[] = [
                    'product' => $product,
                    'quantity' => (int)$line['quantity'],
                    'line_total' => $lineTotal,
                ];
                $total += $lineTotal;
            }
        }
        $this->view('client/cart', compact('items', 'total'));
    }

    public function add(): void
    {
        $this->requireRole(['client']);
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = max(1, (int)($_POST['quantity'] ?? 1));
        if ($productId <= 0) { $this->redirect('/client/order'); }
        $cart = $_SESSION['cart'] ?? [];
        $found = false;
        foreach ($cart as &$line) {
            if ((int)$line['product_id'] === $productId) {
                $line['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        unset($line);
        if (!$found) {
            $cart[] = ['product_id' => $productId, 'quantity' => $quantity];
        }
        $_SESSION['cart'] = $cart;
        $this->redirect('/client/cart');
    }

    public function update(): void
    {
        $this->requireRole(['client']);
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = max(0, (int)($_POST['quantity'] ?? 1));
        $cart = $_SESSION['cart'] ?? [];
        foreach ($cart as $idx => $line) {
            if ((int)$line['product_id'] === $productId) {
                if ($quantity === 0) {
                    unset($cart[$idx]);
                } else {
                    $cart[$idx]['quantity'] = $quantity;
                }
                break;
            }
        }
        $_SESSION['cart'] = array_values($cart);
        $this->redirect('/client/cart');
    }

    public function remove(): void
    {
        $this->requireRole(['client']);
        $productId = (int)($_POST['product_id'] ?? 0);
        $cart = $_SESSION['cart'] ?? [];
        foreach ($cart as $idx => $line) {
            if ((int)$line['product_id'] === $productId) {
                unset($cart[$idx]);
                break;
            }
        }
        $_SESSION['cart'] = array_values($cart);
        $this->redirect('/client/cart');
    }
}

