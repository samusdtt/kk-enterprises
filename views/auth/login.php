<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-xl font-semibold mb-4">Login</h1>
    <?php if (!empty($error)): ?>
        <div class="bg-red-50 text-red-700 p-3 rounded mb-4"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="/login" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Username</label>
            <input name="username" class="mt-1 w-full border rounded px-3 py-2" required />
        </div>
        <div>
            <label class="block text-sm font-medium">Password</label>
            <input type="password" name="password" class="mt-1 w-full border rounded px-3 py-2" required />
        </div>
        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">Sign in</button>
    </form>
</div>

