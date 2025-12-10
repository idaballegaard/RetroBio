<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
  <h3 class="text-2xl font-semibold">Movies</h3>
  <button onclick="openModal('movieModal')" class="px-3 py-2 rounded border border-[#FE04FF] text-[#FE04FF] hover:bg-[#FE04FF]/10 transition text-sm flex items-center gap-1">
    <i data-feather="plus" class="w-4 h-4"></i> Add Movie
  </button>
</div>
<div class="overflow-auto rounded-lg border border-gray-800">
  <table class="min-w-full text-sm">
    <thead class="bg-[#0f0f10] text-gray-300 text-left">
      <tr>
        <th class="px-4 py-3">MovieID</th>
        <th class="px-4 py-3">Title</th>
        <th class="px-4 py-3">Description</th>
        <th class="px-4 py-3">Genre</th>
        <th class="px-4 py-3">Release Year</th>
        <th class="px-4 py-3">Length</th>
        <th class="px-4 py-3">Language</th>
        <th class="px-4 py-3">Age Limit</th>
        <th class="px-4 py-3">Ranking</th>
        <th class="px-4 py-3">Company</th>
        <th class="px-4 py-3">Director</th>
        <th class="px-4 py-3">Main Cast</th>
        <th class="px-4 py-3">Actions</th>
      </tr>
    </thead>
    <tbody class="bg-black divide-y divide-gray-900 text-gray-200">
      <?php /** @var MovieDetails $movie */ foreach ($viewModel->getMovies() as $movie): ?>
        <tr class="hover:bg-white/5">
          <td class="px-4 py-3" data-form-field="id"><?php echo safeString($movie->getMovieID()); ?></td>
          <td class="px-4 py-3" data-form-field="title"><?php echo safeString($movie->getTitle()); ?></td>
          <td class="px-4 py-3" data-form-field="description"><?php echo safeString($movie->getDescription()); ?></td>
          <td class="px-4 py-3" data-form-field="genre"><?php echo safeString($movie->getGenres()); ?></td>
          <td class="px-4 py-3" data-form-field="releaseYear"><?php echo safeString($movie->getReleaseYear()); ?></td>
          <td class="px-4 py-3" data-form-field="length"><?php echo safeString($movie->getLength()); ?></td>
          <td class="px-4 py-3" data-form-field="language"><?php echo safeString($movie->getLanguage()); ?></td>
          <td class="px-4 py-3" data-form-field="ageLimit"><?php echo safeString($movie->getAgeLimit()); ?></td>
          <td class="px-4 py-3" data-form-field="ranking"><?php echo safeString($movie->getRanking()); ?></td>
          <td class="px-4 py-3" data-form-field="company"><?php echo safeString($movie->getCompany()); ?></td>
          <td class="px-4 py-3" data-form-field="director"><?php echo safeString($movie->getDirector()); ?></td>
          <td class="px-4 py-3" data-form-field="cast"><?php echo safeString($movie->getActors()); ?></td>
          <td class="px-4 py-3 flex gap-3">
            <button onclick="openModal('movieModal', this)" class="text-[#FE04FF] hover:opacity-80"><i data-feather="edit-2"></i></button>
            <button onclick="confirmDelete('movie', <?php echo safeString($movie->getMovieID()); ?>)" class="text-red-500 hover:opacity-80"><i data-feather="trash-2"></i></button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<div id="movieModal" class="hidden fixed inset-0 bg-black/80 items-center justify-center z-50 p-4">
  <div class="modal-box bg-[#1a1a1a] p-6 rounded-lg w-full max-w-2xl text-white relative">
    <button onclick="closeModal('movieModal')" class="btn-close absolute top-3 right-3 text-gray-400 hover:text-white" data-target="modal-movie"><i data-feather="x"></i></button>
    <h3 class="text-2xl font-semibold mb-4 text-[#FE04FF]" id="movie-modal-title">Edit Movie</h3>
    <form enctype="multipart/form-data" id="form-movie" class="grid grid-cols-1 sm:grid-cols-2 gap-4" method="POST" action="<?php echo generateUrl('admin-save-movie'); ?>">
      <input type="hidden" name="id" />
      <div>
        <label class="block text-sm text-gray-400 mb-1">Title</label>
        <input name="title" type="text" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]" />
      </div>
      <div>
        <label class="block text-sm text-gray-400 mb-1">Genre (comma separated)</label>
        <input name="genre" type="text" placeholder="Crime, Drama" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]" />
      </div>
      <div class="sm:col-span-2">
        <label class="block text-sm text-gray-400 mb-1">Main Cast (comma separated)</label>
        <input name="cast" type="text" placeholder="A. Holm, K. Sørensen" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]" />
      </div>
      <div class="sm:col-span-10">

          <label class="block text-sm text-gray-400 mb-1">Poster</label>
          <input name="poster" type="file" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]">

        <label class="block text-sm text-gray-400 mb-1 mt-4">Description</label>
        <textarea name="description" rows="4" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"></textarea>

        <label class="block text-sm text-gray-400 mb-1 mt-4">Director</label>
        <input name="director" type="text" placeholder="D. Nielsen" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]" />

        <label class="block text-sm text-gray-400 mb-1 mt-4">Release Year</label>
        <input name="releaseYear" type="number" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]" />

        <label class="block text-sm text-gray-400 mb-1 mt-4">Length (minutes)</label>
        <input name="length" type="number" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]" />

        <label class="block text-sm text-gray-400 mb-1 mt-4">Language</label>
        <input name="language" type="text" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]" />

        <label class="block text-sm text-gray-400 mb-1 mt-4">Ranking</label>
        <input name="ranking" type="text" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]" />

        <label class="block text-sm text-gray-400 mb-1 mt-4">Company</label>
        <input name="company" type="text" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]" />

        <label class="block text-sm text-gray-400 mb-1 mt-4">Age Limit</label>
        <input name="ageLimit" type="number" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]" />
      </div>
      <div class="sm:col-span-2 flex justify-end gap-3 mt-2">
        <button onclick="closeModal('movieModal')" type="button" class="btn-close px-4 py-2 rounded bg-gray-700 hover:bg-gray-600" data-target="modal-movie">Cancel</button>
        <button type="submit" class="px-4 py-2 rounded bg-[#FE04FF] text-white hover:opacity-90">Save</button>
      </div>
    </form>
  </div>
</div>
<!-- <div id="movieModal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-50">
    <div class="bg-[#1a1a1a] p-6 rounded-lg w-full max-w-2xl text-white relative">
      <button onclick="closeModal('movieModal')" class="absolute top-3 right-3 text-gray-400 hover:text-white"><i data-feather="x"></i></button>
      <h3 class="text-2xl font-semibold mb-4 text-[#FE04FF]">Edit Movie</h3>
      <p class="text-gray-300 text-sm mb-6">Here admin can edit movie data (mock demo).</p>
      <div class="flex justify-end gap-3">
        <button onclick="closeModal('movieModal')" class="px-4 py-2 rounded bg-gray-700 hover:bg-gray-600">Cancel</button>
        <button class="px-4 py-2 rounded bg-[#FE04FF] text-white hover:opacity-90">Save</button>
      </div>
    </div>
  </div> -->