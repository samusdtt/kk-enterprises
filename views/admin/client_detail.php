<div class="space-y-4">
    <h2 class="text-xl font-semibold">Client: <?= htmlspecialchars($user['name'] ?: $user['username']) ?></h2>
    <div class="bg-white p-4 rounded shadow">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
            <div><span class="text-gray-500">Username:</span> <?= htmlspecialchars($user['username']) ?></div>
            <div><span class="text-gray-500">Email:</span> <?= htmlspecialchars($user['email']) ?></div>
            <div class="sm:col-span-2"><span class="text-gray-500">Address:</span> <?= nl2br(htmlspecialchars($user['address'])) ?></div>
        </div>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-600">
                    <th class="py-2 px-3">Order</th>
                    <th class="py-2 px-3">Date</th>
                    <th class="py-2 px-3">Category</th>
                    <th class="py-2 px-3">Status</th>
                    <th class="py-2 px-3">Amount</th>
                    <th class="py-2 px-3">Invoice</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                    <tr class="border-t">
                        <td class="py-2 px-3">#<?= (int)$o['id'] ?></td>
                        <td class="py-2 px-3"><?= htmlspecialchars($o['created_at']) ?></td>
                        <td class="py-2 px-3"><?= htmlspecialchars($o['category']) ?></td>
                        <td class="py-2 px-3 uppercase"><?= htmlspecialchars($o['status']) ?></td>
                        <td class="py-2 px-3">₹<?= number_format((float)$o['total_amount'], 2) ?></td>
                        <td class="py-2 px-3"><a href="/client/invoice?id=<?= (int)$o['id'] ?>" class="text-blue-600" target="_blank">Open</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

