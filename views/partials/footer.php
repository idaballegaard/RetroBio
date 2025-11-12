<footer class="bg-black border-t border-[#FFDF00]/50 py-12">

    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
        
        <!-- Kolonne 1: Logo -->
        <div class="footer-col">
            <a href="/RetroBio/Views/index.php" class="film-logo glow text-[#FFDF00] font-bold text-2xl mb-2">RetroBio</a>
            <p class="text-[#FE04FF] text-sm mt-2">
                A vintage escape for true film lovers – Because great movies never die.
            </p>
        </div>

        <!-- Kolonne 2: Links -->
        <div class="footer-col">
            <h3 class="text-[#FFDF00] font-semibold mb-4">Links</h3>
            <ul class="space-y-2">
                <li><a href="/RetroBio/Views/index.php" class="text-[#FFDF00] hover:text-[#FE04FF] transition duration-300">Home</a></li>
                <li><a href="/RetroBio/Views/movie.php" class="text-[#FFDF00] hover:text-[#FE04FF] transition duration-300">Movies</a></li>
                <li><a href="/RetroBio/Views/contact.php" class="text-[#FFDF00] hover:text-[#FE04FF] transition duration-300">Contact</a></li>
            </ul>
        </div>

        <!-- Kolonne 3: Sociale links -->
        <div class="footer-col">
            <h3 class="text-[#FFDF00] font-semibold mb-4">Follow us</h3>
            <div class="flex justify-center md:justify-start space-x-4">
                <a href="#" class="text-[#FFDF00] hover:text-[#FE04FF] transition duration-300">
                    <i data-feather="facebook"></i>
                </a>
                <a href="#" class="text-[#FFDF00] hover:text-[#FE04FF] transition duration-300">
                    <i data-feather="twitter"></i>
                </a>
                <a href="#" class="text-[#FFDF00] hover:text-[#FE04FF] transition duration-300">
                    <i data-feather="instagram"></i>
                </a>
            </div>
        </div>
    </div>

    <p class="text-[#FE04FF] text-sm text-center mt-8">&copy; <?php echo date("Y"); ?> RetroBio. All rights reserved.</p>
</footer>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    feather.replace();
  });
</script>

<script src="assets/script.js"></script>
</body>
</html>
