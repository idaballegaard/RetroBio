/* MOVIE-DETAILS */
feather.replace();

// const showings = <?php echo json_encode($showings); ?>;

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