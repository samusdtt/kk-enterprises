<div class="grid gap-6 md:grid-cols-3">
    <div class="md:col-span-2 bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-3">Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <?php foreach ($products as $p): ?>
                <div class="border rounded p-3 flex items-center justify-between">
                    <div>
                        <div class="font-medium"><?= htmlspecialchars($p['name']) ?></div>
                        <div class="text-sm text-gray-500">₹<?= number_format((float)$p['price'], 2) ?></div>
                    </div>
                    <form method="post" action="/client/cart/add" class="flex items-center gap-2">
                        <input type="hidden" name="product_id" value="<?= (int)$p['id'] ?>" />
                        <input type="number" min="1" value="1" name="quantity" class="w-20 border rounded px-2 py-1" />
                        <button class="bg-blue-600 text-white px-3 py-1 rounded">Add</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-3">Place Order</h2>
        <form method="post" action="/client/order" class="space-y-3">
            <div>
                <label class="block text-sm font-medium">Category</label>
                <select name="category" class="mt-1 w-full border rounded px-2 py-2">
                    <option>Mall</option>
                    <option selected>Flats</option>
                    <option>Site</option>
                    <option>Store</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Payment Method</label>
                <select name="payment_method" class="mt-1 w-full border rounded px-2 py-2">
                    <option value="cash">Cash</option>
                    <option value="online">Online</option>
                    <option value="due">Request Due</option>
                </select>
            </div>
            <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded">Place Order</button>
        </form>
        <a class="text-blue-600 text-sm" href="/client/cart">View Cart</a>
    </div>
</div>

