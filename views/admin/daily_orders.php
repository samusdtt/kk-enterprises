<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">Daily Orders (<?= htmlspecialchars($date) ?>)</h2>
        <form class="flex items-center gap-2" method="get" action="/admin/daily-orders">
            <input type="date" name="date" value="<?= htmlspecialchars($date) ?>" class="border rounded px-2 py-1" />
            <button class="bg-blue-600 text-white px-3 py-1 rounded">Go</button>
        </form>
    </div>
    <?php if (empty($grouped)): ?>
        <div class="bg-white p-4 rounded shadow text-gray-500">No orders for this date.</div>
    <?php else: ?>
        <?php foreach ($grouped as $category => $list): $totalAmount=0; $jarCount=0; ?>
            <div class="bg-white rounded shadow">
                <div class="border-b px-4 py-2 font-semibold">Category: <?= htmlspecialchars($category) ?></div>
                <div class="divide-y">
                    <?php foreach ($list as $o): $totalAmount += (float)$o['total_amount']; ?>
                        <div class="px-4 py-2 flex items-center justify-between">
                            <div>
                                <div class="font-medium">Order #<?= (int)$o['id'] ?> (Client #<?= (int)$o['client_id'] ?>)</div>
                                <div class="text-sm text-gray-500">Status: <span class="uppercase"><?= htmlspecialchars($o['status']) ?></span> • ₹<?= number_format((float)$o['total_amount'], 2) ?></div>
                            </div>
                            <form method="post" action="/admin/order-status" class="flex items-center gap-2">
                                <input type="hidden" name="order_id" value="<?= (int)$o['id'] ?>" />
                                <select name="status" class="border rounded px-2 py-1">
                                    <?php foreach (['pending','delivered','paid','due_requested'] as $st): ?>
                                        <option value="<?= $st ?>" <?= $o['status']===$st?'selected':'' ?>><?= $st ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button class="bg-green-600 text-white px-3 py-1 rounded">Update</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="px-4 py-2 bg-gray-50 flex items-center justify-between">
                    <div>Total amount</div>
                    <div class="font-semibold">₹<?= number_format($totalAmount, 2) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

