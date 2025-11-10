<?php require_once __DIR__ . '/partials/header.php'; ?>
<?php /** @var AdminViewModel $viewModel */ ?>

<link href="assets/admin.css" rel="stylesheet">

<body class="bg-black text-white font-sans min-h-screen">
  <!-- Hero Section -->
  <header class="pt-20 bg-black text-center py-8">
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
      <?php require __DIR__ . "/admin/movie-section.php"; ?>
  </section>

  <!-- Showings Section -->
  <section id="showings" class="hidden mt-8 px-6">
    <?php require __DIR__ . "/admin/showing-section.php"; ?>
  </section>

  <!-- News Section -->
  <section id="news" class="hidden mt-8 px-6">
    <?php require __DIR__ . "/admin/news-section.php"; ?>
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
  <div id="aboutModal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-50">
    <div class="modal-box bg-[#1a1a1a] p-6 rounded-lg w-full max-w-2xl text-white relative">
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


<script src="assets/admin.js"></script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>