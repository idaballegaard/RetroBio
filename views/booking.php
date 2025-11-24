<?php
/** @var BookingViewModel $viewModel */
$showing = $viewModel->getShowing();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>RetroBio — Seat Selection</title>
  <!-- Tailwind CDN for quick prototype (replace with your build in production) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Theme tokens that match your site */
    :root{
      --neon-yellow:#FFDF00;
      --neon-cyan:#00e7ec;
      --neon-pink:#FE04FF;
      --muted:#0f1720; /* dark background */
      --panel:#0b1220;
    }

    /* Small seat visuals (we use rounded-2xl to mimic comfy seats) */
    .seat {
      width:36px; height:28px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;
      box-shadow: inset 0 -2px 0 rgba(0,0,0,.4);
      transition:transform .12s ease, box-shadow .12s ease;
    }

    /* Neon focus for keyboard users */
    .seat:focus{ outline:3px solid rgba(0,231,236,.25); }

    /* Seat states */
    .seat--available{ background:linear-gradient(180deg,#1f2937,#111827); border:2px solid rgba(255,255,255,.04); }
    .seat--sold{ background:linear-gradient(180deg,#a62020,#7b0f0f); color:white; border:2px solid rgba(0,0,0,.6); cursor:not-allowed; box-shadow:0 4px 12px rgba(167,32,32,.08); }
    .seat--selected{ background:linear-gradient(180deg,var(--neon-yellow),#e6d300); color:#111; border:2px solid rgba(255,255,255,.9); transform:translateY(-6px); box-shadow:0 10px 30px rgba(255,223,0,.18); }
    .seat--hover{ transform:translateY(-4px); box-shadow:0 8px 22px rgba(0,0,0,.25); }

    /* Screen bar */
    .screen {
      height:10px; background:linear-gradient(90deg, rgba(255,255,255,.08), rgba(255,255,255,.02)); border-radius:6px; position:relative;
    }
    .screen-label{ position:absolute; top:-28px; left:50%; transform:translateX(-50%); background:transparent; color:var(--neon-cyan); font-weight:700; letter-spacing:2px; }
    .screen-wrap{ position:relative; display:flex; align-items:center; justify-content:center; }

    /* Nice subtle glass panel */
    .panel { background:linear-gradient(180deg, rgba(255,255,255,.02), rgba(0,0,0,.35)); border:1px solid rgba(255,255,255,.03); }

  </style>
</head>
<body class="min-h-screen bg-black text-white" style="font-family:Inter,ui-sans-serif,system-ui,sans-serif">
  <!-- Top header (uses your hero palette) -->
  <!-- Top info bar: movie + hall -->
<header class="py-6 px-6 border-b border-[#0b1220]">
  <div class="container mx-auto flex items-center justify-between">
    <div class="flex flex-col">
      <h1 class="text-2xl font-extrabold text-[var(--neon-yellow)]"><?php echo safeString($showing->getMovie()->getTitle()); ?></h1>
      <span class="text-sm text-gray-300"><?php echo safeString($showing->getMovie()->getLength()); ?> minutes • <?php echo safeString(implode(", ", $showing->getMovie()->getGenres())); ?> • <?php echo safeString($showing->getMovie()->getReleaseYear()); ?></span>
    </div>
    <div class="text-sm text-gray-300">Hall: <span class="font-semibold text-[#00e7ec]"><?php echo safeString($showing->getHall()->getNumber()); ?></span></div>
  </div>
</header>

  <main class="container mx-auto px-6 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Left: ticket controls -->
      <aside class="panel p-6 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-[#00e7ec]">Choose tickets</h2>

        <div class="mt-6 space-y-4">
          <div class="flex items-center justify-between">
            <div>
              <div class="font-semibold">Adult</div>
              <div class="text-xs text-gray-400">150 DKK incl. fee</div>
            </div>
            <div class="flex items-center gap-2">
              <button id="dec-normal" class="px-2 py-1 rounded-md bg-gray-800">−</button>
              <div id="count-normal" class="w-8 text-center">2</div>
              <button id="inc-normal" class="px-2 py-1 rounded-md bg-[#00e7ec] text-black">+</button>
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div>
              <div class="font-semibold">Child &lt;12</div>
              <div class="text-xs text-gray-400">110 DKK incl. fee</div>
            </div>
            <div class="flex items-center gap-2">
              <button id="dec-child" class="px-2 py-1 rounded-md bg-gray-800">−</button>
              <div id="count-child" class="w-8 text-center">0</div>
              <button id="inc-child" class="px-2 py-1 rounded-md bg-[#00e7ec] text-black">+</button>
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div>
              <div class="font-semibold">Senior</div>
              <div class="text-xs text-gray-400">125 DKK incl. fee</div>
            </div>
            <div class="flex items-center gap-2">
              <button id="dec-senior" class="px-2 py-1 rounded-md bg-gray-800">−</button>
              <div id="count-senior" class="w-8 text-center">0</div>
              <button id="inc-senior" class="px-2 py-1 rounded-md bg-[#00e7ec] text-black">+</button>
            </div>
          </div>

          <div class="mt-4 text-sm text-gray-400">Select the same number of seats as tickets. Your selected seats appear to the right.</div>
        </div>

        <div class="mt-6 border-t border-[#0b1220] pt-4 flex items-center justify-between">
          <div>
            <div class="text-xs text-gray-400">Selected tickets</div>
            <div id="total-count" class="font-bold text-lg">2</div>
          </div>
          <div>
            <div class="text-xs text-gray-400">Price</div>
            <div id="total-price" class="font-bold text-lg">DKK 300</div>
          </div>
        </div>

      </aside>

      <!-- Middle: seat map -->
      <section class="lg:col-span-2 panel p-6 rounded-xl">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h3 class="text-2xl font-bold text-[#FFDF00]">Choose seats</h3>
          </div>
        </div>

        <div class="mb-6">
          <div class="screen-wrap mb-3">
            <div class="screen w-full mx-auto"></div>
            <div class="screen-label">SCREEN</div>
          </div>

          <!-- Seats grid container -->

          <div id="seat-map" class="w-full flex flex-col items-center gap-3">
          </div>

          <!-- Legend -->
          <div class="mt-6 flex items-center gap-6 text-sm text-gray-300">
            <div class="flex items-center gap-2"><span class="seat seat--sold" style="width:18px;height:14px"></span> Sold</div>
            <div class="flex items-center gap-2"><span class="seat seat--selected" style="width:18px;height:14px;background:linear-gradient(180deg,var(--neon-yellow),#e6d300);border:1px solid rgba(0,0,0,.1);"></span> Your seats</div>
          </div>
        </div>

        <!-- Selected seats summary & next button -->
        <div class="flex items-center justify-between border-t border-[#0b1220] pt-4">
          <div class="text-sm text-gray-300">Selected seats: <span id="selected-list" class="font-semibold text-white">Row 4 • 5</span></div>
          <div class="flex items-center gap-4">
            <button id="reset-btn" class="px-4 py-2 rounded-md bg-gray-800">Reset</button>
            <button id="next-btn" class="px-6 py-2 rounded-md bg-[#00e7ec] text-black font-semibold">Next</button>
          </div>
        </div>

      </section>
    </div>
  </main>

  <script>
    /* Configuration for the map (rows, seats per row, and reserved seats) */
    const rows = <?php echo json_encode($viewModel->getSeatMap()); ?>;
    
    /* Example seat metadata (sold) -- in real app replace with API data */
    // const sold = new Set(['1-3','1-4','2-8','3-7','4-9']);
    const sold = new Set();

    // State
    let selected = new Set();
    let hoverBlock = null; // {row, start, end}

    // Ticket counts (matching left panel)
    const ticketCounts = { normal:2, child:0, senior:0 };

    function formatSeatId(r,c){ return `${r}-${c}` }

    // --- Build seat map ---
    const seatMapEl = document.getElementById('seat-map');
    rows.forEach(row=>{
      const rowEl = document.createElement('div');
      rowEl.className = 'flex items-center gap-3';

      // row label
      const label = document.createElement('div');
      label.className = 'w-6 text-sm text-gray-300';
      label.textContent = row.id;
      rowEl.appendChild(label);

      // seats container
      const seatsContainer = document.createElement('div');
      seatsContainer.className = 'flex gap-2 flex-wrap';

      for(let i=1;i<=row.seats;i++){
        const id = formatSeatId(row.id,i);
        const btn = document.createElement('button');
        btn.type='button';
        btn.className = 'seat seat--available';
        btn.setAttribute('data-seat', id);
        btn.setAttribute('data-row', row.id);
        btn.setAttribute('data-col', i);
        btn.setAttribute('aria-label', `Row ${row.id}, Seat ${i}`);
        btn.tabIndex=0;

        // Visual variants
        if(sold.has(id)){
          btn.classList.add('seat--sold');
          btn.disabled = true;
        }

        // Hover behavior: show potential contiguous block equal to ticket count
        btn.addEventListener('mouseenter', (e)=> onSeatHover(row.id, i, btn));
        btn.addEventListener('mouseleave', (e)=> clearHoverBlock());

        // Click: if a hover block exists, select that block
        btn.addEventListener('click', ()=> onSeatClick(row.id, i));

        btn.innerHTML = '<span class="text-[10px]">' + i + '</span>';
        seatsContainer.appendChild(btn);
      }

      rowEl.appendChild(seatsContainer);
      seatMapEl.appendChild(rowEl);
    });

    // --- Hover / selection logic ---
    function getTotalTickets(){ return ticketCounts.normal + ticketCounts.child + ticketCounts.senior; }

    // Try to find a contiguous block of length `len` that includes `colIndex` in row `rowId`.
    // Preference: centered on hovered seat, but will shift left/right to find space.
    function findContiguousBlock(rowId, colIndex, len){
      if(len <= 0) return null;
      const row = rows.find(r=>r.id===rowId);
      if(!row) return null;

      // Helper to check if block [s..e] is valid (no sold)
      function blockValid(s,e){
        if(s<1 || e>row.seats) return false;
        for(let c=s;c<=e;c++){
          if(sold.has(formatSeatId(rowId,c))) return false;
        }
        return true;
      }

      // Start try: center the block around colIndex
      const halfLeft = Math.floor((len-1)/2);
      const centerStart = colIndex - halfLeft;

      // We'll attempt offsets from 0..row.seats to shift left/right
      for(let offset=0; offset<=row.seats; offset++){
        // try shifted left
        let s = centerStart - offset;
        let e = s + len - 1;
        if(blockValid(s,e)) return {row:rowId, start:s, end:e};
        // try shifted right
        s = centerStart + offset;
        e = s + len - 1;
        if(blockValid(s,e)) return {row:rowId, start:s, end:e};
      }
      return null;
    }

    function highlightBlock(block){
      clearHoverBlock();
      if(!block) return;
      hoverBlock = block;
      for(let c=block.start; c<=block.end; c++){
        const sel = document.querySelector(`[data-seat='${formatSeatId(block.row,c)}']`);
        if(sel && !sel.classList.contains('seat--sold')) sel.classList.add('seat--hover');
      }
    }

    function clearHoverBlock(){
      if(!hoverBlock) return;
      for(let c=hoverBlock.start; c<=hoverBlock.end; c++){
        const sel = document.querySelector(`[data-seat='${formatSeatId(hoverBlock.row,c)}']`);
        if(sel) sel.classList.remove('seat--hover');
      }
      hoverBlock = null;
    }

    function onSeatHover(rowId, colIndex, btn){
      const len = getTotalTickets();
      if(len === 0) return; // nothing to highlight
      const block = findContiguousBlock(rowId, colIndex, len);
      highlightBlock(block);
    }

    function onSeatClick(rowId, colIndex){
      const len = getTotalTickets();
      if(len === 0) { alert('Please choose ticket quantity first.'); return; }
      const block = findContiguousBlock(rowId, colIndex, len);
      if(!block){
        // no contiguous block available including this seat
        alert('Cannot find a contiguous group of seats here. Try another spot.');
        return;
      }

      // Deselect previous selection
      selected.forEach(s=>{ const el = document.querySelector(`[data-seat='${s}']`); if(el) el.classList.remove('seat--selected'); });
      selected.clear();

      // Select new block
      for(let c=block.start; c<=block.end; c++){
        const id = formatSeatId(block.row,c);
        const el = document.querySelector(`[data-seat='${id}']`);
        if(el && !el.classList.contains('seat--sold')){
          el.classList.add('seat--selected');
          selected.add(id);
        }
      }
      refreshSelectedList();
    }

    // --- Existing functions ---
    function updateTotals(){
      const total = getTotalTickets();
      document.getElementById('total-count').textContent = total;
      const price = ticketCounts.normal*150 + ticketCounts.child*110 + ticketCounts.senior*125;
      document.getElementById('total-price').textContent = 'DKK ' + price;

      // If selected seats > tickets, deselect all (ensures consistent UX)
      if(selected.size > total){
        selected.forEach(s=>deselectSeat(s));
      }
    }

    function deselectSeat(seatId){
      selected.delete(seatId);
      const btn = document.querySelector(`[data-seat='${seatId}']`);
      if(btn){ btn.classList.remove('seat--selected'); }
      refreshSelectedList();
    }

    function refreshSelectedList(){
      const arr = Array.from(selected).map(s=>{
        const [r,c] = s.split('-'); return `R${r}S${c}`;
      });
      const selectedListEl = document.getElementById('selected-list');
      selectedListEl.textContent = arr.length ? arr.join(' • ') : 'None';
      // color selected-list yellow when seats selected
      selectedListEl.style.color = arr.length ? getComputedStyle(document.documentElement).getPropertyValue('--neon-yellow') : '';

      document.getElementById('total-count').textContent = getTotalTickets();
      document.getElementById('count-normal').textContent = ticketCounts.normal;
      document.getElementById('count-child').textContent = ticketCounts.child;
      document.getElementById('count-senior').textContent = ticketCounts.senior;
      const price = ticketCounts.normal*150 + ticketCounts.child*110 + ticketCounts.senior*125;
      document.getElementById('total-price').textContent = 'DKK ' + price;
    }

    // Wire increment/decrement
    document.getElementById('inc-normal').addEventListener('click', ()=>{ ticketCounts.normal++; refreshSelectedList(); });
    document.getElementById('dec-normal').addEventListener('click', ()=>{ if(ticketCounts.normal>0) ticketCounts.normal--; refreshSelectedList(); });
    document.getElementById('inc-child').addEventListener('click', ()=>{ ticketCounts.child++; refreshSelectedList(); });
    document.getElementById('dec-child').addEventListener('click', ()=>{ if(ticketCounts.child>0) ticketCounts.child--; refreshSelectedList(); });
    document.getElementById('inc-senior').addEventListener('click', ()=>{ ticketCounts.senior++; refreshSelectedList(); });
    document.getElementById('dec-senior').addEventListener('click', ()=>{ if(ticketCounts.senior>0) ticketCounts.senior--; refreshSelectedList(); });

    document.getElementById('reset-btn').addEventListener('click', ()=>{
      selected.forEach(s=>deselectSeat(s));
      selected.clear();
      refreshSelectedList();
    });

    document.getElementById('next-btn').addEventListener('click', ()=>{
      const totalTickets = getTotalTickets();
      if(selected.size !== totalTickets){
        alert('Please select exactly ' + totalTickets + ' seats before continuing.');
        return;
      }
      // Proceed: here you would POST selection to server
      const payload = { seats:Array.from(selected), tickets:ticketCounts };
      console.log('Proceed with', payload);
      alert('Proceeding to payment — check console (dev).');
    });

    // Init
    refreshSelectedList();

  </script>
</body>
</html>
