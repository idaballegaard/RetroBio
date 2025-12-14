<?php /** @var AdminViewModel $viewModel */ ?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
  <h3 class="text-2xl font-semibold">About</h3>
</div>
<div class="overflow-auto rounded-lg border-none border-gray-800">
  <?php $about = $viewModel->getAbout(); ?>
  <form id="form-about" class="grid grid-cols-1 sm:grid-cols-2 gap-4" method="POST" action="<?php echo generateUrl('admin-save-about'); ?>">
    <div class="sm:col-span-10">
      <label class="block text-sm text-gray-400 mb-1">Title</label>
      <input name="title" type="text" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]" value="<?php echo safeString($about['title']); ?>" />

      <label class="block text-sm text-gray-400 mb-1 mt-4">Subtitle</label>
      <input name="subtitle" type="text" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]" value="<?php echo safeString($about['subtitle']); ?>" />

      <label class="block text-sm text-gray-400 mb-1 mt-4">Description</label>
      <textarea name="description" rows="4" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"><?php echo safeString($about['description']) ?></textarea>

      <label class="block text-sm text-gray-400 mb-1 mt-4">Address</label>
      <input name="address" type="text" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]" value="<?php echo safeString($about['address']); ?>" />

      <label class="block text-sm text-gray-400 mb-1 mt-4">Opening hours</label>
      <input name="openingHours" type="text" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]" value="<?php echo safeString($about['openingHours']); ?>" />

      <label class="block text-sm text-gray-400 mb-1 mt-4">Email</label>
      <input name="email" type="email" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]" value="<?php echo safeString($about['email']); ?>" />

      <label class="block text-sm text-gray-400 mb-1 mt-4">Phone</label>
      <input name="phone" type="tel" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]" value="<?php echo safeString($about['phone']); ?>" />

    </div>
    <div class="sm:col-span-10 flex justify-end mt-2 mb-4">
      <button type="submit" class="px-4 py-2 rounded bg-[#FE04FF] text-white hover:opacity-90 w-full">Save</button>
    </div>
  </form>
</div>