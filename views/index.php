<?php require_once __DIR__ . '/partials/header.php'; ?>

<!-- Hero Section -->
   <section id="hero" class="relative h-[650px] flex flex-col items-center justify-center text-center overflow-hidden px-4"
         style="background-image: url('/img/hero-img.webp'); background-size: cover; background-position: center;">

        <!-- Mørk overlay -->
        <div class="absolute inset-0 bg-black/60"></div>

        <!-- Blur/haze overlay -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-r from-[#FFDF00]/30 via-[#FE04FF]/20 to-[#00e7ec]/30 blur-3xl"></div>
        </div>

        <!-- Linjer -->
        <div id="lines-container" class="absolute inset-0 w-full h-full pointer-events-none overflow-hidden"></div>

        <!-- Partikler -->
        <div id="particles-container" class="absolute inset-0 w-full h-full pointer-events-none overflow-hidden"></div>

        <!-- Hero indhold -->
        <div class="relative z-10 max-w-3xl">
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold mb-4 text-[#FFDF00] animate-neon-flicker whitespace-nowrap">
                Step into RetroBio
            </h1>
            <p class="text-2xl md:text-3xl italic text-[#00e7ec] animate-neon-flicker delay-200">
                A vintage escape for true film lovers
            </p>
        </div>
    </section>

<style>
/* Mild neon tekst flicker med lidt ekstra glød */
@keyframes neonFlicker {
  0%,19%,21%,23%,25%,54%,56%,100% { 
      text-shadow: 
          0 0 2px currentColor, 
          0 0 6px currentColor, 
          0 0 12px currentColor, 
          0 0 20px currentColor; /* ekstra glød */
      opacity:1;
  }
  20%,22%,24%,55% { 
      text-shadow:none; 
      opacity:0.9;
  }
}
.animate-neon-flicker { 
    animation: neonFlicker 2s infinite; 
}
.animate-neon-flicker.delay-200 { 
    animation-delay:0.2s; 
}

/* Diagonal line base */
.diagonal-line {
  position:absolute; width:3px; height:200%; opacity:0.3;
  box-shadow:0 0 10px currentColor,0 0 20px currentColor,0 0 40px currentColor;
}

/* Partikler base */
.particle {
  position:absolute;
  width:6px; height:6px;
  border-radius:50%;
  opacity:0.7;
  box-shadow:0 0 8px currentColor,0 0 16px currentColor,0 0 32px currentColor;
}

/* Sparkle */
.sparkle {
  position:absolute;
  width:2px; height:2px;
  border-radius:50%;
  opacity:0;
  box-shadow:0 0 6px currentColor,0 0 12px currentColor;
  pointer-events:none;
}

/* Blur/haze overlay */
.blur-3xl { filter: blur(64px); }
</style>

<script>
const NUM_LINES = 30;
const NUM_PARTICLES = 60;
const NUM_SPARKLES = 80;
const COLORS = ['#FFDF00','#FE04FF','#00e7ec'];

const linesContainer = document.getElementById('lines-container');
const particlesContainer = document.getElementById('particles-container');
const hero = document.getElementById('hero');

let heroWidth = hero.offsetWidth;
let heroHeight = hero.offsetHeight;
const rand = (min,max) => Math.random()*(max-min)+min;

// --- Linjer ---
for(let i=0;i<NUM_LINES;i++){
    const line = document.createElement('div');
    line.classList.add('diagonal-line');
    line.style.backgroundColor = COLORS[i % COLORS.length];
    line.style.transform = `rotate(${rand(-15,15)}deg)`;

    let x = rand(-0.3*heroWidth,1.0*heroWidth);
    let y = rand(-0.5*heroHeight,1.0*heroHeight);

    line.style.left = x+'px';
    line.style.top = y+'px';

    const dx = rand(0.3,0.6);
    const dy = rand(0.3,0.6);

    function moveLine(){
        x += dx; y += dy;
        if(x>heroWidth) x=-0.3*heroWidth;
        if(y>heroHeight) y=-0.5*heroHeight;
        line.style.left = x+'px';
        line.style.top = y+'px';
        requestAnimationFrame(moveLine);
    }
    moveLine();
    linesContainer.appendChild(line);
}

// --- Partikler ---
for(let i=0;i<NUM_PARTICLES;i++){
    const particle = document.createElement('div');
    particle.classList.add('particle');
    particle.style.backgroundColor = COLORS[Math.floor(Math.random()*COLORS.length)];

    let x = rand(0,heroWidth);
    let y = rand(0,heroHeight);

    particle.style.left = x+'px';
    particle.style.top = y+'px';

    const dx = rand(-0.5,0.5);
    const dy = rand(-0.5,0.5);

    function moveParticle(){
        x += dx; y += dy;
        if(x<0) x=heroWidth;
        if(x>heroWidth) x=0;
        if(y<0) y=heroHeight;
        if(y>heroHeight) y=0;
        particle.style.left = x+'px';
        particle.style.top = y+'px';
        requestAnimationFrame(moveParticle);
    }
    moveParticle();
    particlesContainer.appendChild(particle);
}

// --- Sparkles ---
for(let i=0;i<NUM_SPARKLES;i++){
    const sparkle = document.createElement('div');
    sparkle.classList.add('sparkle');
    sparkle.style.backgroundColor = COLORS[Math.floor(Math.random()*COLORS.length)];

    function sparkleLoop(){
        const x = rand(0,heroWidth);
        const y = rand(0,heroHeight);
        sparkle.style.left = x+'px';
        sparkle.style.top = y+'px';
        sparkle.style.opacity = 1;
        setTimeout(()=>{ sparkle.style.opacity = 0; }, rand(100,400));
        setTimeout(sparkleLoop, rand(200,800));
    }
    sparkleLoop();
    particlesContainer.appendChild(sparkle);
}

// --- Responsiv ---
window.addEventListener('resize', ()=>{
    heroWidth = hero.offsetWidth;
    heroHeight = hero.offsetHeight;
});
</script>

<!-- Movie Section -->
    <section class="py-16 px-6 bg-black">
        <div class="container mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl text-[#00e7ec] font-bold">On the Reel</h2>
                <a href="#" class="flex items-center text-amber-400 hover:text-amber-300 transition">
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
                    <button class="bg-black border border-[#00e7ec] hover:border-[#00e7ec] hover:bg-[#00e7ec] hover:text-black text-white px-4 py-2 rounded-md min-w-[100px]"><?php echo relativeDate($showing->getDate()) ?></button>
                  <?php endif; ?>
                  <?php $previous = $showing; ?>
                <?php endforeach; ?>
                <!-- <button class="bg-[#00e7ec] text-black px-4 py-2 rounded-md font-medium min-w-[100px]">Today</button>
                <button class="bg-black border border-[#00e7ec] hover:border-[#00e7ec] hover:bg-[#00e7ec] hover:text-black px-4 py-2 rounded-md min-w-[100px]">Tomorrow</button> -->
            </div>
            </div>


            <!-- Showing Card -->
           <?php /** @var Showing $showing */ foreach($viewModel->getShowings() as $showing): ?>


           <div class="bg-black rounded-xl overflow-hidden mb-12 border-[1px] border-[#00e7ec]
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
                            <h3 class="text-2xl text-[#00e7ec] font-bold"><?php echo htmlspecialchars($showing->getMovie()->getTitle()) ?></h3>
                            <div class="flex items-center ">
                                <i data-feather="star" class="mr-1"></i>
                                <span><?php echo floatval($showing->getMovie()->getRanking()) ?>/5</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="text-xs bg-black border border-[#00e7ec] text-white px-2 py-1 rounded"><?php echo htmlspecialchars($showing->getMovie()->getGenre()) ?></span>
                        </div>
                        <p class="text-gray-300 mb-6"><?php echo htmlspecialchars($showing->getMovie()->getDescription()) ?></p>

                        <div>
                            <h4 class="font-medium text-[#00e7ec] mb-3">Reel times</h4>
                            <div class="flex flex-wrap gap-3">
                                <?php foreach($showing->getReelTimes() as $reelTime): ?>
                                  <a href="booking_page" 
                                  class="inline-block bg-black text-white px-4 py-2 rounded-md transition-colors 
                                      border border-[#00e7ec] hover:border-[#00e7ec]        
                                      hover:bg-[#00e7ec] hover:!text-[#000000]">
                                  <?php echo htmlspecialchars($reelTime) ?>
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

<script>
const input = document.getElementById('dateInput');
const calendar = document.getElementById('calendar');
const monthYear = document.getElementById('monthYear');
const datesContainer = document.getElementById('dates');
const prevMonthBtn = document.getElementById('prevMonth');
const nextMonthBtn = document.getElementById('nextMonth');

// Start kalenderen fra November 2025
let currentDate = new Date(2025, 10, 1); // JS måneder: 0 = Jan, 10 = Nov
const today = new Date();

function renderCalendar(date) {
  const year = date.getFullYear();
  const month = date.getMonth();

  const monthNames = ["January", "February", "March", "April", "May", "June", 
                      "July", "August", "September", "October", "November", "December"];
  monthYear.textContent = `${monthNames[month]} ${year}`;
  monthYear.classList.add('text-[#00e7ec]'); // måned/år farve

  const firstDay = new Date(year, month, 1).getDay();
  const lastDate = new Date(year, month + 1, 0).getDate();

  datesContainer.innerHTML = '';

  // Tomme felter i starten af måneden
  for (let i = 0; i < firstDay; i++) {
    const empty = document.createElement('div');
    datesContainer.appendChild(empty);
  }

  // Tilføj dage
  for (let day = 1; day <= lastDate; day++) {
    const btn = document.createElement('button');
    btn.textContent = day;
    btn.className = 'p-2 rounded hover:bg-[#003133] text-white'; // standard farve hvid

    // Weekender styling (søndag = 0, lørdag = 6)
    const weekDay = (firstDay + day - 1) % 7;
    if (weekDay === 0 || weekDay === 6) {
      btn.classList.add('text-[#00e7ec]');
    }

    // Marker dagens dato med baggrund
    if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
      btn.classList.add('bg-[#00e7ec]', 'text-black', 'font-bold'); // dagens dato
    }

    btn.addEventListener('click', () => {
      input.value = `${year}-${String(month+1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
      calendar.classList.add('hidden');
    });

    datesContainer.appendChild(btn);
  }
}

// Vis kalender ved fokus
input.addEventListener('focus', () => {
  calendar.classList.remove('hidden');
  renderCalendar(currentDate);
});

// Skift måned
prevMonthBtn.addEventListener('click', () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendar(currentDate);
});
nextMonthBtn.addEventListener('click', () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendar(currentDate);
});

// Gem kalender når der klikkes udenfor
document.addEventListener('click', (e) => {
  if (!input.contains(e.target) && !calendar.contains(e.target)) {
    calendar.classList.add('hidden');
  }
});
</script>


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

         <!-- News Card 4 -->
        <div class="news-card w-[520px] bg-black border border-[#FE04FF] rounded-xl p-4 flex-shrink-0 relative hover:shadow-[0_0_25px_#FE04FF] transition-all duration-500">
          <div class="overflow-hidden rounded-lg border border-[#FE04FF] mb-4">
            <img src="img/poster-wall.webp" alt="Nyhed 4" class="w-full h-52 object-cover">
          </div>
          <h3 class="text-xl text-[#FE04FF] font-bold mb-2 animate-neon-flicker">New Posters on the walls</h3>
          <div class="text-container text-gray-300 text-sm relative overflow-hidden">
            <p>We’ve filled the cinema with vintage posters from films like Blade Runner, A Clockwork Orange, and other cult classics. Come take a look—and get inspired by iconic designs.</p>
            <div class="fade-overlay absolute bottom-0 left-0 w-full h-12 bg-gradient-to-t from-black"></div>
          </div>
          <span class="mt-2 inline-block text-xs text-[#FFDF00] font-semibold">Nov 12, 2025</span>
        </div>

        <!-- News Card 5 -->
        <div class="news-card w-[520px] bg-black border border-[#FE04FF] rounded-xl p-4 flex-shrink-0 relative hover:shadow-[0_0_25px_#FE04FF] transition-all duration-500">
          <div class="overflow-hidden rounded-lg border border-[#FE04FF] mb-4">
            <img src="img/quiz-night.webp" alt="Nyhed 5" class="w-full h-52 object-cover">
          </div>
          <h3 class="text-xl text-[#FE04FF] font-bold mb-2 animate-neon-flicker">Film Quiz in the Cinema</h3>
          <div class="text-container text-gray-300 text-sm relative overflow-hidden">
            <p>Test your knowledge of cult classics and win awesome prizes in our cozy cinema environment. Can you match our film enthusiasts and remember all the details from the wildest retro movies?</p>
            <div class="fade-overlay absolute bottom-0 left-0 w-full h-12 bg-gradient-to-t from-black"></div>
          </div>
          <span class="mt-2 inline-block text-xs text-[#FFDF00] font-semibold">Nov 18, 2025</span>
        </div>

        <!-- News Card 3 -->
        <div class="news-card w-[520px] bg-black border border-[#FE04FF] rounded-xl p-4 flex-shrink-0 relative hover:shadow-[0_0_25px_#FE04FF] transition-all duration-500">
          <div class="overflow-hidden rounded-lg border border-[#FE04FF] mb-4">
            <img src="img/movie-marathon.webp" alt="Nyhed 3" class="w-full h-52 object-cover">
          </div>
          <h3 class="text-xl text-[#FE04FF] font-bold mb-2 animate-neon-flicker">Cult Movie Marathon</h3>
          <div class="text-container text-gray-300 text-sm relative overflow-hidden">
            <p>24 hours of non-stop cult classics – a retro fan’s dream come true. Bring snacks, blankets, and your love for vintage cinema!</p>
            <div class="fade-overlay absolute bottom-0 left-0 w-full h-12 bg-gradient-to-t from-black"></div>
          </div>
          <span class="mt-2 inline-block text-xs text-[#FFDF00] font-semibold">Nov 21, 2025</span>
        </div>

        <!-- News Card 1 -->
        <div class="news-card w-[520px] bg-black border border-[#FE04FF] rounded-xl p-4 flex-shrink-0 relative hover:shadow-[0_0_25px_#FE04FF] transition-all duration-500">
          <div class="overflow-hidden rounded-lg border border-[#FE04FF] mb-4">
            <img src="/img/news1.jpg" alt="Nyhed 1" class="w-full h-52 object-cover">
          </div>
          <h3 class="text-xl text-[#FE04FF] font-bold mb-2 animate-neon-flicker">Classic Horror Night</h3>
          <div class="text-container text-gray-300 text-sm relative overflow-hidden">
            <p>Join us this Friday for a night of classic horror films with popcorn and neon vibes. Don’t miss the retro trailers and surprise giveaways!</p>
            <div class="fade-overlay absolute bottom-0 left-0 w-full h-12 bg-gradient-to-t from-black"></div>
          </div>
          <span class="mt-2 inline-block text-xs text-[#FFDF00] font-semibold">Dec 1, 2025</span>
        </div>

        <!-- News Card 2 -->
        <div class="news-card w-[520px] bg-black border border-[#FE04FF] rounded-xl p-4 flex-shrink-0 relative hover:shadow-[0_0_25px_#FE04FF] transition-all duration-500">
          <div class="overflow-hidden rounded-lg border border-[#FE04FF] mb-4">
            <img src="/img/news2.jpg" alt="Nyhed 2" class="w-full h-52 object-cover">
          </div>
          <h3 class="text-xl text-[#FE04FF] font-bold mb-2 animate-neon-flicker">Retro Sci-Fi Week</h3>
          <div class="text-container text-gray-300 text-sm relative overflow-hidden">
            <p>Experience timeless sci-fi classics from the '70s and '80s, all on the big screen. Special Q&A sessions with retro film enthusiasts!</p>
            <div class="fade-overlay absolute bottom-0 left-0 w-full h-12 bg-gradient-to-t from-black"></div>
          </div>
          <span class="mt-2 inline-block text-xs text-[#FFDF00] font-semibold">Dec 3, 2025</span>
        </div>

      </div>

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

<style>
/* Scrollbar skjult */
#newsCarousel::-webkit-scrollbar { display: none; }
#newsCarousel { -ms-overflow-style: none; scrollbar-width: none; }

/* Ens højde på kort */
.news-card {
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  height: 420px;
  min-height: 420px;
}
.news-card img {
  width: 100%;
  height: 208px;
  object-fit: cover;
}

/* Fade overlay for lang tekst */
.text-container { flex: 1; position: relative; }
.fade-overlay { pointer-events: none; }

/* Neon animation */
@keyframes neonFlicker {
  0%,19%,21%,23%,25%,54%,56%,100% { text-shadow: 0 0 2px currentColor, 0 0 6px currentColor, 0 0 12px currentColor, 0 0 20px currentColor; opacity:1; }
  20%,22%,24%,55% { text-shadow:none; opacity:0.9; }
}
.animate-neon-flicker { animation: neonFlicker 2s infinite; }

/* Hover neon-effekt */
.news-card:hover h3 { text-shadow: 0 0 12px #FE04FF, 0 0 25px #FE04FF; }
.news-card:hover { box-shadow: 0 0 25px #FE04FF, 0 0 40px #FE04FF inset; }
</style>

<script>
feather.replace();

const carousel = document.getElementById('newsCarousel');
const prevBtn = document.getElementById('prevNews');
const nextBtn = document.getElementById('nextNews');
const scrollAmount = 320;
let autoScrollInterval;

prevBtn.addEventListener('click', () => { carousel.scrollBy({ left: -scrollAmount, behavior: 'smooth' }); resetAutoScroll(); });
nextBtn.addEventListener('click', () => { carousel.scrollBy({ left: scrollAmount, behavior: 'smooth' }); resetAutoScroll(); });

function startAutoScroll() {
  autoScrollInterval = setInterval(() => {
    if (carousel.scrollLeft + carousel.clientWidth >= carousel.scrollWidth) {
      carousel.scrollTo({ left: 0, behavior: 'smooth' });
    } else {
      carousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
  }, 4000);
}
function resetAutoScroll() { clearInterval(autoScrollInterval); startAutoScroll(); }
startAutoScroll();

// Tilføj forskellig animation-delay til hver kortoverskrift
const newsCards = document.querySelectorAll('.news-card h3.animate-neon-flicker');
newsCards.forEach(card => {
  const randomDelay = (Math.random() * 1.5).toFixed(2); // mellem 0 og 1.5 sek
  card.style.animationDelay = `${randomDelay}s`;
});
</script>




<?php require_once __DIR__ . '/partials/footer.php'; ?>