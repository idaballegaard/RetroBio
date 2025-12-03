<?php require_once __DIR__ . "/partials/header.php"; ?>

<section class="relative min-h-[70vh] flex items-center justify-center bg-black text-white px-6">
  <div class="absolute inset-0 pointer-events-none">
    <div class="absolute inset-0 bg-gradient-to-r from-[#FFDF00]/20 via-[#FE04FF]/10 to-[#00e7ec]/20 blur-3xl"></div>
  </div>

  <div class="relative z-10 max-w-3xl w-full text-center">
    <h1 id="thank-heading" class="text-5xl sm:text-6xl md:text-7xl font-extrabold tracking-tight mb-4 text-[#FFDF00]">Booking Confirmed!</h1>
    <p class="text-lg sm:text-xl italic text-[#00e7ec] mb-6">Your booking is complete — and safely stored in your RetroBio profile. Get ready for a great movie experience with a touch of retro charm!</p>

    <?php if(!empty($bookingReference)): ?>
      <div class="inline-block bg-black border border-[#00e7ec] rounded-lg px-6 py-3 mb-4">
        <span class="text-sm text-gray-300 mr-2">Reference:</span>
        <span class="font-mono text-[#FFDF00] font-semibold"><?php echo htmlspecialchars($bookingReference); ?></span>
      </div>
    <?php endif; ?>

    <div class="flex items-center justify-center gap-4 mt-4">
      <a href="<?php echo generateUrl(''); ?>" class="inline-block bg-black text-[#FFDF00] border border-[#FFDF00] px-6 py-3 rounded-lg font-semibold hover:bg-[#FFDF00] hover:text-black transition">Home</a>
      <a href="<?php echo generateUrl('profile'); ?>" class="inline-block bg-black text-[#FE04FF] border border-[#FE04FF] px-6 py-3 rounded-lg font-semibold hover:bg-[#FE04FF] hover:text-black transition">Your Profile</a>
      <a href="<?php echo generateUrl('movie-details'); ?>" class="inline-block bg-black text-[#00e7ec] border border-[#00e7ec] px-6 py-3 rounded-lg font-semibold hover:bg-[#00e7ec] hover:text-black transition">Browse Movies</a>
    </div>

  </div>
</section>

<?php require_once __DIR__ . '/partials/footer.php'; ?>

<!-- Minimal JS: varm, subtil flicker på overskriften (meget let) -->
<script>
(function(){
  const el = document.getElementById('thank-heading');
  if(!el) return;
  const flickerOnce = () => {
    el.style.opacity = '0.15';
    setTimeout(()=> el.style.opacity = '1', 80 + Math.random()*180);
  };
  // Kør et par diskrete flickers for effekt
  setTimeout(flickerOnce, 300);
  setTimeout(flickerOnce, 900);
  // og ét sidstnævnt senere
  setTimeout(flickerOnce, 2200);
})();
</script>