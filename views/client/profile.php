<div class="grid gap-6 md:grid-cols-2">
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-3">Profile</h2>
        <form method="post" action="/client/profile" class="space-y-3">
            <div>
                <label class="block text-sm">Username (read-only)</label>
                <input value="<?= htmlspecialchars($user['username']) ?>" class="mt-1 w-full border rounded px-3 py-2 bg-gray-100" readonly />
            </div>
            <div>
                <label class="block text-sm">Name</label>
                <input name="name" value="<?= htmlspecialchars($user['name']) ?>" class="mt-1 w-full border rounded px-3 py-2" />
            </div>
            <div>
                <label class="block text-sm">Email</label>
                <input name="email" value="<?= htmlspecialchars($user['email']) ?>" class="mt-1 w-full border rounded px-3 py-2" />
            </div>
            <div>
                <label class="block text-sm">Address</label>
                <textarea name="address" class="mt-1 w-full border rounded px-3 py-2"><?= htmlspecialchars($user['address']) ?></textarea>
            </div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-3">Change Password</h2>
        <form method="post" action="/client/change-password" class="space-y-3">
            <div>
                <label class="block text-sm">New Password</label>
                <input type="password" name="new_password" class="mt-1 w-full border rounded px-3 py-2" required />
            </div>
            <button class="bg-green-600 text-white px-4 py-2 rounded">Update Password</button>
        </form>
    </div>
</div>

