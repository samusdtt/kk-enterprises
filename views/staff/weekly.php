<div class="space-y-4">
    <h2 class="text-xl font-semibold">Weekly Delivery Record</h2>
    <?php if (empty($logs)): ?>
        <div class="bg-white p-4 rounded shadow text-gray-500">No records.</div>
    <?php else: ?>
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-600">
                        <th class="py-2 px-3">Date</th>
                        <th class="py-2 px-3">Order</th>
                        <th class="py-2 px-3">Amount</th>
                        <th class="py-2 px-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $row): ?>
                        <tr class="border-t">
                            <td class="py-2 px-3"><?= htmlspecialchars($row['delivered_at']) ?></td>
                            <td class="py-2 px-3">#<?= (int)$row['order_id'] ?></td>
                            <td class="py-2 px-3">₹<?= number_format((float)$row['total_amount'], 2) ?></td>
                            <td class="py-2 px-3 uppercase"><?= htmlspecialchars($row['status']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

