<!-- footer.php -->
<footer class="bg-black border-t border-[#FFDF00]/50 py-12">
    <!-- CSS for logo, glow og pseudo-bokse -->
    <style>
        .film-logo {
            position: relative;
            display: inline-block;
            padding: 4px 10px;
            border: 2px solid #FFDF00;
            border-radius: 6px;
            box-shadow: 0 0 10px #FFDF00, 0 0 20px #FFDF0033;
            background-color: #000;
            letter-spacing: 1px;
        }

        .film-logo::before,
        .film-logo::after {
            content: "";
            position: absolute;
            top: 3px;
            bottom: 3px;
            width: 6px;
            background-color: #000;
            border: 2px solid #FFDF00;
        }

        .film-logo::before { left: -12px; }
        .film-logo::after { right: -12px; }

        .glow {
            text-shadow: 0 0 8px #FFDF00, 0 0 12px #FFDF0033;
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
        
        <!-- Kolonne 1: Logo -->
        <div class="footer-col">
            <a href="/index.php" class="film-logo glow text-[#FFDF00] font-bold text-2xl mb-2">RetroBio</a>
            <p class="text-[#FE04FF] text-sm mt-2">
                A vintage escape for true film lovers – Because great movies never die.
            </p>
        </div>

        <!-- Kolonne 2: Links -->
        <div class="footer-col">
            <h3 class="text-[#FFDF00] font-semibold mb-4">Links</h3>
            <ul class="space-y-2">
                <li><a href="/index.php" class="text-[#FFDF00] hover:text-[#FE04FF] transition duration-300">Home</a></li>
                <li><a href="/movie.php" class="text-[#FFDF00] hover:text-[#FE04FF] transition duration-300">Movies</a></li>
                <li><a href="/news.php" class="text-[#FFDF00] hover:text-[#FE04FF] transition duration-300">News</a></li>
                <li><a href="/contact.php" class="text-[#FFDF00] hover:text-[#FE04FF] transition duration-300">Contact</a></li>
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

    <!-- Copyright -->
    <p class="text-[#FE04FF] text-sm text-center mt-8">&copy; <?php echo date("Y"); ?> RetroBio. All rights reserved.</p>
</footer>

<!-- Feather icons -->
<script>
  feather.replace();
</script>

