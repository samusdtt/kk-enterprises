<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">Daily Jar Record (<?= htmlspecialchars($date) ?>)</h2>
        <form method="get" action="/admin/jars" class="flex items-center gap-2">
            <input type="date" name="date" value="<?= htmlspecialchars($date) ?>" class="border rounded px-2 py-1" />
            <button class="bg-blue-600 text-white px-3 py-1 rounded">Go</button>
        </form>
    </div>
    <div class="bg-white rounded shadow p-4 max-w-md">
        <form method="post" action="/admin/jars" class="space-y-3">
            <input type="hidden" name="record_date" value="<?= htmlspecialchars($date) ?>" />
            <div>
                <label class="block text-sm">Total Jars</label>
                <input type="number" name="total_jars" value="<?= (int)($record['total_jars'] ?? 0) ?>" class="mt-1 w-full border rounded px-3 py-2" />
            </div>
            <div>
                <label class="block text-sm">Refilling</label>
                <input type="number" name="refilling" value="<?= (int)($record['refilling'] ?? 0) ?>" class="mt-1 w-full border rounded px-3 py-2" />
            </div>
            <div>
                <label class="block text-sm">Empty</label>
                <input type="number" name="empty" value="<?= (int)($record['empty'] ?? 0) ?>" class="mt-1 w-full border rounded px-3 py-2" />
            </div>
            <div>
                <label class="block text-sm">Onboard</label>
                <input type="number" name="onboard" value="<?= (int)($record['onboard'] ?? 0) ?>" class="mt-1 w-full border rounded px-3 py-2" />
            </div>
            <button class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</div>

