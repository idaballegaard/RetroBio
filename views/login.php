<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="min-h-screen flex items-center justify-center bg-black pt-20">
    <div class="w-full max-w-md p-8 bg-black border border-[#FE04FF] rounded-xl shadow-[0_0_25px_#FE04FF]">
        <h2 class="text-3xl font-bold text-[#FE04FF] mb-6 text-center animate-neon-flicker">RetroBio Login</h2>
        
        <form action="login" method="POST" class="space-y-4">
            <!-- Username / Email -->
            <div>
                <label for="username" class="block text-[#FFDF00] font-semibold mb-1">Username or Email</label>
                <input type="text" id="username" name="username" required 
                       class="w-full p-3 rounded-lg border border-[#FFDF00] bg-black text-[#FFDF00] placeholder-[#FE04FF] focus:outline-none focus:ring-2 focus:ring-[#FE04FF]">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-[#FFDF00] font-semibold mb-1">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full p-3 rounded-lg border border-[#FFDF00] bg-black text-[#FFDF00] placeholder-[#FE04FF] focus:outline-none focus:ring-2 focus:ring-[#FE04FF]">
            </div>

            <!-- Login Button -->
            <button type="submit" 
                    class="w-full py-3 bg-black border border-[#FE04FF] text-[#FE04FF] font-bold rounded-lg hover:bg-[#FE04FF] hover:text-black transition-all duration-300 shadow-[0_0_15px_#FE04FF]">
                Log In
            </button>
        </form>

        <?php
        if (isset($_SESSION['error'])) {
            echo '<p class="text-red-500 text-sm mb-2">'.$_SESSION['error'].'</p>';
            unset($_SESSION['error']);
        }
        ?>

        <!-- Divider -->
        <div class="text-center text-gray-400 my-4 relative">
            <span class="bg-black px-2 relative z-10">OR</span>
            <hr class="absolute top-1/2 left-0 w-full border-t border-[#FE04FF] opacity-50">
        </div>

        <!-- Register Link -->
        <p class="text-center text-[#FFDF00]">
            Don't have an account? 
            <a href="register.php" class="text-[#FE04FF] hover:underline">Sign Up</a>
        </p>
    </div>
</div>

<style>
/* Neon flicker animation for headings */
@keyframes neonFlicker {
    0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% {
        text-shadow: 0 0 4px #FE04FF, 0 0 10px #FE04FF;
    }
    20%, 24%, 55% {
        text-shadow: none;
    }
}

.animate-neon-flicker {
    animation: neonFlicker 1.5s infinite alternate;
}
</style>

<?php require_once __DIR__ . '/partials/footer.php'; ?>