<?php /** @var AdminViewModel $viewModel */ ?>
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