<?php
require_once __DIR__ . '/partials/header.php';

// Hent data fra ViewModel
/** @var MovieDetailsViewModel $viewModel */
$allMovies = $viewModel->getAllMovies();
$selectedMovie = $viewModel->getSelectedMovie();
?>

<style>
@keyframes pulseGlow {
  0%,100% { box-shadow:0 0 10px #fbbf24,0 0 20px #fbbf24,0 0 40px #fbbf24; }
  50% { box-shadow:0 0 20px #facc15,0 0 40px #facc15,0 0 60px #facc15; }
}
.glow { animation: pulseGlow 2s infinite; }
</style>

<div class="max-w-6xl mx-auto px-6 pt-20 pb-20">
  <!-- Selection Controls -->
  <div class="flex flex-col md:flex-row md:items-center gap-6 mb-12">
    <!-- Movie Dropdown -->
    <div class="relative w-full md:w-1/2">
      <form method="get" action="<?= generateUrl('movie-details') ?>">
        <input type="text" id="movieInput" name="id" placeholder="Select movie"
          class="bg-black border border-[#00e7ec] text-[#00e7ec] text-sm rounded-lg focus:ring-[#00e7ec] focus:border-[#00e7ec] block w-full pl-3 p-2.5 cursor-pointer"
          readonly
          value="<?= $selectedMovie ? safeString($selectedMovie->getTitle()) . ' (' . $selectedMovie->getReleaseYear() . ')' : ''; ?>">
        <i data-feather="chevron-down" class="absolute right-3 top-3 text-[#00e7ec] pointer-events-none"></i>

        <!-- Dropdown-liste -->
        <div id="movieDropdown"
             class="absolute left-0 mt-1 w-full bg-black border border-[#00e7ec] rounded-lg shadow-lg hidden z-50 max-h-60 overflow-y-auto">
          <?php foreach ($allMovies as $movie): ?>
            <div class="px-3 py-2 hover:bg-[#003133] cursor-pointer text-[#00e7ec]"
                 onclick="document.getElementById('movieInput').value='<?= safeString($movie->getTitle()) . ' (' . $movie->getReleaseYear() . ')' ?>'; window.location='<?= generateUrl('movie-details') ?>?id=<?= $movie->getMovieID(); ?>';">
              <?= safeString($movie->getTitle()); ?> (<?= $movie->getReleaseYear(); ?>)
            </div>
          <?php endforeach; ?>
        </div>
      </form>
    </div>

    <!-- Date Dropdown -->
    <div class="relative w-full md:w-1/2">
      <!--<form method="get" action="<?= generateUrl('movie-details') ?>">-->
          <input type="text" id="dateInput" name="id" placeholder="Select date"
                 class="bg-black border border-[#00e7ec] text-[#00e7ec] text-sm rounded-lg focus:ring-[#00e7ec] focus:border-[#00e7ec] block w-full pl-3 p-2.5 cursor-pointer"
                 readonly>
          <i data-feather="chevron-down" class="absolute right-3 top-3 text-[#00e7ec] pointer-events-none"></i>

          <!-- Dropdown-liste -->
          <div id="dateDropdown"
               class="absolute left-0 mt-1 w-full bg-black border border-[#00e7ec] rounded-lg shadow-lg hidden z-50 max-h-60 overflow-y-auto">
              <?php foreach ($viewModel->getFutureShowings() as $showing): ?>
                  <div class="px-3 py-2 hover:bg-[#003133] cursor-pointer text-[#00e7ec]"
                       onclick="goToBooking(<?php echo safeString($showing->getShowingID()); ?>)">
                      <?= safeString($showing->getDate()->format('F j Y')); ?> <?php echo safeString($showing->getReelTimes()[0]); ?>
                  </div>
              <?php endforeach; ?>
          </div>
      <!--</form>-->
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
  <?php if ($selectedMovie): ?>
  <section id="movieDetails" class="border border-[#00e7ec] rounded-2xl overflow-hidden shadow-lg">
    <div class="flex flex-col md:flex-row">
      <div class="md:w-1/3">
        <img id="moviePoster" 
             src="/assets/posters/<?= strtolower(str_replace(' ', '-', $selectedMovie->getTitle())); ?>.jpg"
             alt="Movie Poster"
             class="w-full h-full object-cover">
      </div>
      <div class="md:w-2/3 p-8">
        <h1 id="movieTitle" class="text-4xl font-bold text-[#00e7ec] mb-3"><?= safeString($selectedMovie->getTitle()); ?></h1>
        <div class="flex items-center mb-4">
          <i data-feather="star" class="text-[#00e7ec] mr-2"></i>
          <span id="movieRating"><?= safeString($selectedMovie->getRanking()); ?> / 5</span>
        </div>
        <p id="movieDesc" class="text-gray-300 mb-6 leading-relaxed"><?= safeString($selectedMovie->getDescription()); ?></p>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
          <div><span class="text-[#00e7ec]">Release Year:</span> <?= $selectedMovie->getReleaseYear(); ?></div>
          <div><span class="text-[#00e7ec]">Genre:</span> <?= implode(', ', array_map(fn($g) => $g->getName(), $selectedMovie->getGenres())); ?></div>
          <div><span class="text-[#00e7ec]">Length:</span> <?= $selectedMovie->getLength(); ?> min</div>
          <div><span class="text-[#00e7ec]">Language:</span> <?= safeString($selectedMovie->getLanguage()); ?></div>
          <div><span class="text-[#00e7ec]">Age Limit:</span> <?= $selectedMovie->getAgeLimit(); ?>+</div>
          <div><span class="text-[#00e7ec]">Director:</span> <?= safeString($selectedMovie->getDirector()->getFirstName() . ' ' . $selectedMovie->getDirector()->getLastName()); ?></div>
          <div><span class="text-[#00e7ec]">Company:</span> <?= safeString($selectedMovie->getCompany()->getName()); ?></div>
          <div class="col-span-2 md:col-span-3"><span class="text-[#00e7ec]">Main Cast:</span> <?= implode(', ', array_map(fn($a) => safeString($a->getFirstName() . ' ' . $a->getLastName()), $selectedMovie->getActors())); ?></div>
        </div>
      </div>
    </div>
  </section>
  <?php else: ?>
    <p class="text-gray-400 text-center mt-10 italic">Please select a movie from the dropdown above.</p>
  <?php endif; ?>
</div>

<script>
  const movieInput = document.getElementById('movieInput');
  const movieDropdown = document.getElementById('movieDropdown');
  const dateInput = document.getElementById('dateInput');
const dateDropdown = document.getElementById('dateDropdown');

  function prepareDropdown(input, dropdown) {
      input.addEventListener('click', () => {
          dropdown.classList.toggle('hidden');
      });

      document.addEventListener('click', (e) => {
          if (!input.contains(e.target) && !dropdown.contains(e.target)) {
              dropdown.classList.add('hidden');
          }
      });
  }

  function goToBooking(showingID) {
      window.location.href = `booking?showing_id=${showingID}`;
  }

  prepareDropdown(movieInput, movieDropdown);
  prepareDropdown(dateInput, dateDropdown);

</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>