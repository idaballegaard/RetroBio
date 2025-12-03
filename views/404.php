<?php require_once __DIR__ . '/partials/header.php'; ?>

<!-- Simple Tailwind-only 404 page for RetroBio -->
<section class="relative min-h-[70vh] flex items-center justify-center bg-black text-white px-6">
  <!-- Subtle neon background glow -->
  <div class="absolute inset-0 pointer-events-none">
    <div class="absolute inset-0 bg-gradient-to-r from-[#FFDF00]/20 via-[#FE04FF]/10 to-[#00e7ec]/20 blur-3xl"></div>
  </div>

  <div class="relative z-10 max-w-4xl w-full text-center">
    <h1 id="error-code" class="text-8xl sm:text-9xl font-extrabold tracking-tight mb-4 text-[#FFDF00] drop-shadow-lg">404</h1>
    <p class="text-xl sm:text-2xl italic text-[#00e7ec] mb-6">Reel not found — the film took a wrong turn.</p>

    <div class="flex items-center justify-center gap-4">
        <a href="<?php echo generateUrl(''); ?>"
            class="inline-block bg-black text-[#FFDF00] border border-[#FFDF00] px-6 py-3 rounded-lg font-semibold hover:bg-[#FFDF00] hover:text-black transition">
            Home
        </a>

        <a href="<?php echo generateUrl('movie-details'); ?>"
            class="inline-block bg-black text-[#FE04FF] border border-[#FE04FF] px-6 py-3 rounded-lg font-semibold hover:bg-[#FE04FF] hover:text-black transition">
            Browse Movies
        </a>
    </div>

  </div>
</section>

<!-- Minimal JS: gentle flicker for the big 404 heading -->
<script>
// Very small flicker effect implemented with minimal JS — no external libs.
(function(){
  const el = document.getElementById('error-code');
  if(!el) return;

  // Define short random flicker pattern
  const flicker = () => {
    // Occasionally skip flicker to keep it subtle
    if(Math.random() > 0.7) return;
    el.style.opacity = '0.15';
    setTimeout(()=> el.style.opacity = '1', 80 + Math.random()*180);
  };

  // Run flicker at random intervals
  let running = true;
  const loop = () => {
    if(!running) return;
    flicker();
    setTimeout(loop, 400 + Math.random()*1600);
  };
  loop();

  // Stop flicker once page is hidden to save cycles
  document.addEventListener('visibilitychange', ()=> running = !document.hidden);
})();
</script>


<?php require_once __DIR__ . '/partials/footer.php'; ?>