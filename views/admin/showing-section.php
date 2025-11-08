<?php /** @var AdminViewModel $viewModel */ ?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <h3 class="text-2xl font-semibold">Showings</h3>
    <button onclick="openModal('showingModal')" class="px-3 py-2 rounded border border-[#FE04FF] text-[#FE04FF] hover:bg-[#FE04FF]/10 transition text-sm flex items-center gap-1">
    <i data-feather="plus" class="w-4 h-4"></i> Add Showing
    </button>
</div>
<div class="overflow-auto rounded-lg border border-gray-800">
    <table class="min-w-full text-sm">
    <thead class="bg-[#0f0f10] text-gray-300 text-left">
        <tr>
        <th class="px-4 py-3">Showing ID</th>
        <th class="px-4 py-3">Movie</th>
        <th class="px-4 py-3">Date</th>
        <th class="px-4 py-3">Start Time</th>
        <th class="px-4 py-3">Type</th>
        <th class="px-4 py-3">Price</th>
        <th class="px-4 py-3">Hall</th>
        <th class="px-4 py-3">Actions</th>
        </tr>
    </thead>
    <tbody class="bg-black divide-y divide-gray-900 text-gray-200">
        <?php /** @var Showing $showing */ foreach($viewModel->getShowings() as $showing): ?>
            <tr class="hover:bg-white/5">
                <td class="px-4 py-3" data-form-field="id"><?php echo safeString($showing->getShowingId()); ?></td>
                <td class="px-4 py-3"><?php echo safeString($showing->getMovie()->getTitle()); ?><span class="hidden" data-form-field="movie"><?php echo safeString($showing->getMovie()->getMovieID()); ?></span></td>
                <td class="px-4 py-3" data-form-field="date"><?php echo safeString($showing->getDate()->format("Y-m-d")); ?></td>
                <td class="px-4 py-3" data-form-field="startTime"><?php echo safeString($showing->getDate()->format("H:i")); ?></td>
                <td class="px-4 py-3" data-form-field="type"><?php echo safeString($showing->getType()); ?></td>
                <td class="px-4 py-3"><span data-form-field="price"><?php echo safeString($showing->getPrice()); ?></span> DKK</td>
                <td class="px-4 py-3"><?php echo safeString($showing->getHall()); ?><span class="hidden" data-form-field="hall"><?php echo safeString($showing->getHall()->getHallID()); ?></span></td>
                <td class="px-4 py-3 flex gap-3">
                    <button onclick="openModal('showingModal', this)" class="text-[#FE04FF] hover:opacity-80"><i data-feather="edit-2"></i></button>
                    <button onclick="confirmDelete('showing', <?php echo safeString($showing->getShowingId()); ?>)" class="text-red-500 hover:opacity-80"><i data-feather="trash-2"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div>

  <!-- Showing Modal -->
  <div id="showingModal" class="hidden fixed inset-0 bg-black/80 items-center justify-center z-50 p-4">
    <div class="bg-[#1a1a1a] p-6 rounded-lg w-full max-w-2xl text-white relative">
      <button onclick="closeModal('showingModal')" class="btn-close absolute top-3 right-3 text-gray-400 hover:text-white" data-target="modal-showing"><i data-feather="x"></i></button>
      <h3 class="text-2xl font-semibold mb-4 text-[#FE04FF]" id="showing-modal-title">Edit Showing</h3>
      <form id="form-showing" method="post" action="<?php echo generateUrl("admin-save-showing") ?>" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <input type="hidden" name="id"/>
        <div>
          <label class="block text-sm text-gray-400 mb-1">Movie</label>
            <select name="movie" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]">
                <?php 
                $movies = $viewModel->getMovies();
                usort($movies, function($a, $b) {
                    return strcasecmp($a->getTitle(), $b->getTitle());
                });
                foreach ($movies as $movie): 
                ?>
                  <option value="<?php echo $movie->getMovieID() ?>"><?php echo htmlspecialchars($movie->getTitle()) ?></option>
                <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="block text-sm text-gray-400 mb-1">Type</label>
          <select name="type" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]">
            <option>Baby Bio</option>
            <option>Evening</option>
            <option>Matinee</option>
          </select>
        </div>
        <div>
          <label class="block text-sm text-gray-400 mb-1">Date</label>
          <input name="date" type="date" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"/>
        </div>
        <div>
          <label class="block text-sm text-gray-400 mb-1">Start Time</label>
          <input name="startTime" type="time" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"/>
        </div>
        <div>
          <label class="block text-sm text-gray-400 mb-1">Price (DKK)</label>
          <input name="price" type="number" min="0" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"/>
        </div>
        <div>
          <label class="block text-sm text-gray-400 mb-1">Hall</label>
          <select name="hall" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]">
            <?php foreach ($viewModel->getHalls() as $hall): ?>
              <option value="<?php echo $hall->getHallID() ?>"><?php echo htmlspecialchars($hall->getName()) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="sm:col-span-2 flex justify-end gap-3 mt-2">
          <button onclick="closeModal('showingModal')" type="button" class="btn-close px-4 py-2 rounded bg-gray-700 hover:bg-gray-600" data-target="modal-showing">Cancel</button>
          <button type="submit" class="px-4 py-2 rounded bg-[#FE04FF] text-white hover:opacity-90">Save</button>
        </div>
      </form>
    </div>
  </div>

    <!-- <div id="showingModal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-50">
    <div class="bg-[#1a1a1a] p-6 rounded-lg w-full max-w-2xl text-white relative">
      <button onclick="closeModal('showingModal')" class="absolute top-3 right-3 text-gray-400 hover:text-white"><i data-feather="x"></i></button>
      <h3 class="text-2xl font-semibold mb-4 text-[#FE04FF]">Edit Showing</h3>
      <p class="text-gray-300 text-sm mb-6">Here admin can edit showing data (mock demo).</p>
      <div class="flex justify-end gap-3">
        <button onclick="closeModal('showingModal')" class="px-4 py-2 rounded bg-gray-700 hover:bg-gray-600">Cancel</button>
        <button class="px-4 py-2 rounded bg-[#FE04FF] text-white hover:opacity-90">Save</button>
      </div>
    </div>
  </div> -->