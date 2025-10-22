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
      <div class="px-3 py-2 hover:bg-[#003133] cursor-pointer text-[#00e7ec]"><?php echo htmlspecialchars($movie->getTitle()); ?></div>
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
    <h1 id="movieTitle" class="text-4xl font-bold text-[#00e7ec] mb-3"><?php echo htmlspecialchars($movie->getTitle()); ?></h1>
    <div class="flex items-center mb-4">
      <i data-feather="star" class="text-[#00e7ec] mr-2"></i>
      <span id="movieRating"><?php echo htmlspecialchars($movie->getRanking()); ?> / 5</span>
    </div>
    <p id="movieDesc" class="text-gray-300 mb-6 leading-relaxed"><?php echo htmlspecialchars($movie->getDescription()); ?></p>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
      <div><span class="text-[#00e7ec]">Release Year:</span> <?php echo $movie->getReleaseYear(); ?></div>
      <div><span class="text-[#00e7ec]">Genre:</span> <?php echo implode(', ', $genres); ?></div>
      <div><span class="text-[#00e7ec]">Length:</span> <?php echo $movie->getLength(); ?> min</div>
      <div><span class="text-[#00e7ec]">Language:</span> <?php echo $movie->getLanguage(); ?></div>
      <div><span class="text-[#00e7ec]">Age Limit:</span> <?php echo $movie->getAgeLimit(); ?>+</div>
      <div><span class="text-[#00e7ec]">Director:</span> <?php echo htmlspecialchars($movie->getDirector()->getFirstName()); ?></div>
      <div><span class="text-[#00e7ec]">Company:</span> <?php echo htmlspecialchars($company); ?></div>
      <div class="col-span-2 md:col-span-3"><span class="text-[#00e7ec]">Main Cast:</span> <?php echo implode(', ', $cast); ?></div>
    </div>
  </div>
</div>
</section>

<script>
feather.replace();

const showings = <?php echo json_encode($showings); ?>;

// Elementer
const movieInput = document.getElementById('movieInput');
const movieDropdown = document.getElementById('movieDropdown');
const movieOptions = movieDropdown.querySelectorAll('div');
const input = document.getElementById('dateInput');
const calendar = document.getElementById('calendar');
const monthYear = document.getElementById('monthYear');
const datesContainer = document.getElementById('dates');
const prevMonthBtn = document.getElementById('prevMonth');
const nextMonthBtn = document.getElementById('nextMonth');
const showtimesDiv = document.getElementById('showtimes');
const detailsSection = document.getElementById('movieDetails');
let currentDate = new Date();
let selectedShowtime = null;

// Book Tickets button
const bookBtn = document.createElement('button');
bookBtn.textContent = "Book Tickets";
bookBtn.disabled = true;
bookBtn.className = "ml-auto bg-amber-400 text-black font-bold px-8 py-3 rounded-lg text-lg shadow-md transition cursor-not-allowed opacity-50";
bookBtn.addEventListener('click',()=>{
  if(!selectedShowtime) return;
  window.location.href=`booking.html?movie=${encodeURIComponent(movieInput.value)}&time=${selectedShowtime.time}`;
});
showtimesDiv.appendChild(bookBtn);

// Dropdown events
movieInput.addEventListener('click',()=>movieDropdown.classList.toggle('hidden'));
movieOptions.forEach(opt=>{
  opt.addEventListener('click',()=>{
    movieInput.value = opt.textContent;
    movieDropdown.classList.add('hidden');
    updateShowtimes();
  });
});
document.addEventListener('click',(e)=>{
  if(!movieInput.contains(e.target)&&!movieDropdown.contains(e.target)) movieDropdown.classList.add('hidden');
});

// Calendar functions
function renderCalendar(date){
  const year = date.getFullYear(), month = date.getMonth();
  const monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
  monthYear.textContent = `${monthNames[month]} ${year}`;
  datesContainer.innerHTML = '';
  const firstDay = new Date(year,month,1).getDay();
  const lastDate = new Date(year,month+1,0).getDate();

  for(let i=0;i<firstDay;i++) datesContainer.appendChild(document.createElement('div'));
  for(let day=1;day<=lastDate;day++){
    const btn = document.createElement('button');
    btn.textContent = day;
    btn.className = 'p-2 rounded hover:bg-[#003133] text-white';
    btn.addEventListener('click',()=>{
      input.value = `${year}-${String(month+1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
      input.dataset.weekday = (firstDay+day-1)%7;
      calendar.classList.add('hidden');
      updateShowtimes();
    });
    datesContainer.appendChild(btn);
  }
}
input.addEventListener('focus',()=>{ calendar.classList.remove('hidden'); renderCalendar(currentDate); });
prevMonthBtn.addEventListener('click',()=>{ currentDate.setMonth(currentDate.getMonth()-1); renderCalendar(currentDate); });
nextMonthBtn.addEventListener('click',()=>{ currentDate.setMonth(currentDate.getMonth()+1); renderCalendar(currentDate); });
document.addEventListener('click',(e)=>{ if(!input.contains(e.target)&&!calendar.contains(e.target)) calendar.classList.add('hidden'); });

// Update showtimes function
function updateShowtimes(){
  const movieName = movieInput.value;
  const dateVal = input.value;
  const weekday = input.dataset.weekday ? parseInt(input.dataset.weekday) : null;

  showtimesDiv.innerHTML = '';
  showtimesDiv.appendChild(bookBtn);
  selectedShowtime = null;
  bookBtn.disabled = true;
  bookBtn.classList.remove('glow'); 
  bookBtn.classList.add('opacity-50','cursor-not-allowed');

  if(!dateVal || weekday===null){
    showtimesDiv.innerHTML = '<p class="text-gray-400 text-sm italic">Choose a date to see available showtimes.</p>';
    showtimesDiv.appendChild(bookBtn);
    return;
  }

  // Filter showings for valgt dato
  const timesForDay = showings.filter(s=>{
    const d = new Date(s.date);
    return d.getFullYear() === new Date(dateVal).getFullYear() &&
           d.getMonth() === new Date(dateVal).getMonth() &&
           d.getDate() === new Date(dateVal).getDate();
  });

  if(timesForDay.length === 0){
    showtimesDiv.innerHTML = '<p class="text-gray-400 text-sm italic">No showtimes available for this date.</p>';
    showtimesDiv.appendChild(bookBtn);
    return;
  }

  // Opret kort for hver showing
  timesForDay.forEach(t=>{
    const card = document.createElement('div');
    card.className = 'border border-[#00e7ec] rounded-lg p-3 min-w-[110px] text-center hover:bg-[#00e7ec] hover:text-black transition cursor-pointer';
    card.innerHTML = `
      <div class="font-semibold showtime-time">${t.startTime}</div>
      <div class="text-xs showtime-hall text-gray-300">${t.hallName}</div>
      <div class="text-sm showtime-price text-amber-400 mt-1">${t.price} kr</div>
    `;

    // Hover
    card.addEventListener('mouseenter', ()=>{
      card.querySelectorAll('.showtime-time, .showtime-hall, .showtime-price').forEach(el=>{
        el.classList.add('text-black');
        el.classList.remove('text-gray-300','text-amber-400');
      });
    });
    card.addEventListener('mouseleave', ()=>{
      if(selectedShowtime !== t){
        card.querySelectorAll('.showtime-time, .showtime-hall, .showtime-price').forEach(el=>{
          el.classList.remove('text-black');
          if(el.classList.contains('showtime-hall')) el.classList.add('text-gray-300');
          if(el.classList.contains('showtime-price')) el.classList.add('text-amber-400');
        });
      }
    });

    // Klik for at vælge
    card.addEventListener('click', ()=>{
      document.querySelectorAll('#showtimes div').forEach(c=>{
        c.classList.remove('bg-[#00e7ec]','text-black');
        c.querySelectorAll('.showtime-hall').forEach(h=>{h.classList.remove('text-black'); h.classList.add('text-gray-300');});
        c.querySelectorAll('.showtime-price').forEach(p=>{p.classList.remove('text-black'); p.classList.add('text-amber-400');});
      });

      card.classList.add('bg-[#00e7ec]','text-black');
      card.querySelectorAll('.showtime-hall, .showtime-price').forEach(el=>{
        el.classList.add('text-black');
        el.classList.remove('text-gray-300','text-amber-400');
      });

      selectedShowtime = t;
      bookBtn.disabled = false;
      bookBtn.classList.remove('opacity-50','cursor-not-allowed');
      bookBtn.classList.add('glow');
    });

    showtimesDiv.insertBefore(card, bookBtn);
  });
}
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>