<div class="space-y-4">
    <h2 class="text-xl font-semibold">Clients</h2>
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-600">
                    <th class="py-2 px-3">Name</th>
                    <th class="py-2 px-3">Username</th>
                    <th class="py-2 px-3">Email</th>
                    <th class="py-2 px-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $c): ?>
                    <tr class="border-t">
                        <td class="py-2 px-3"><?= htmlspecialchars($c['name']) ?></td>
                        <td class="py-2 px-3"><?= htmlspecialchars($c['username']) ?></td>
                        <td class="py-2 px-3"><?= htmlspecialchars($c['email']) ?></td>
                        <td class="py-2 px-3">
                            <a href="/admin/client?id=<?= (int)$c['id'] ?>" class="text-blue-600">Open</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

