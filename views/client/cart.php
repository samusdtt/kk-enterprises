<div class="bg-white p-4 rounded shadow">
    <h2 class="font-semibold mb-3">Your Cart</h2>
    <?php if (empty($items)): ?>
        <div class="text-gray-500">Cart is empty.</div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-600">
                        <th class="py-2">Product</th>
                        <th class="py-2">Qty</th>
                        <th class="py-2">Price</th>
                        <th class="py-2">Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $entry): ?>
                        <tr class="border-t">
                            <td class="py-2"><?= htmlspecialchars($entry['product']['name']) ?></td>
                            <td class="py-2">
                                <form method="post" action="/client/cart/update" class="flex items-center gap-2">
                                    <input type="hidden" name="product_id" value="<?= (int)$entry['product']['id'] ?>" />
                                    <input type="number" min="0" name="quantity" value="<?= (int)$entry['quantity'] ?>" class="w-20 border rounded px-2 py-1">
                                    <button class="text-blue-600">Update</button>
                                </form>
                            </td>
                            <td class="py-2">₹<?= number_format((float)$entry['product']['price'], 2) ?></td>
                            <td class="py-2">₹<?= number_format((float)$entry['line_total'], 2) ?></td>
                            <td class="py-2">
                                <form method="post" action="/client/cart/remove">
                                    <input type="hidden" name="product_id" value="<?= (int)$entry['product']['id'] ?>" />
                                    <button class="text-red-600">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex items-center justify-between">
            <div class="font-medium">Total: ₹<?= number_format((float)$total, 2) ?></div>
            <a href="/client/order" class="bg-green-600 text-white px-4 py-2 rounded">Proceed to Order</a>
        </div>
    <?php endif; ?>
</div>

