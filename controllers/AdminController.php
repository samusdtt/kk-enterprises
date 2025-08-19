<?php
declare(strict_types=1);

class AdminController extends Controller
{
    public function dailyOrders(): void
    {
        $this->requireRole(['admin']);
        $date = $_GET['date'] ?? null;
        $orders = Order::allByCategoryForDate($date);
        // group by category
        $grouped = [];
        foreach ($orders as $o) {
            $grouped[$o['category']][] = $o;
        }
        $this->view('admin/daily_orders', ['grouped' => $grouped, 'date' => $date ?: date('Y-m-d')]);
    }

    public function updateOrderStatus(): void
    {
        $this->requireRole(['admin']);
        $orderId = (int)($_POST['order_id'] ?? 0);
        $status = $_POST['status'] ?? 'pending';
        if ($orderId) { Order::updateStatus($orderId, $status); }
        $this->redirect('/admin/daily-orders');
    }

    public function clients(): void
    {
        $this->requireRole(['admin']);
        $pdo = Database::getConnection();
        $rows = $pdo->query("SELECT id, username, name, email FROM users WHERE role = 'client' ORDER BY name")->fetchAll();
        $this->view('admin/clients', ['clients' => $rows]);
    }

    public function clientDetail(): void
    {
        $this->requireRole(['admin']);
        $id = (int)($_GET['id'] ?? 0);
        $user = User::findById($id);
        if (!$user || $user['role'] !== 'client') { http_response_code(404); echo 'Client not found'; return; }
        $orders = Order::ordersForClient($id);
        $this->view('admin/client_detail', compact('user', 'orders'));
    }

    public function staffAlignment(): void
    {
        $this->requireRole(['admin']);
        $pdo = Database::getConnection();
        $staff = $pdo->query("SELECT id, name FROM users WHERE role = 'staff' ORDER BY name")->fetchAll();
        $orders = $pdo->query("SELECT id, client_id, status, category FROM orders WHERE DATE(created_at)=CURDATE() ORDER BY category, id DESC")->fetchAll();
        $this->view('admin/staff_alignment', compact('staff', 'orders'));
    }

    public function assignStaff(): void
    {
        $this->requireRole(['admin']);
        $staffId = (int)($_POST['staff_id'] ?? 0);
        $orderId = (int)($_POST['order_id'] ?? 0);
        if ($staffId && $orderId) {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare('INSERT INTO staff_delivery_logs (staff_id, order_id, delivered_at, paid_verified) VALUES (?, ?, NULL, 0)');
            $stmt->execute([$staffId, $orderId]);
        }
        $this->redirect('/admin/staff-alignment');
    }

    public function setLoginHoursVisibility(): void
    {
        $this->requireRole(['admin']);
        $staffId = (int)($_POST['staff_id'] ?? 0);
        $enabled = (bool)($_POST['enabled'] ?? false);
        if ($staffId) { User::setLoginHoursVisibility($staffId, $enabled); }
        $this->redirect('/admin/staff-alignment');
    }

    public function accounts(): void
    {
        $this->requireRole(['admin']);
        $pdo = Database::getConnection();
        $date = $_GET['date'] ?? date('Y-m-d');
        $stmt = $pdo->prepare('SELECT * FROM daily_accounts WHERE record_date = ? ORDER BY id DESC');
        $stmt->execute([$date]);
        $records = $stmt->fetchAll();
        $this->view('admin/accounts', compact('records', 'date'));
    }

    public function saveAccount(): void
    {
        $this->requireRole(['admin']);
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('INSERT INTO daily_accounts (record_date, type, amount, notes) VALUES (?, ?, ?, ?)');
        $stmt->execute([
            $_POST['record_date'] ?? date('Y-m-d'),
            $_POST['type'] ?? 'income',
            (float)($_POST['amount'] ?? 0),
            trim($_POST['notes'] ?? ''),
        ]);
        $this->redirect('/admin/accounts?date=' . urlencode($_POST['record_date'] ?? date('Y-m-d')));
    }

    public function jars(): void
    {
        $this->requireRole(['admin']);
        $pdo = Database::getConnection();
        $date = $_GET['date'] ?? date('Y-m-d');
        $stmt = $pdo->prepare('SELECT * FROM jar_records WHERE record_date = ? LIMIT 1');
        $stmt->execute([$date]);
        $record = $stmt->fetch();
        $this->view('admin/jars', compact('record', 'date'));
    }

    public function saveJars(): void
    {
        $this->requireRole(['admin']);
        $pdo = Database::getConnection();
        $date = $_POST['record_date'] ?? date('Y-m-d');
        $stmt = $pdo->prepare('INSERT INTO jar_records (record_date, total_jars, refilling, empty, onboard) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE total_jars = VALUES(total_jars), refilling = VALUES(refilling), empty = VALUES(empty), onboard = VALUES(onboard)');
        $stmt->execute([
            $date,
            (int)($_POST['total_jars'] ?? 0),
            (int)($_POST['refilling'] ?? 0),
            (int)($_POST['empty'] ?? 0),
            (int)($_POST['onboard'] ?? 0),
        ]);
        $this->redirect('/admin/jars?date=' . urlencode($date));
    }
}

