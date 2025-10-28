<?php require_once __DIR__ . '/partials/header.php'; ?>

<?php
$movie = $viewModel->getMovie();
$company = $viewModel->getCompany();
$genres = $viewModel->getGenres();
$cast = $viewModel->getCast();
$showings = $viewModel->getShowings();
?>

<style>
@keyframes pulseGlow {
  0%,100% { box-shadow:0 0 10px #fbbf24,0 0 20px #fbbf24,0 0 40px #fbbf24; }
  50% { box-shadow:0 0 20px #facc15,0 0 40px #facc15,0 0 60px #facc15; }
}
.glow { animation: pulseGlow 2s infinite; }
</style>

<div class="max-w-6xl mx-auto px-6 pt-10 pb-16">
<a href="index.php" class="flex items-center text-amber-400 hover:text-amber-300 mb-8 transition">
<i data-feather="chevron-left" class="mr-1"></i> Back to Movies
</a>

<!-- Selection Controls -->
<div class="flex flex-col md:flex-row md:items-center gap-6 mb-12">
  <!-- Movie Dropdown -->
  <div class="relative w-full md:w-1/2">
    <input type="text" id="movieInput" placeholder="Select movie"
      class="bg-black border border-[#00e7ec] text-[#00e7ec] text-sm rounded-lg focus:ring-[#00e7ec] focus:border-[#00e7ec] block w-full pl-3 p-2.5 cursor-pointer" readonly>
    <i data-feather="chevron-down" class="absolute right-3 top-3 text-[#00e7ec] pointer-events-none"></i>

    <div id="movieDropdown" class="absolute left-0 mt-1 w-full bg-black border border-[#00e7ec] rounded-lg shadow-lg hidden z-50 max-h-60 overflow-y-auto">
      <div class="px-3 py-2 hover:bg-[#003133] cursor-pointer text-[#00e7ec]"><?php echo safeString($movie->getTitle()); ?></div>
    </div>
  </div>

  <!-- Calendar -->
  <div class="relative w-full md:w-1/2">
    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
      <i data-feather="calendar" class="text-white w-5 h-5"></i>
    </div>
    <input id="dateInput" type="text"
      class="bg-black border border-[#00e7ec] text-white text-sm rounded-lg focus:ring-[#00e7ec] focus:border-[#00e7ec] block w-full pl-10 p-2.5"
      placeholder="Select date" readonly>
    <div id="calendar" class="absolute left-0 mt-1 w-64 bg-black border border-[#00e7ec] rounded-lg shadow-lg hidden z-50 p-2 text-sm overflow-y-auto max-h-80">
      <div class="flex justify-between items-center mb-1 text-[#00e7ec] text-sm">
        <button id="prevMonth" class="px-2 py-1 bg-black rounded hover:bg-[#003133]">&lt;</button>
        <span id="monthYear" class="font-semibold text-[#00e7ec]"></span>
        <button id="nextMonth" class="px-2 py-1 bg-black rounded hover:bg-[#003133]">&gt;</button>
      </div>
      <div class="grid grid-cols-7 gap-1 text-center font-medium text-xs">
        <div class="text-[#00e7ec]">Sun</div>
        <div class="text-white">Mon</div>
        <div class="text-white">Tue</div>
        <div class="text-white">Wed</div>
        <div class="text-white">Thu</div>
        <div class="text-white">Fri</div>
        <div class="text-[#00e7ec]">Sat</div>
      </div>
      <div id="dates" class="grid grid-cols-7 gap-1 mt-1 text-center text-white text-sm"></div>
    </div>
  </div>
</div>

<!-- Showtimes -->
<div class="mb-6">
<h3 class="text-xl text-[#00e7ec] mb-3">Available Showtimes</h3>
<div class="flex flex-wrap items-center gap-3" id="showtimes">
<p class="text-gray-400 text-sm italic">Select a date to view showtimes.</p>
</div>
</div>

<!-- Movie Details -->
<section id="movieDetails" class="border border-[#00e7ec] rounded-2xl overflow-hidden shadow-lg">
<div class="flex flex-col md:flex-row">
  <div class="md:w-1/3">
    <img id="moviePoster" src="" alt="Movie Poster" class="w-full h-full object-cover">
  </div>
  <div class="md:w-2/3 p-8">
    <h1 id="movieTitle" class="text-4xl font-bold text-[#00e7ec] mb-3"><?php echo safeString($movie->getTitle()); ?></h1>
    <div class="flex items-center mb-4">
      <i data-feather="star" class="text-[#00e7ec] mr-2"></i>
      <span id="movieRating"><?php echo safeString($movie->getRanking()); ?> / 5</span>
    </div>
    <p id="movieDesc" class="text-gray-300 mb-6 leading-relaxed"><?php echo safeString($movie->getDescription()); ?></p>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
      <div><span class="text-[#00e7ec]">Release Year:</span> <?php echo safeString($movie->getReleaseYear()); ?></div>
      <div><span class="text-[#00e7ec]">Genre:</span> <?php echo implode(', ', $genres); ?></div>
      <div><span class="text-[#00e7ec]">Length:</span> <?php echo safeString($movie->getLength()); ?> min</div>
      <div><span class="text-[#00e7ec]">Language:</span> <?php echo safeString($movie->getLanguage()); ?></div>
      <div><span class="text-[#00e7ec]">Age Limit:</span> <?php echo safeString($movie->getAgeLimit()); ?>+</div>
      <div><span class="text-[#00e7ec]">Director:</span> <?php echo safeString($movie->getDirector()->getFirstName()); ?></div>
      <div><span class="text-[#00e7ec]">Company:</span> <?php echo safeString($company); ?></div>
      <div class="col-span-2 md:col-span-3"><span class="text-[#00e7ec]">Main Cast:</span> <?php echo implode(', ', $cast); ?></div>
    </div>
  </div>
</div>
</section>

<script src="assets/movie-details.js"></script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>