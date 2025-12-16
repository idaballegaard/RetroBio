<?php /** @var AdminViewModel $viewModel */ ?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <h3 class="text-2xl font-semibold">Orders</h3>
</div>
<div class="overflow-auto rounded-lg border border-gray-800">
    <table class="min-w-full text-sm">
        <thead class="bg-[#0f0f10] text-gray-300 text-left">
        <tr>
          <th class="px-4 py-3">Order ID</th>
          <th class="px-4 py-3">User</th>
          <th class="px-4 py-3">Movie</th>
          <th class="px-4 py-3">Date</th>
          <th class="px-4 py-3">Status</th>
          <th class="px-4 py-3">Total</th>
        </tr>
        </thead>
        <tbody class="bg-black divide-y divide-gray-900 text-gray-200">
        <?php /** @var Order $order */
        foreach ($viewModel->getOrders() as $index => $order): ?>
            <tr class="hover:bg-white/5">
                <td class="px-4 py-3"><?php echo safeString($order->getOrderId()) ?></td>
              <td class="px-4 py-3"><?php echo safeString($viewModel->getOrderUsers()[$order->getUserId()]) ?></td>
              <td class="px-4 py-3"><a href="<?php echo generateUrl("booking") ?>?showing_id=<?php echo $order->getShowingId() ?>" style="text-decoration: underline;"><?php echo safeString($viewModel->getOrderMovies()[$order->getShowingId()]) ?></a></td>
              <td class="px-4 py-3"><?php echo safeString($order->getDate()) ?></td>
              <td class="px-4 py-3"><?php echo safeString($order->getStatus()) ?></td>
              <td class="px-4 py-3"><?php echo safeString($order->getPrice()) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>