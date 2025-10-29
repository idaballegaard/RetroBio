/* NAVBAR */
const menuBtn = document.getElementById('menu-btn');
const mobileMenu = document.getElementById('mobile-menu');
menuBtn.addEventListener('click', () => {
mobileMenu.classList.toggle('hidden');
});

/* FRONTPAGE HERO */
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

window.addEventListener('resize', ()=>{
    heroWidth = hero.offsetWidth;
    heroHeight = hero.offsetHeight;
});


/* FRONTPAGE CALENDAR */
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

function filterMovies(button) {
    const selectedDate = button.textContent;
    const showings = document.querySelectorAll('[data-showing-date]');
    document.querySelectorAll('.filter-button').forEach(btn => {
        btn.classList.remove('active');
    });
    button.classList.add('active');
    showings.forEach(showing => {
        if (showing.getAttribute('data-showing-date') === selectedDate) {
            showing.style.setProperty('display', 'block', 'important');
        } else {
          console.log("Hiding showing for date: " + showing.getAttribute('data-showing-date'));
            showing.style.setProperty('display', 'none', 'important');
        }
    });
}
document.querySelectorAll('.filter-button')[0].click();