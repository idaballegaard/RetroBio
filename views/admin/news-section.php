<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <h3 class="text-2xl font-semibold">News</h3>
    <button onclick="openModal('newsModal')" class="px-3 py-2 rounded border border-[#FE04FF] text-[#FE04FF] hover:bg-[#FE04FF]/10 transition text-sm flex items-center gap-1">
    <i data-feather="plus" class="w-4 h-4"></i> Add News
    </button>
</div>
<div class="overflow-auto rounded-lg border border-gray-800">
    <table class="min-w-full text-sm">
    <thead class="bg-[#0f0f10] text-gray-300 text-left">
        <tr>
        <th class="px-4 py-3">News ID</th>
        <th class="px-4 py-3">Title</th>
        <th class="px-4 py-3">Description</th>
        <th class="px-4 py-3">Release Date</th>
        <th class="px-4 py-3">Actions</th>
        </tr>
    </thead>
    <tbody class="bg-black divide-y divide-gray-900 text-gray-200">
        <?php /** @var News $news */ foreach($viewModel->getNews() as $index => $news): ?>
            <tr class="hover:bg-white/5">
                <td class="px-4 py-3" data-form-field="id"><?php echo safeString($news->getNewsID()); ?></td>
                <td class="px-4 py-3" data-form-field="title"><?php echo safeString($news->getTitle()) ?></td>
                <td class="px-4 py-3" data-form-field="description"><?php echo safeString($news->getDescription()) ?></td>
                <td class="px-4 py-3"><?php echo safeString($news->getReleaseDate()->format("d.m.Y")) ?><span class="hidden" data-form-field="releaseDate"><?php echo safeString($news->getReleaseDate()->format("Y-m-d")) ?></span></td>
                <td class="px-4 py-3 flex gap-3">
                    <button onclick="openModal('newsModal', this)" class="text-[#FE04FF] hover:opacity-80"><i data-feather="edit-2"></i></button>
                    <button onclick="confirmDelete('news', <?php echo safeString($news->getNewsID()); ?>)" class="text-red-500 hover:opacity-80"><i data-feather="trash-2"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div>

  <div id="newsModal" class="hidden fixed inset-0 bg-black/80 items-center justify-center z-50 p-4">
    <div class="bg-[#1a1a1a] p-6 rounded-lg w-full max-w-2xl text-white relative">
      <button onclick="closeModal('newsModal')" class="btn-close absolute top-3 right-3 text-gray-400 hover:text-white"><i data-feather="x"></i></button>
      <h3 class="text-2xl font-semibold mb-4 text-[#FE04FF]" id="news-modal-title">Edit News</h3>
      <form id="form-news" method="POST" action="<?php echo generateUrl('admin-save-news'); ?>" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <input type="hidden" name="id"/>
        <div class="sm:col-span-2">
          <label class="block text-sm text-gray-400 mb-1">Title</label>
          <input name="title" type="text" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"/>
        </div>
        <div class="sm:col-span-2">
          <label class="block text-sm text-gray-400 mb-1">Description</label>
          <textarea name="description" rows="4" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"></textarea>
        </div>
        <div>
          <label class="block text-sm text-gray-400 mb-1">Release Date</label>
          <input name="releaseDate" type="date" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"/>
        </div>
        <div class="sm:col-span-2 flex justify-end gap-3 mt-2">
          <button onclick="closeModal('newsModal')" type="button" class="btn-close px-4 py-2 rounded bg-gray-700 hover:bg-gray-600" data-target="modal-news">Cancel</button>
          <button type="submit" class="px-4 py-2 rounded bg-[#FE04FF] text-white hover:opacity-90">Save</button>
        </div>
      </form>
    </div>
  </div>

<!-- <div id="newsModal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-50">
    <div class="bg-[#1a1a1a] p-6 rounded-lg w-full max-w-2xl text-white relative">
        <button onclick="closeModal('newsModal')" class="absolute top-3 right-3 text-gray-400 hover:text-white"><i data-feather="x"></i></button>
        <h3 class="text-2xl font-semibold mb-4 text-[#FE04FF]">Edit News</h3>
        <p class="text-gray-300 text-sm mb-6">Here admin can edit news data (mock demo).</p>
        <div class="flex justify-end gap-3">
        <button onclick="closeModal('newsModal')" class="px-4 py-2 rounded bg-gray-700 hover:bg-gray-600">Cancel</button>
        <button class="px-4 py-2 rounded bg-[#FE04FF] text-white hover:opacity-90">Save</button>
        </div>
    </div>
</div> -->