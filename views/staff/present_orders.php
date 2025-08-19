<div class="space-y-4">
    <h2 class="text-xl font-semibold">Today's Orders</h2>
    <?php if (!$_SESSION['user']['login_hours_enabled']): ?>
        <div class="bg-yellow-50 text-yellow-800 p-3 rounded">Login hour is hidden by admin.</div>
    <?php else: ?>
        <div class="text-sm text-gray-500">Login Time: <?= date('H:i') ?></div>
    <?php endif; ?>
    <?php if (empty($orders)): ?>
        <div class="bg-white p-4 rounded shadow text-gray-500">No orders today.</div>
    <?php else: ?>
        <?php foreach ($orders as $o): ?>
            <div class="bg-white p-4 rounded shadow flex items-center justify-between">
                <div>
                    <div class="font-medium">Order #<?= (int)$o['id'] ?> • <?= htmlspecialchars($o['category']) ?></div>
                    <div class="text-sm text-gray-500">Status: <?= htmlspecialchars($o['status']) ?></div>
                </div>
                <div class="flex items-center gap-2">
                    <form method="post" action="/staff/mark-delivered">
                        <input type="hidden" name="order_id" value="<?= (int)$o['id'] ?>" />
                        <button class="px-3 py-1 rounded bg-green-600 text-white">Mark Delivered</button>
                    </form>
                    <form method="post" action="/staff/request-paid">
                        <input type="hidden" name="order_id" value="<?= (int)$o['id'] ?>" />
                        <button class="px-3 py-1 rounded bg-blue-600 text-white">Request Paid</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

