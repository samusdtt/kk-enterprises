<?php
declare(strict_types=1);

class StaffController extends Controller
{
    public function presentOrders(): void
    {
        $this->requireRole(['staff']);
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT o.* FROM orders o JOIN staff_delivery_logs s ON s.order_id = o.id WHERE s.staff_id = ? AND DATE(o.created_at) = CURDATE() ORDER BY o.category, o.id DESC');
        $stmt->execute([(int)$_SESSION['user']['id']]);
        $orders = $stmt->fetchAll();
        $this->view('staff/present_orders', compact('orders'));
    }

    public function markDelivered(): void
    {
        $this->requireRole(['staff']);
        $orderId = (int)($_POST['order_id'] ?? 0);
        if ($orderId) {
            Order::updateStatus($orderId, 'delivered');
            $pdo = Database::getConnection();
            $check = $pdo->prepare('SELECT id FROM staff_delivery_logs WHERE staff_id = ? AND order_id = ? LIMIT 1');
            $check->execute([(int)$_SESSION['user']['id'], $orderId]);
            $existing = $check->fetch();
            if ($existing) {
                $upd = $pdo->prepare('UPDATE staff_delivery_logs SET delivered_at = NOW() WHERE id = ?');
                $upd->execute([(int)$existing['id']]);
            } else {
                $ins = $pdo->prepare('INSERT INTO staff_delivery_logs (staff_id, order_id, delivered_at, paid_verified) VALUES (?, ?, NOW(), 0)');
                $ins->execute([(int)$_SESSION['user']['id'], $orderId]);
            }
        }
        $this->redirect('/staff/present-orders');
    }

    public function requestPaid(): void
    {
        $this->requireRole(['staff']);
        $orderId = (int)($_POST['order_id'] ?? 0);
        if ($orderId) {
            // Create staff log entry to request paid verification
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare('INSERT INTO staff_delivery_logs (staff_id, order_id, delivered_at, paid_verified) VALUES (?, ?, NOW(), 0)');
            $stmt->execute([(int)$_SESSION['user']['id'], $orderId]);
        }
        $this->redirect('/staff/present-orders');
    }

    public function weekly(): void
    {
        $this->requireRole(['staff']);
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT s.*, o.total_amount, o.status, o.created_at FROM staff_delivery_logs s JOIN orders o ON o.id = s.order_id WHERE s.staff_id = ? AND s.delivered_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ORDER BY s.delivered_at DESC');
        $stmt->execute([(int)$_SESSION['user']['id']]);
        $logs = $stmt->fetchAll();
        $this->view('staff/weekly', compact('logs'));
    }

    public function profile(): void
    {
        $this->requireRole(['staff']);
        $user = User::findById((int)$_SESSION['user']['id']);
        $this->view('staff/profile', compact('user'));
    }

    public function updateProfile(): void
    {
        $this->requireRole(['staff']);
        $id = (int)$_SESSION['user']['id'];
        User::updateProfile($id, [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
        ]);
        $_SESSION['user'] = array_merge($_SESSION['user'], [
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'address' => $_POST['address'] ?? '',
        ]);
        $this->redirect('/staff/profile');
    }
}

