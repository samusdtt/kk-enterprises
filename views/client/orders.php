<div class="space-y-4">
    <h2 class="text-xl font-semibold">Order History</h2>
    <?php if (empty($orders)): ?>
        <div class="bg-white p-4 rounded shadow text-gray-500">No orders yet.</div>
    <?php else: ?>
        <?php foreach ($orders as $o): ?>
            <div class="bg-white p-4 rounded shadow flex items-center justify-between">
                <div>
                    <div class="font-medium">Order #<?= (int)$o['id'] ?> • <?= htmlspecialchars($o['category']) ?></div>
                    <div class="text-sm text-gray-500">Placed: <?= htmlspecialchars($o['created_at']) ?> • Status: <span class="uppercase"><?= htmlspecialchars($o['status']) ?></span></div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="font-semibold">₹<?= number_format((float)$o['total_amount'], 2) ?></div>
                    <a href="/client/invoice?id=<?= (int)$o['id'] ?>" class="text-blue-600">Invoice</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

