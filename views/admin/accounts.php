<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">Daily Accounts (<?= htmlspecialchars($date) ?>)</h2>
        <form method="get" action="/admin/accounts" class="flex items-center gap-2">
            <input type="date" name="date" value="<?= htmlspecialchars($date) ?>" class="border rounded px-2 py-1" />
            <button class="bg-blue-600 text-white px-3 py-1 rounded">Go</button>
        </form>
    </div>
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded shadow p-4">
            <h3 class="font-semibold mb-3">Add Record</h3>
            <form method="post" action="/admin/accounts" class="space-y-3">
                <input type="hidden" name="record_date" value="<?= htmlspecialchars($date) ?>" />
                <div>
                    <label class="block text-sm">Type</label>
                    <select name="type" class="mt-1 w-full border rounded px-2 py-2">
                        <option value="income">Income</option>
                        <option value="expense">Expense</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm">Amount</label>
                    <input type="number" step="0.01" name="amount" class="mt-1 w-full border rounded px-3 py-2" required />
                </div>
                <div>
                    <label class="block text-sm">Notes</label>
                    <textarea name="notes" class="mt-1 w-full border rounded px-3 py-2" placeholder="Optional"></textarea>
                </div>
                <button class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
            </form>
        </div>
        <div class="bg-white rounded shadow p-4 overflow-x-auto">
            <h3 class="font-semibold mb-3">Records</h3>
            <?php $income=0; $expense=0; ?>
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-600">
                        <th class="py-2 px-3">Type</th>
                        <th class="py-2 px-3">Amount</th>
                        <th class="py-2 px-3">Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $r): ?>
                        <?php if ($r['type']==='income') { $income+=(float)$r['amount']; } else { $expense+=(float)$r['amount']; } ?>
                        <tr class="border-t">
                            <td class="py-2 px-3 uppercase"><?= htmlspecialchars($r['type']) ?></td>
                            <td class="py-2 px-3">₹<?= number_format((float)$r['amount'], 2) ?></td>
                            <td class="py-2 px-3 text-gray-600"><?= nl2br(htmlspecialchars($r['notes'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-4 grid grid-cols-2 gap-2 text-sm">
                <div class="p-3 rounded bg-green-50 text-green-800">Income: ₹<?= number_format($income,2) ?></div>
                <div class="p-3 rounded bg-red-50 text-red-800">Expense: ₹<?= number_format($expense,2) ?></div>
                <div class="p-3 rounded bg-blue-50 text-blue-800 col-span-2">Net: ₹<?= number_format($income-$expense,2) ?></div>
            </div>
        </div>
    </div>
</div>

