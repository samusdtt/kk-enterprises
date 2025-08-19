<?php
declare(strict_types=1);

class Order
{
    public static function create(int $clientId, string $paymentMethod, string $category, array $items): int
    {
        $pdo = Database::getConnection();
        $pdo->beginTransaction();
        try {
            $total = 0.0;
            foreach ($items as $item) {
                $product = Product::findById((int)$item['product_id']);
                if (!$product) {
                    throw new RuntimeException('Invalid product');
                }
                $total += (float)$product['price'] * (int)$item['quantity'];
            }

            $stmt = $pdo->prepare('INSERT INTO orders (client_id, status, payment_method, total_amount, category) VALUES (?, "pending", ?, ?, ?)');
            $stmt->execute([$clientId, $paymentMethod, $total, $category]);
            $orderId = (int)$pdo->lastInsertId();

            $itemStmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)');
            foreach ($items as $item) {
                $itemStmt->execute([$orderId, (int)$item['product_id'], (int)$item['quantity']]);
            }

            $pdo->commit();
            return $orderId;
        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function itemsForOrder(int $orderId): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT oi.*, p.name, p.price FROM order_items oi JOIN products p ON p.id = oi.product_id WHERE oi.order_id = ?');
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }

    public static function ordersForClient(int $clientId): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM orders WHERE client_id = ? ORDER BY created_at DESC');
        $stmt->execute([$clientId]);
        return $stmt->fetchAll();
    }

    public static function allByCategoryForDate(?string $date = null): array
    {
        $pdo = Database::getConnection();
        $date = $date ?: date('Y-m-d');
        $stmt = $pdo->prepare('SELECT * FROM orders WHERE DATE(created_at) = ? ORDER BY category');
        $stmt->execute([$date]);
        return $stmt->fetchAll();
    }

    public static function updateStatus(int $orderId, string $status): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('UPDATE orders SET status = ? WHERE id = ?');
        return $stmt->execute([$status, $orderId]);
    }
}

