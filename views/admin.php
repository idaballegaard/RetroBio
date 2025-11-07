<?php /** @var AdminViewModel $viewModel */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RetroBio Admin Panel</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-black text-white font-sans min-h-screen">
  <!-- Hero Section -->
  <header class="bg-black text-center py-8">
    <h1 class="text-4xl font-bold text-[#FE04FF]">RetroBio Admin Panel</h1>
    <p class="text-gray-300 text-lg mt-2">Access and manage all cinema data efficiently and professionally.</p>
  </header>

  <!-- Navigation Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-6 pt-0">
    <div onclick="showSection('movies')" class="bg-[#eaf0ff] p-6 rounded shadow hover:shadow-xl hover:scale-105 transition cursor-pointer">
      <div class="flex items-center mb-3">
        <i data-feather="film" class="w-8 h-8 text-[#FE04FF] mr-3"></i>
        <h2 class="text-xl font-semibold text-black">Movies</h2>
      </div>
      <p class="text-sm text-gray-700">Manage movie data such as titles, descriptions, posters, and more.</p>
    </div>

    <div onclick="showSection('showings')" class="bg-[#eaf0ff] p-6 rounded shadow hover:shadow-xl hover:scale-105 transition cursor-pointer">
      <div class="flex items-center mb-3">
        <i data-feather="clock" class="w-8 h-8 text-[#FE04FF] mr-3"></i>
        <h2 class="text-xl font-semibold text-black">Showings</h2>
      </div>
      <p class="text-sm text-gray-700">Edit show times, dates, linked movies, and scheduling information.</p>
    </div>

    <div onclick="showSection('news')" class="bg-[#eaf0ff] p-6 rounded shadow hover:shadow-xl hover:scale-105 transition cursor-pointer">
      <div class="flex items-center mb-3">
        <i data-feather="file-text" class="w-8 h-8 text-[#FE04FF] mr-3"></i>
        <h2 class="text-xl font-semibold text-black">News</h2>
      </div>
      <p class="text-sm text-gray-700">Create and update announcements displayed on the homepage.</p>
    </div>

    <div onclick="showSection('about')" class="bg-[#eaf0ff] p-6 rounded shadow hover:shadow-xl hover:scale-105 transition cursor-pointer">
      <div class="flex items-center mb-3">
        <i data-feather="info" class="w-8 h-8 text-[#FE04FF] mr-3"></i>
        <h2 class="text-xl font-semibold text-black">About</h2>
      </div>
      <p class="text-sm text-gray-700">Update biography information, contact details, and opening hours.</p>
    </div>
  </div>

  <!-- Movies Section -->
  <section id="movies" class="hidden mt-8 px-6">
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
          <?php /** @var Movie $movie */ foreach($viewModel->getMovies() as $index => $movie): ?>
            <tr class="hover:bg-white/5">
              <td class="px-4 py-3" data-form-field="id"><?php echo safeString($movie->getMovieID()); ?></td>
              <td class="px-4 py-3" data-form-field="title"><?php echo safeString($movie->getTitle()); ?></td>
              <td class="px-4 py-3" data-form-field="description"><?php echo safeString($movie->getDescription()); ?></td>
              <td class="px-4 py-3" data-form-field="genre"><?php echo safeString(implode(", ", $movie->getGenres())); ?></td>
              <td class="px-4 py-3" data-form-field="releaseYear"><?php echo safeString($movie->getReleaseYear()); ?></td>
              <td class="px-4 py-3" data-form-field="length"><?php echo safeString($movie->getLength()); ?></td>
              <td class="px-4 py-3" data-form-field="language"><?php echo safeString($movie->getLanguage()); ?></td>
              <td class="px-4 py-3" data-form-field="ageLimit"><?php echo safeString($movie->getAgeLimit()); ?></td>
              <td class="px-4 py-3" data-form-field="ranking"><?php echo safeString($movie->getRanking()); ?></td>
              <td class="px-4 py-3" data-form-field="company"><?php echo safeString($movie->getCompany()); ?></td>
              <td class="px-4 py-3" data-form-field="director"><?php echo safeString($movie->getDirector()); ?></td>
              <td class="px-4 py-3" data-form-field="cast"><?php echo safeString(implode(", ", $movie->getActors())); ?></td>
              <td class="px-4 py-3 flex gap-3">
                <button onclick="openModal('movieModal', this)" class="text-[#FE04FF] hover:opacity-80"><i data-feather="edit-2"></i></button>
                <button onclick="confirmDelete('movie', <?php echo safeString($movie->getMovieID()); ?>)" class="text-red-500 hover:opacity-80"><i data-feather="trash-2"></i></button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

  <!-- Showings Section -->
  <section id="showings" class="hidden mt-8 px-6">
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
  </section>

  <!-- News Section -->
  <section id="news" class="hidden mt-8 px-6">
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
                    <td class="px-4 py-3"><?php echo safeString($news->getNewsID()); ?></td>
                    <td class="px-4 py-3"><?php echo safeString($news->getTitle()) ?></td>
                    <td class="px-4 py-3"><?php echo safeString($news->getDescription()) ?></td>
                    <td class="px-4 py-3"><?php echo safeString($news->getReleaseDate()->format("d/m/Y")) ?></td>
                    <td class="px-4 py-3 flex gap-3">
                        <button onclick="openModal('newsModal')" class="text-[#FE04FF] hover:opacity-80"><i data-feather="edit-2"></i></button>
                        <button onclick="openModal('deleteModal')" class="text-red-500 hover:opacity-80"><i data-feather="trash-2"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="hidden mt-8 px-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
      <h3 class="text-2xl font-semibold">About</h3>
    </div>
    <div class="overflow-auto rounded-lg border border-gray-800">
      <table class="min-w-full text-sm">
        <thead class="bg-[#0f0f10] text-gray-300 text-left">
          <tr>
            <th class="px-4 py-3">About ID</th>
            <th class="px-4 py-3">Title</th>
            <th class="px-4 py-3">Subtitle</th>
            <th class="px-4 py-3">Email</th>
            <th class="px-4 py-3">Phone</th>
            <th class="px-4 py-3">Opening Hours</th>
            <th class="px-4 py-3">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-black divide-y divide-gray-900 text-gray-200">
          <tr class="hover:bg-white/5 align-top">
            <?php $about = $viewModel->getAbout(); ?>
            <?php if ($about): ?>
            <td class="px-4 py-3"><?php echo safeString($about->getAboutId()); ?></td>
            <td class="px-4 py-3"><?php echo safeString($about->getTitle()); ?></td>
            <td class="px-4 py-3"><?php echo safeString($about->getSubtitle()); ?></td>
            <td class="px-4 py-3"><?php echo safeString($about->getEmail()); ?></td>
            <td class="px-4 py-3"><?php echo safeString($about->getPhone()); ?></td>
            <!-- <td class="px-4 py-3 whitespace-pre-line text-gray-300 leading-tight">
              Mon–Thu:<?php //echo safeString($about->getOpeningHoursMonThu()); ?><br>
              Fri:<?php //echo safeString($about->getOpeningHoursFri()); ?><br>
              Sat:<?php //echo safeString($about->getOpeningHoursSat()); ?><br>
              Sun:<?php //echo safeString($about->getOpeningHoursSun()); ?>
            </td> -->
            <td class="px-4 py-3 flex gap-3">
              <button onclick="openModal('aboutModal')" class="text-[#FE04FF] hover:opacity-80"><i data-feather="edit-2"></i></button>
              <button onclick="openModal('deleteModal')" class="text-red-500 hover:opacity-80"><i data-feather="trash-2"></i></button>
            </td>
            <?php endif; ?>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <!-- Modals -->
   <?php require __DIR__ . "/admin/movie-modal.php"; ?>
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

  <?php require __DIR__ . "/admin/showing-modal.php"; ?>
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

  <div id="newsModal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-50">
    <div class="bg-[#1a1a1a] p-6 rounded-lg w-full max-w-2xl text-white relative">
      <button onclick="closeModal('newsModal')" class="absolute top-3 right-3 text-gray-400 hover:text-white"><i data-feather="x"></i></button>
      <h3 class="text-2xl font-semibold mb-4 text-[#FE04FF]">Edit News</h3>
      <p class="text-gray-300 text-sm mb-6">Here admin can edit news data (mock demo).</p>
      <div class="flex justify-end gap-3">
        <button onclick="closeModal('newsModal')" class="px-4 py-2 rounded bg-gray-700 hover:bg-gray-600">Cancel</button>
        <button class="px-4 py-2 rounded bg-[#FE04FF] text-white hover:opacity-90">Save</button>
      </div>
    </div>
  </div>

  <div id="aboutModal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-50">
    <div class="bg-[#1a1a1a] p-6 rounded-lg w-full max-w-2xl text-white relative">
      <button onclick="closeModal('aboutModal')" class="absolute top-3 right-3 text-gray-400 hover:text-white"><i data-feather="x"></i></button>
      <h3 class="text-2xl font-semibold mb-4 text-[#FE04FF]">Edit About</h3>
      <p class="text-gray-300 text-sm mb-6">Here admin can edit about information (mock demo).</p>
      <div class="flex justify-end gap-3">
        <button onclick="closeModal('aboutModal')" class="px-4 py-2 rounded bg-gray-700 hover:bg-gray-600">Cancel</button>
        <button class="px-4 py-2 rounded bg-[#FE04FF] text-white hover:opacity-90">Save</button>
      </div>
    </div>
  </div>

    <div id="deleteModal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-50">
    <div class="bg-[#1a1a1a] p-6 rounded-lg w-full max-w-md text-white text-center">
      <h3 class="text-xl font-semibold text-red-500 mb-4">Confirm Deletion</h3>
      <p class="text-gray-300 mb-6">Are you sure you want to delete this item?</p>
      <div class="flex justify-center gap-3">
        <button onclick="closeModal('deleteModal')" class="px-4 py-2 rounded bg-gray-700 hover:bg-gray-600">Cancel</button>
        <a href="#" data-delete-type="" data-delete-id="" class="px-4 py-2 rounded bg-red-600 hover:bg-red-700">Delete</a>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    feather.replace();

    // Viser én sektion ad gangen
    function showSection(sectionId) {
      document.querySelectorAll('section').forEach((section) => section.classList.add('hidden'));
      document.getElementById(sectionId).classList.remove('hidden');
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function confirmDelete(type, id) {
      const deleteLink = document.querySelector('#deleteModal a');
      deleteLink.setAttribute('data-delete-type', type);
      deleteLink.setAttribute('data-delete-id', id);
      deleteLink.href = `<?php echo generateUrl("admin-delete") ?>?type=${encodeURIComponent(type)}&id=${encodeURIComponent(id)}`;
      openModal('deleteModal');
    }

    // Åbn/Luk modaler
    function openModal(id, sender) {
      document.getElementById(id).classList.remove('hidden');
      if(sender) {
        const row = sender.closest('tr');
        const modal = document.getElementById(id);
        row.querySelectorAll('[data-form-field]').forEach(field => {
          const fieldName = field.getAttribute('data-form-field');
          const modalField = modal.querySelector(`[name="${fieldName}"]`);
          console.log('Filling modal field:', fieldName, modalField);
          if(modalField) {
            modalField.value = field.textContent.trim();
          }
        });
      }
    }

    function closeModal(id) {
      document.getElementById(id).classList.add('hidden');
    }

    // Standardvisning
    showSection('showings');
  </script>
</body>
</html>