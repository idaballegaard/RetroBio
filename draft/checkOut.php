<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>RetroBio — Checkout</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root{
      --neon-yellow:#FFDF00;
      --neon-cyan:#00e7ec;
      --neon-pink:#FE04FF;
      --bg:#000000;
    }
    body{ background:var(--bg); }
    .panel { background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(0,0,0,0.35)); border:1px solid rgba(255,255,255,0.03); }
    .price { font-weight:700; }
    .muted { color:#9ca3af; }
    .neon-yellow { color:var(--neon-yellow); }
  </style>
</head>
<body class="min-h-screen text-white font-sans">
  <main class="container mx-auto px-6 py-12">
    <!-- Header: movie + hall -->
    

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Left: Order summary -->
      <section class="lg:col-span-2 panel p-6 rounded-xl">
        <div class="flex gap-6">
          <div class="w-32 h-44 overflow-hidden rounded-lg border border-[#00e7ec] flex-shrink-0">
            <img src="/mnt/data/Skærmbillede 2025-11-24 kl. 11.21.01.png" alt="Poster" class="w-full h-full object-cover">
          </div>
          <div class="flex-1">
            <h2 class="text-xl font-bold neon-yellow mb-1">Movie title — special screening</h2>
            <p class="muted text-sm mb-4">Fri 26 Nov • 19:30 • Hall 1</p>

            <div class="mb-4">
              <h3 class="font-semibold text-[#00e7ec] mb-2">Tickets & seats</h3>
              <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                  <div>Adult × 2</div>
                  <div>DKK 300</div>
                </div>
                <div class="flex justify-between">
                  <div>Child × 0</div>
                  <div>DKK 0</div>
                </div>
                <div class="flex justify-between">
                  <div>Senior × 0</div>
                  <div>DKK 0</div>
                </div>
                <div class="pt-2 border-t border-[#0b1220]">
                  <div class="flex justify-between mt-2">
                    <div class="muted">Selected seats</div>
                    <div id="summary-seats" class="font-semibold">R4S5 • R4S6</div>
                  </div>
                </div>
              </div>
            </div>

            <div>
              <h3 class="font-semibold text-[#00e7ec] mb-2">Extras</h3>
              <div class="flex items-center gap-4">
                
                <label class="inline-flex items-center gap-2 text-sm muted">
                  <input id="donation" type="checkbox" class="rounded bg-gray-800" /> <span>Donation to film club (DKK 10)</span>
                </label>
              </div>
            </div>

          </div>
        </div>

        <!-- Notes -->
        <div class="mt-6 text-xs muted">
          <p><strong>Note:</strong> Tickets are non-refundable. Please arrive 15 minutes before start time.</p>
        </div>
      </section>

      <!-- Right: Payment box -->
      <aside class="panel p-6 rounded-xl">
        <h2 class="text-2xl font-bold text-[#00e7ec] mb-4">Payment</h2>

        <div class="space-y-3 mb-4">
          <div class="flex justify-between text-sm muted">
            <div>Subtotal</div>
            <div id="subtotal">DKK 300</div>
          </div>
          <div class="flex justify-between text-sm muted">
            <div>Extras</div>
            <div id="extras-amt">DKK 0</div>
          </div>
          <div class="flex justify-between text-sm muted">
            <div>Fee</div>
            <div id="fee">DKK 20</div>
          </div>
          <div class="flex justify-between text-lg price pt-3 border-t border-[#0b1220]">
            <div>Total</div>
            <div id="total">DKK 320</div>
          </div>
        </div>

        <div class="mb-4">
          <label class="block text-xs muted mb-2">Cardholder name</label>
          <input id="card-name" class="w-full p-2 rounded bg-black border border-gray-500 text-sm" placeholder="Marty McFly" />
        </div>
        <div class="mb-4">
          <label class="block text-xs muted mb-2">Card number</label>
          <input id="card-number" class="w-full p-2 rounded bg-black border border-gray-500 text-sm" placeholder="1234 1234 1234 1234" />
        </div>
        <div class="flex gap-3 mb-4">
          <div class="flex-1">
            <label class="block text-xs muted mb-2">Expiry</label>
            <input id="card-exp" class="w-full p-2 rounded bg-black border border-gray-500 text-sm" placeholder="MM/YY" />
          </div>
          <div class="w-24">
            <label class="block text-xs muted mb-2">CVC</label>
            <input id="card-cvc" class="w-full p-2 rounded bg-black border border-gray-500 text-sm" placeholder="123" />
          </div>
        </div>

        <div class="mb-4">
          <button id="pay-btn" class="w-full py-3 rounded bg-[#FFDF00] text-black font-bold hover:bg-[#e6c800] transition"w-full py-3 rounded bg-[#FFDF00] text-black font-bold">Pay DKK 320</button>

        <button id="back-btn" class="w-full mt-3 py-2 rounded bg-gray-700 text-white text-sm hover:bg-gray-600 transition"w-full mt-3 py-2 rounded bg-gray-700 text-white text-sm">Back to seat selection</button>

      </aside>
    </div>
  </main>

  <script>
    // Simple demo logic to keep totals in sync
    const subtotalEl = document.getElementById('subtotal');
    const totalEl = document.getElementById('total');
    const extrasAmtEl = document.getElementById('extras-amt');
    const feeEl = document.getElementById('fee');
    const payBtn = document.getElementById('pay-btn');
    const donation = document.getElementById('donation');
    const backBtn = document.getElementById('back-btn');

    let subtotal = 300;
    let extras = 0;
    const fee = 20;

    function recompute(){
      // Guard: if donation checkbox not present, treat as unchecked
      const donationChecked = (donation && donation.checked) ? true : false;
      extras = donationChecked ? 10 : 0;
      extrasAmtEl.textContent = 'DKK ' + extras;
      subtotalEl.textContent = 'DKK ' + subtotal;
      feeEl.textContent = 'DKK ' + fee;
      totalEl.textContent = 'DKK ' + (subtotal + extras + fee);
      payBtn.textContent = 'Pay ' + totalEl.textContent;
    }

    // Ensure event listener exists (in case DOM refs were broken earlier)
    if(donation){
      donation.addEventListener('change', recompute);
    }

    document.getElementById('pay-btn').addEventListener('click', ()=>{
      // In real app validate card + call backend
      alert('Payment simulated. Check console for order payload.');
      const order = {
        seats: document.getElementById('summary-seats').textContent,
        tickets: { adult:2, child:0, senior:0 },
        extras: { donation: donation ? donation.checked : false },
        amount: totalEl.textContent
      };
      console.log('Order', order);
      // Redirect to receipt page (demo)
      window.location.href = '/receipt.html';
    });

    backBtn.addEventListener('click', ()=>{
      window.history.back();
    });

    // Initial compute
    recompute();
  </script>
</body>
</html>
