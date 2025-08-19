<div class="space-y-6">
    <h2 class="text-xl font-semibold">Staff Alignment</h2>
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded shadow p-4">
            <h3 class="font-semibold mb-3">Staff</h3>
            <div class="space-y-2">
                <?php foreach ($staff as $s): ?>
                    <div class="flex items-center justify-between border rounded px-3 py-2">
                        <div><?= htmlspecialchars($s['name'] ?: ('Staff #' . $s['id'])) ?></div>
                        <form method="post" action="/admin/login-hours" class="flex items-center gap-2">
                            <input type="hidden" name="staff_id" value="<?= (int)$s['id'] ?>" />
                            <select name="enabled" class="border rounded px-2 py-1">
                                <option value="1">Show Login Hour</option>
                                <option value="0">Hide</option>
                            </select>
                            <button class="bg-blue-600 text-white px-3 py-1 rounded">Save</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h3 class="font-semibold mb-3">Today's Orders</h3>
            <div class="space-y-2">
                <?php foreach ($orders as $o): ?>
                    <div class="flex items-center justify-between border rounded px-3 py-2">
                        <div>
                            <div class="font-medium">#<?= (int)$o['id'] ?> • <?= htmlspecialchars($o['category']) ?></div>
                            <div class="text-sm text-gray-500 uppercase">Status: <?= htmlspecialchars($o['status']) ?></div>
                        </div>
                        <form method="post" action="/admin/assign-staff" class="flex items-center gap-2">
                            <input type="hidden" name="order_id" value="<?= (int)$o['id'] ?>" />
                            <select name="staff_id" class="border rounded px-2 py-1">
                                <?php foreach ($staff as $s): ?>
                                    <option value="<?= (int)$s['id'] ?>"><?= htmlspecialchars($s['name'] ?: ('Staff #' . $s['id'])) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button class="bg-green-600 text-white px-3 py-1 rounded">Assign</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

