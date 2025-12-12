<?php require_once __DIR__ . '/partials/header.php'; ?>

<!-- Hero Section -->
<section id="hero" class="relative h-[650px] flex flex-col items-center justify-center text-center overflow-hidden px-4"
      style="background-image: url('/img/hero-img.webp'); background-size: cover; background-position: center;">

    <div class="absolute inset-0 bg-black/60"></div>

    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-r from-[#FFDF00]/30 via-[#FE04FF]/20 to-[#00e7ec]/30 blur-3xl"></div>
    </div>

    <div id="lines-container" class="absolute inset-0 w-full h-full pointer-events-none overflow-hidden"></div>

    <div id="particles-container" class="absolute inset-0 w-full h-full pointer-events-none overflow-hidden"></div>

    <div class="relative z-10 max-w-3xl">
        <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold mb-4 text-[#FFDF00] animate-neon-flicker whitespace-nowrap">
            Step into RetroBio
        </h1>
        <p class="text-2xl md:text-3xl italic text-[#00e7ec] animate-neon-flicker delay-200">
            A vintage escape for true film lovers
        </p>
    </div>
</section>

<!-- Movie Section -->
<section class="py-16 px-6 bg-black">
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl text-[#00e7ec] font-bold">On the Reel</h2>
            <a href="<?php echo generateUrl("movie-details") ?>" class="flex items-center text-amber-400 hover:text-amber-300 transition">
                View All <i data-feather="chevron-right" class="ml-1"></i>
            </a>
        </div>

        <!-- Date picker -->
        <div class="mb-8">
            <div class="relative max-w-md">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i data-feather="calendar" class="text-white w-5 h-5"></i>
                </div>
                <input id="dateInput" type="text"
                    class="bg-black border border-[#00e7ec] text-white text-sm rounded-lg focus:ring-[#00e7ec] focus:border-[#00e7ec] block w-full pl-10 p-2.5"
                    placeholder="Select date" readonly>

                <!-- Calendar dropdown -->
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

        <!-- Week Calendar -->
        <div class="flex overflow-x-auto pb-4 mb-8 scrollbar-hide">
          <div class="flex space-x-2">
              <?php $previous = null; ?>
              <?php foreach($viewModel->getShowings() as $showing): ?>
                <?php if($previous?->getDate()->format("Y-m-d") !== $showing->getDate()->format("Y-m-d")): ?>
                  <button onclick="filterMovies(this)" class="filter-button bg-black border border-[#00e7ec] hover:border-[#00e7ec] hover:bg-[#00e7ec] hover:text-black text-white px-4 py-2 rounded-md min-w-[100px]"><?php echo relativeDate($showing->getDate()) ?></button>
                <?php endif; ?>
                <?php $previous = $showing; ?>
              <?php endforeach; ?>
              <!-- <button class="bg-[#00e7ec] text-black px-4 py-2 rounded-md font-medium min-w-[100px]">Today</button>
              <button class="bg-black border border-[#00e7ec] hover:border-[#00e7ec] hover:bg-[#00e7ec] hover:text-black px-4 py-2 rounded-md min-w-[100px]">Tomorrow</button> -->
          </div>
        </div>

        <!-- Showing Card -->
        <?php /** @var Showing $showing */ foreach($viewModel->getShowings() as $showing): ?>

        <div data-showing-date="<?php echo relativeDate($showing->getDate()) ?>" class="bg-black rounded-xl overflow-hidden mb-12 border-[1px] border-[#00e7ec]
                    transition-transform duration-300 hover:-translate-y-2 
                    hover:shadow-2xl">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/4">
                    <img src="img/The_Goonies.jpg" 
                        alt="Movie Poster" 
                        class="w-full h-full object-cover">
                </div>
                <div class="md:w-3/4 p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                        <h3 class="text-2xl text-[#00e7ec] font-bold"><?php echo safeString($showing->getMovie()->getTitle()) ?></h3>
                        <div class="flex items-center ">
                            <i data-feather="star" class="mr-1"></i>
                            <span><?php echo floatval($showing->getMovie()->getRanking()) ?>/5</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <?php /** @var string $genre */ foreach($showing->getMovie()->getGenres() as $genre): ?>
                          <span class="text-xs bg-black border border-[#00e7ec] text-white px-2 py-1 rounded"><?php echo safeString($genre) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <p class="text-gray-300 mb-6"><?php echo safeString($showing->getMovie()->getDescription()) ?></p>

                    <div>
                        <h4 class="font-medium text-[#00e7ec] mb-3">Reel times</h4>
                        <div class="flex flex-wrap gap-3">
                            <?php foreach($showing->getReelTimes() as $reelTime): ?>
                              <a href="booking_page" 
                              class="inline-block bg-black text-white px-4 py-2 rounded-md transition-colors 
                                  border border-[#00e7ec] hover:border-[#00e7ec]        
                                  hover:bg-[#00e7ec] hover:!text-[#000000]">
                              <?php echo safeString($reelTime) ?>
                              </a>
                            <?php endforeach; ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
      </div>
</section>


<!-- News Section -->
<section class="py-16 px-6 bg-black relative">
  <div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-3xl text-[#FE04FF] font-bold animate-neon-flicker">Retro News</h2>
      <a href="/news.php" class="flex items-center text-amber-400 hover:text-amber-300 transition">
        View All <i data-feather="chevron-right" class="ml-1"></i>
      </a>
    </div>

    <div class="relative">
      <!-- Karrusel-container -->
      <div id="newsCarousel" class="flex overflow-x-auto space-x-6 scroll-smooth">

        <!-- News Card -->
         <?php /** @var News $news */ foreach($viewModel->getNews() as $news): ?>

        <div class="news-card w-[520px] bg-black border border-[#FE04FF] rounded-xl p-4 flex-shrink-0 relative hover:shadow-[0_0_25px_#FE04FF] transition-all duration-500">
          <div class="overflow-hidden rounded-lg border border-[#FE04FF] mb-4">
            <img src="/img/news1.jpg" alt="Nyhed 1" class="w-full h-52 object-cover">
          </div>
          <h3 class="text-xl text-[#FE04FF] font-bold mb-2 animate-neon-flicker"><?php echo safeString($news->getTitle()) ?></h3>
          <div class="text-container text-gray-300 text-sm relative overflow-hidden">
            <p><?php echo safeString($news->getDescription()) ?></p>
            <div class="fade-overlay absolute bottom-0 left-0 w-full h-12 bg-gradient-to-t from-black"></div>
          </div>
          <span class="mt-2 inline-block text-xs text-[#FFDF00] font-semibold"><?php echo safeString($news->getReleaseDate()->format('Y-m-d')) ?></span>
        </div>

        <?php endforeach; ?>

        <!-- Pile navigation -->
        <button id="prevNews" class="absolute top-1/2 -left-4 transform -translate-y-1/2 bg-black text-[#FE04FF] border border-[#FE04FF] rounded-full w-10 h-10 flex items-center justify-center hover:bg-[#FE04FF] hover:text-black transition z-10">
          <i data-feather="chevron-left"></i>
        </button>
        <button id="nextNews" class="absolute top-1/2 -right-4 transform -translate-y-1/2 bg-black text-[#FE04FF] border border-[#FE04FF] rounded-full w-10 h-10 flex items-center justify-center hover:bg-[#FE04FF] hover:text-black transition z-10">
          <i data-feather="chevron-right"></i>
        </button>
    </div>
  </div>
</section>


<!-- About Section -->
<section id="about" class="py-20 px-6 bg-black relative overflow-hidden">
  <!-- Neon Glow Background -->
  <div class="absolute inset-0 pointer-events-none">
      <div class="absolute inset-0 bg-gradient-to-r from-[#FE04FF]/25 via-[#00e7ec]/10 to-[#FFDF00]/25 blur-3xl opacity-30"></div>
  </div>

  <div class="container mx-auto relative z-10">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-stretch">

          <!-- Image -->
          <div class="flex">
              <div class="image-box w-full overflow-hidden rounded-xl border border-[#00e7ec] film-grain">
                  <img src="/img/cinema-interior.webp" alt="Retro Cinema Interior" class="w-full h-full object-cover">
              </div>
          </div>

          <?php $about = $viewModel->getAbout() ?>
          <!-- Text Content -->
          <div class="flex flex-col justify-between">

              <div class="text-center mb-3">
                  <h2 class="text-5xl sm:text-6xl md:text-7xl font-extrabold text-[#FFDF00] animate-neon-flicker">
                    <?php echo safeString($about->getTitle()) ?>
                  </h2>
                  <h3 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#FE04FF] animate-neon-flicker delay-200 mt-2">
                    <?php echo safeString($about->getSubtitle()) ?>
                  </h3>
              </div>

              <div class="space-y-6 text-gray-300 leading-relaxed text-lg" style="white-space: pre-line;">
                <p>
                    <?php echo safeString($about->getDescription()); ?>
                </p>
              </div>

              <!-- Contact / Hours -->
              <div class="mt-10 contact-box border rounded-xl p-6 film-grain">
                  <!-- Visit RetroBio -->
                  <h3 class="text-xl text-[#FFDF00] font-bold animate-neon-flicker delay-200 mb-4">
                      Visit RetroBio
                  </h3>

                  <div class="space-y-2 text-sm text-gray-200">
                      <p><span class="font-semibold text-[#FE04FF]">Address:</span> <?php echo safeString($about->getAddress()) ?></p>
                      <p><span class="font-semibold text-[#FE04FF]">Email:</span> <?php echo safeString($about->getEmail()) ?></p>
                      <p><span class="font-semibold text-[#FE04FF]">Phone:</span> <?php echo safeString($about->getPhone()) ?></p>
                  </div>

                  <div class="mt-4">
                      <h4 class="text-lg text-[#FFDF00] font-bold animate-neon-flicker delay-200 mb-2">
                          Opening Hours
                      </h4>
                      <ul class="space-y-1 text-sm text-gray-200">
                          <li><span class="text-[#FE04FF] font-semibold">Mon–Thu:</span> 16:00 – 22:30</li>
                          <li><span class="text-[#FE04FF] font-semibold">Fri:</span> 16:00 – 00:00</li>
                          <li><span class="text-[#FE04FF] font-semibold">Sat:</span> 12:00 – 00:00</li>
                          <li><span class="text-[#FE04FF] font-semibold">Sun:</span> 12:00 – 22:00</li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>

<?php require_once __DIR__ . '/partials/footer.php'; ?>