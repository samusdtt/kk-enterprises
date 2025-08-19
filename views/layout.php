<?php
// Basic Tailwind layout with top navigation based on role
$user = $_SESSION['user'] ?? null;
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KK Enterprises – Water Management App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50 text-gray-900">
    <header class="bg-white border-b sticky top-0 z-10">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="font-semibold text-lg">KK Enterprises</a>
            <nav class="flex items-center gap-4 text-sm">
                <?php if ($user && $user['role'] === 'client'): ?>
                    <a class="hover:text-blue-600" href="/client/order">Home</a>
                    <a class="hover:text-blue-600" href="/client/cart">Cart</a>
                    <a class="hover:text-blue-600" href="/client/orders">Orders</a>
                    <a class="hover:text-blue-600" href="/client/profile">Profile</a>
                <?php elseif ($user && $user['role'] === 'staff'): ?>
                    <a class="hover:text-blue-600" href="/staff/present-orders">Present Orders</a>
                    <a class="hover:text-blue-600" href="/staff/weekly">Weekly Record</a>
                    <a class="hover:text-blue-600" href="/staff/profile">Profile</a>
                <?php elseif ($user && $user['role'] === 'admin'): ?>
                    <a class="hover:text-blue-600" href="/admin/daily-orders">Daily Orders</a>
                    <a class="hover:text-blue-600" href="/admin/clients">Clients</a>
                    <a class="hover:text-blue-600" href="/admin/staff-alignment">Staff Alignment</a>
                    <a class="hover:text-blue-600" href="/admin/accounts">Accounts</a>
                    <a class="hover:text-blue-600" href="/admin/jars">Jar Record</a>
                <?php endif; ?>
                <?php if ($user): ?>
                    <a class="text-red-600 hover:text-red-700" href="/logout">Logout</a>
                <?php else: ?>
                    <a class="hover:text-blue-600" href="/login">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="max-w-6xl mx-auto p-4">
        <?= $content ?>
    </main>
    <footer class="text-center text-xs text-gray-500 py-8">
        © <?= date('Y') ?> KK Enterprises
    </footer>
</body>
</html>

