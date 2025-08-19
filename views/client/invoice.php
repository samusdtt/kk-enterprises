<div class="bg-white p-6 rounded shadow max-w-2xl mx-auto">
    <div class="flex items-start justify-between">
        <div>
            <h2 class="text-xl font-semibold">Invoice</h2>
            <div class="text-sm text-gray-500">Order #<?= (int)$order['id'] ?> • <?= htmlspecialchars($order['created_at']) ?></div>
        </div>
        <div class="text-right">
            <div class="font-semibold">KK Enterprises</div>
            <div class="text-sm text-gray-500">Water Management</div>
        </div>
    </div>
    <div class="mt-4 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-600">
                    <th class="py-2">Product</th>
                    <th class="py-2">Qty</th>
                    <th class="py-2">Price</th>
                    <th class="py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $grand=0; foreach ($items as $it): $line=(float)$it['price']*(int)$it['quantity']; $grand+=$line; ?>
                    <tr class="border-t">
                        <td class="py-2"><?= htmlspecialchars($it['name']) ?></td>
                        <td class="py-2"><?= (int)$it['quantity'] ?></td>
                        <td class="py-2">₹<?= number_format((float)$it['price'], 2) ?></td>
                        <td class="py-2">₹<?= number_format($line, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4 text-right">
        <div class="text-sm">Payment: <?= htmlspecialchars($order['payment_method']) ?></div>
        <div class="text-lg font-semibold">Total: ₹<?= number_format($grand, 2) ?></div>
    </div>
</div>

