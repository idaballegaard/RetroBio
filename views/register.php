<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="min-h-screen flex items-center justify-center pt-20 px-4">
    <div class="w-full max-w-4xl p-6 bg-black border border-[#FE04FF] rounded-xl shadow-[0_0_25px_#FE04FF]">
        <h2 class="text-2xl md:text-3xl font-bold text-[#FE04FF] mb-4 md:mb-6 text-center animate-neon-flicker">RetroBio Sign Up</h2>

        <?php
        // Gem tidligere indtastede værdier
        $old = $_SESSION['old'] ?? [];
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['old'], $_SESSION['error']);
        ?>

        <form action="<?php generateUrl("register") ?>" method="POST" class="space-y-3 md:space-y-4">

            <!-- Name Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label for="first_name" class="block text-[#FFDF00] text-sm font-semibold mb-1">First Name</label>
                    <input type="text" id="first_name" name="firstName" required
                           value="<?= safeString($old['firstName'] ?? '') ?>"
                           class="w-full p-2 rounded-lg border border-[#FFDF00] bg-black text-[#FFDF00] text-sm placeholder-[#FE04FF] focus:outline-none focus:ring-2 focus:ring-[#FE04FF]">
                </div>
                <div>
                    <label for="last_name" class="block text-[#FFDF00] text-sm font-semibold mb-1">Last Name</label>
                    <input type="text" id="last_name" name="lastName" required
                           value="<?= safeString($old['lastName'] ?? '') ?>"
                           class="w-full p-2 rounded-lg border border-[#FFDF00] bg-black text-[#FFDF00] text-sm placeholder-[#FE04FF] focus:outline-none focus:ring-2 focus:ring-[#FE04FF]">
                </div>
            </div>

            <!-- Username & Email -->
            <div>
                <label for="username" class="block text-[#FFDF00] text-sm font-semibold mb-1">Username</label>
                <input type="text" id="username" name="username" required
                       value="<?= safeString($old['username'] ?? '') ?>"
                       class="w-full p-2 rounded-lg border border-[#FFDF00] bg-black text-[#FFDF00] text-sm placeholder-[#FE04FF] focus:outline-none focus:ring-2 focus:ring-[#FE04FF]">
            </div>
            <div>
                <label for="email" class="block text-[#FFDF00] text-sm font-semibold mb-1">Email</label>
                <input type="email" id="email" name="email" required
                       value="<?= safeString($old['email'] ?? '') ?>"
                       class="w-full p-2 rounded-lg border border-[#FFDF00] bg-black text-[#FFDF00] text-sm placeholder-[#FE04FF] focus:outline-none focus:ring-2 focus:ring-[#FE04FF]">
            </div>

            <!-- Phone & Country -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label for="phone" class="block text-[#FFDF00] text-sm font-semibold mb-1">Phone</label>
                    <input type="tel" id="phone" name="phone" required
                           value="<?= safeString($old['phone'] ?? '') ?>"
                           class="w-full p-2 rounded-lg border border-[#FFDF00] bg-black text-[#FFDF00] text-sm placeholder-[#FE04FF] focus:outline-none focus:ring-2 focus:ring-[#FE04FF]">
                </div>
                <div>
                    <label for="country" class="block text-[#FFDF00] text-sm font-semibold mb-1">Country</label>
                    <input type="text" id="country" name="country" required
                           value="<?= safeString($old['country'] ?? '') ?>"
                           class="w-full p-2 rounded-lg border border-[#FFDF00] bg-black text-[#FFDF00] text-sm placeholder-[#FE04FF] focus:outline-none focus:ring-2 focus:ring-[#FE04FF]">
                </div>
            </div>

            <!-- Address -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <label for="street" class="block text-[#FFDF00] text-sm font-semibold mb-1">Street</label>
                    <input type="text" id="street" name="street" required
                           value="<?= safeString($old['street'] ?? '') ?>"
                           class="w-full p-2 rounded-lg border border-[#FFDF00] bg-black text-[#FFDF00] text-sm placeholder-[#FE04FF] focus:outline-none focus:ring-2 focus:ring-[#FE04FF]">
                </div>
                <div>
                    <label for="street_number" class="block text-[#FFDF00] text-sm font-semibold mb-1">Street Number</label>
                    <input type="text" id="street_number" name="streetNumber" required
                           value="<?= safeString($old['streetNumber'] ?? '') ?>"
                           class="w-full p-2 rounded-lg border border-[#FFDF00] bg-black text-[#FFDF00] text-sm placeholder-[#FE04FF] focus:outline-none focus:ring-2 focus:ring-[#FE04FF]">
                </div>
                <div>
                    <label for="postal_code" class="block text-[#FFDF00] text-sm font-semibold mb-1">Postal Code</label>
                    <input type="text" id="postal_code" name="postalCode" required
                           value="<?= safeString($old['postalCode'] ?? '') ?>"
                           class="w-full p-2 rounded-lg border border-[#FFDF00] bg-black text-[#FFDF00] text-sm placeholder-[#FE04FF] focus:outline-none focus:ring-2 focus:ring-[#FE04FF]">
                </div>
            </div>

            <!-- City -->
            <div>
                <label for="city" class="block text-[#FFDF00] text-sm font-semibold mb-1">City</label>
                <input type="text" id="city" name="city" required
                       value="<?= safeString($old['city'] ?? '') ?>"
                       class="w-full p-2 rounded-lg border border-[#FFDF00] bg-black text-[#FFDF00] text-sm placeholder-[#FE04FF] focus:outline-none focus:ring-2 focus:ring-[#FE04FF]">
            </div>

            <!-- Password & Confirm Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label for="password" class="block text-[#FFDF00] text-sm font-semibold mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full p-2 rounded-lg border border-[#FFDF00] bg-black text-[#FFDF00] text-sm placeholder-[#FE04FF] focus:outline-none focus:ring-2 focus:ring-[#FE04FF]">
                </div>
                <div>
                    <label for="confirm_password" class="block text-[#FFDF00] text-sm font-semibold mb-1">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required
                           class="w-full p-2 rounded-lg border border-[#FFDF00] bg-black text-[#FFDF00] text-sm placeholder-[#FE04FF] focus:outline-none focus:ring-2 focus:ring-[#FE04FF]">
                </div>
            </div>

            <!-- Sign Up Button -->
            <button type="submit"
                    class="w-full py-2 md:py-3 bg-black border border-[#FE04FF] text-[#FE04FF] font-bold text-sm md:text-base rounded-lg hover:bg-[#FE04FF] hover:text-black transition-all duration-300 shadow-[0_0_15px_#FE04FF]">
                Sign Up
            </button>

            <?php if ($error): ?>
                <p class="text-red-500 text-sm mt-2"><?= safeString($error) ?></p>
            <?php endif; ?>

        </form>

        <!-- Divider -->
        <div class="text-center text-gray-400 my-3 md:my-4 relative">
            <span class="bg-black px-2 relative z-10">OR</span>
            <hr class="absolute top-1/2 left-0 w-full border-t border-[#FE04FF] opacity-50">
        </div>

        <!-- Login Link -->
        <p class="text-center text-[#FFDF00] text-sm md:text-base">
            Already have an account? 
            <a href="login.php" class="text-[#FE04FF] hover:underline">Log In</a>
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>