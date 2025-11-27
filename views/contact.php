<?php // @var BasicViewModel $viewModel ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>


    <div class="scanlines"></div>

    <section class="min-h-screen flex flex-col justify-center items-center py-20 px-6 relative overflow-hidden">
        <div class="relative z-10 w-full max-w-2xl bg-black border border-[#00e7ec] rounded-2xl p-10 shadow-[0_0_25px_#00e7ec] neon-glow">

            <!-- Neon flicker headline -->
            <h1 class="text-4xl font-bold text-center mb-6 glitch">
                CONNECT TO RETROBIO MAINFRAME
            </h1>

            <p class="text-center text-white mb-8 italic">
                Transmit your signal — our team of cult cinema specialists will decode it shortly 🎞️
            </p>

            <?php if ($viewModel->hasFailed()): ?>
                <div class="mb-6 error-box">
                    <?php echo safeString($viewModel->getErrorMessage()); ?>
                </div>
            <?php endif; ?>

            <?php if ($viewModel->getMailSent()): ?>
                <div class="mb-6 success-box">
                    Your message has been successfully transmitted! 🚀 We will decode and respond to your signal shortly.
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php generateUrl('contact') ?>" class="space-y-6">
                <!-- Custom Neon Dropdown -->
                <div class="dropdown-wrapper">
                    <label class="block text-[#FFDF00] font-semibold mb-2">🎯 Purpose of your message</label>
                    <input type="hidden" name="purpose" id="purposeField">

                    <!-- Toggle button -->
                    <div tabindex="0"
                         role="button"
                         aria-haspopup="listbox"
                         class="neon-dropdown-btn bg-black border border-[#00e7ec] text-[#00e7ec] px-4 py-3 rounded-lg flex justify-between items-center cursor-pointer hover:shadow-[0_0_10px_#00e7ec] transition-all">
                        <span id="dropdownLabel">Select purpose...</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#00e7ec" viewBox="0 0 24 24" class="w-5 h-5 ml-2">
                            <path d="M7 10l5 5 5-5z" />
                        </svg>
                    </div>

                    <!-- Dropdown options -->
                    <div class="absolute z-20 mt-2 w-full bg-black border border-[#00e7ec] rounded-lg shadow-[0_0_20px_#00e7ec] dropdown-menu" style="display: none;">
                        <div class="dropdown-option px-4 py-3 hover:bg-[#00e7ec] hover:text-black cursor-pointer transition-all glitch-hover">🎟️ Ticket inquiry</div>
                        <div class="dropdown-option px-4 py-3 hover:bg-[#00e7ec] hover:text-black cursor-pointer transition-all glitch-hover">🍿 Snacks & bar</div>
                        <div class="dropdown-option px-4 py-3 hover:bg-[#00e7ec] hover:text-black cursor-pointer transition-all glitch-hover">🎞️ Movie request</div>
                        <div class="dropdown-option px-4 py-3 hover:bg-[#00e7ec] hover:text-black cursor-pointer transition-all glitch-hover">💻 Technical help</div>
                        <div class="dropdown-option px-4 py-3 hover:bg-[#00e7ec] hover:text-black cursor-pointer transition-all glitch-hover">🌟 Other</div>
                    </div>
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-[#FFDF00] font-semibold mb-2">📝 Your message</label>
                    <textarea id="message" name="message" rows="6" required
                              class="w-full bg-black border border-[#00e7ec] text-white rounded-lg p-3 focus:ring-[#00e7ec] focus:border-[#00e7ec]"
                              placeholder="Type your message here..."><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                </div>  

                <!-- Submit -->
                <div class="text-center">
                    <button type="submit"
                            class="bg-black border border-[#00e7ec] text-[#00e7ec] px-8 py-3 rounded-lg font-bold hover:bg-[#00e7ec] hover:text-black transition-all duration-300">
                        TRANSMIT MESSAGE 🚀
                    </button>
                </div>
            </form>
        </div>
    </section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const toggleBtn = document.querySelector(".neon-dropdown-btn");
    const menu = document.querySelector(".dropdown-menu");
    const options = document.querySelectorAll(".dropdown-option");
    const label = document.getElementById("dropdownLabel");
    const purposeField = document.getElementById("purposeField");

    toggleBtn.addEventListener("click", () => {
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    });

    document.addEventListener("click", (e) => {
        if (!toggleBtn.contains(e.target) && !menu.contains(e.target)) {
            menu.style.display = "none";
        }
    });

    options.forEach(option => {
        option.addEventListener("click", () => {
            const selected = option.textContent.trim();
            label.textContent = selected;
            purposeField.value = selected;
            menu.style.display = "none";
        });
    });
});
</script>


<?php require_once __DIR__ . '/partials/footer.php'; ?>