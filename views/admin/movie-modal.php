  <div id="movieModal" class="hidden fixed inset-0 bg-black/80 items-center justify-center z-50 p-4">
    <div class="bg-[#1a1a1a] p-6 rounded-lg w-full max-w-2xl text-white relative">
      <button onclick="closeModal('movieModal')" class="btn-close absolute top-3 right-3 text-gray-400 hover:text-white" data-target="modal-movie"><i data-feather="x"></i></button>
      <h3 class="text-2xl font-semibold mb-4 text-[#FE04FF]" id="movie-modal-title">Edit Movie</h3>
      <form id="form-movie" class="grid grid-cols-1 sm:grid-cols-2 gap-4" method="POST" action="<?php echo generateUrl('admin-save-movie'); ?>">
        <input type="hidden" name="id"/>
        <div>
          <label class="block text-sm text-gray-400 mb-1">Title</label>
          <input name="title" type="text" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"/>
        </div>
        <div>
          <label class="block text-sm text-gray-400 mb-1">Genre (comma separated)</label>
          <input name="genre" type="text" placeholder="Crime, Drama" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"/>
        </div>
        <div class="sm:col-span-2">
          <label class="block text-sm text-gray-400 mb-1">Main Cast (comma separated)</label>
          <input name="cast" type="text" placeholder="A. Holm, K. Sørensen" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"/>
        </div>
        <div class="sm:col-span-10">
            <label class="block text-sm text-gray-400 mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"></textarea>

            <label class="block text-sm text-gray-400 mb-1 mt-4">Director</label>
            <input name="director" type="text" placeholder="D. Nielsen" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"/>

            <label class="block text-sm text-gray-400 mb-1 mt-4">Release Year</label>
            <input name="releaseYear" type="number" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"/>

            <label class="block text-sm text-gray-400 mb-1 mt-4">Length (minutes)</label>
            <input name="length" type="number" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"/>

            <label class="block text-sm text-gray-400 mb-1 mt-4">Language</label>
            <input name="language" type="text" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"/>

            <label class="block text-sm text-gray-400 mb-1 mt-4">Ranking</label>
            <input name="ranking" type="text" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"/>

            <label class="block text-sm text-gray-400 mb-1 mt-4">Company</label>
            <input name="company" type="text" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"/>

            <label class="block text-sm text-gray-400 mb-1 mt-4">Age Limit</label>
            <input name="ageLimit" type="number" class="w-full p-2 rounded bg-[#0f0f10] border border-gray-700 focus:ring-1 focus:ring-[#FE04FF]"/>
        </div>
        <div class="sm:col-span-2 flex justify-end gap-3 mt-2">
          <button  onclick="closeModal('movieModal')" type="button" class="btn-close px-4 py-2 rounded bg-gray-700 hover:bg-gray-600" data-target="modal-movie">Cancel</button>
          <button type="submit" class="px-4 py-2 rounded bg-[#FE04FF] text-white hover:opacity-90">Save</button>
        </div>
      </form>
    </div>
  </div>