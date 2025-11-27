<?php
require_once 'header.php'; // header.php starter session

/* Ensure user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
} */

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input
    $purpose = isset($_POST['purpose']) ? trim($_POST['purpose']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    $mailinglist = isset($_POST['mailinglist']) ? 'Yes' : 'No';
    $username = $_SESSION['username'];

    // Server-side validation
    if ($purpose === '') {
        $errors[] = "Please select a purpose for your message.";
    }
    if ($message === '') {
        $errors[] = "Please enter your message.";
    }

    if (empty($errors)) {
        $success = true;
        header("Location: thankyou.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact | RetroBio</title>

    <!-- Tailwind, Alpine, Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=VT323&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }

        /* Neon flicker */
        @keyframes neonFlicker {
            0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% {
                text-shadow: 0 0 4px currentColor, 0 0 8px currentColor, 0 0 20px currentColor;
                opacity: 1;
            }
            20%, 22%, 24%, 55% {
                text-shadow: none;
                opacity: 0.9;
            }
        }
        .glitch {
            color: #00e7ec;
            text-shadow: 0 0 5px #00e7ec, 0 0 10px #00e7ec, 0 0 20px #00e7ec;
            animation: neonFlicker 2s infinite;
        }

        /* Neon pulse for container */
        @keyframes neonPulse {
            0%, 100% { box-shadow: 0 0 10px #00e7ec; }
            50% { box-shadow: 0 0 25px #00e7ec; }
        }
        .neon-glow { animation: neonPulse 2s infinite; }

        /* Small hover glitch */
        @keyframes smallGlitch {
            0% { transform: translate(0); }
            20% { transform: translate(-1px, 1px); }
            40% { transform: translate(1px, -1px); }
            60% { transform: translate(-1px, 0); }
            80% { transform: translate(1px, 0); }
            100% { transform: translate(0); }
        }
        .glitch-hover:hover { animation: smallGlitch 0.25s infinite; }

        /* Scanlines overlay */
        .scanlines {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: repeating-linear-gradient(
                to bottom,
                rgba(255,255,255,0.02) 0px,
                rgba(255,255,255,0.02) 1px,
                transparent 2px,
                transparent 3px
            );
            pointer-events: none;
            mix-blend-mode: overlay;
        }

        /* Dropdown focus + style */
        .neon-dropdown-btn:focus {
            outline: 2px solid rgba(0,231,236,0.12);
            box-shadow: 0 0 8px #00e7ec;
        }

        .dropdown-wrapper { position: relative; }
        .dropdown-menu { max-height: 240px; overflow-y: auto; }

        .error-box {
            background: rgba(255,0,0,0.06);
            border: 1px solid rgba(255,0,0,0.12);
            color: #FFB3B3;
            padding: 12px;
            border-radius: 8px;
        }

        /* Fonts */
        /* Orbitron: headings, labels, buttons, dropdown */
        h1, h2, h3, h4, h5, h6,
        label,
        button,
        .neon-dropdown-btn,
        .dropdown-menu div {
            font-family: 'Orbitron', sans-serif;
        }
        

        /* Brødtekst, paragraf, textarea, listeelementer */
        body, p, span, li, textarea, input[type="text"], input[type="hidden"] {
            font-family: 'Lucida Console', Monaco, monospace;
            color: #fff;
        }


        /* Dropdown menu text color & background */
        .dropdown-menu div {
            color: #00e7ec;
            background-color: black;
        }

        .dropdown-menu div:hover {
            color: black;
            background-color: #00e7ec;
        }
    </style>
</head>

<body class="bg-black text-white relative">
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

            <?php if (!empty($errors)): ?>
                <div class="mb-6 error-box">
                    <ul class="list-disc pl-5">
                        <?php foreach ($errors as $err): ?>
                            <li><?php echo htmlspecialchars($err); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="contact.php" class="space-y-6">
                <!-- Custom Neon Dropdown -->
                <div class="dropdown-wrapper" 
                     x-data="{
                        open: false,
                        selected: '',
                        options: [
                            '🎟️ Ticket inquiry',
                            '🍿 Snacks & bar',
                            '🎞️ Movie request',
                            '💻 Technical help',
                            '🌟 Other'
                        ],
                        select(option) {
                            this.selected = option;
                            this.open = false;
                        }
                     }" x-cloak>
                    <label class="block text-[#FFDF00] font-semibold mb-2">🎯 Purpose of your message</label>
                    <input type="hidden" name="purpose" x-bind:value="selected">

                    <!-- Toggle button -->
                    <div @click="open = !open"
                         @keydown.escape.window="open = false"
                         tabindex="0"
                         role="button"
                         aria-haspopup="listbox"
                         :aria-expanded="open"
                         class="neon-dropdown-btn bg-black border border-[#00e7ec] text-[#00e7ec] px-4 py-3 rounded-lg flex justify-between items-center cursor-pointer hover:shadow-[0_0_10px_#00e7ec] transition-all">
                        <span x-text="selected || 'Select purpose...'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#00e7ec" viewBox="0 0 24 24" class="w-5 h-5 ml-2">
                            <path d="M7 10l5 5 5-5z" />
                        </svg>
                    </div>

                    <!-- Dropdown options -->
                    <div x-show="open"
                         @click.away="open = false"
                         x-transition.origin.top
                         class="absolute z-20 mt-2 w-full bg-black border border-[#00e7ec] rounded-lg shadow-[0_0_20px_#00e7ec] dropdown-menu">
                        <template x-for="(option, idx) in options" :key="idx">
                            <div
                                 @click="select(option)"
                                 @keydown.enter.prevent="select(option)"
                                 tabindex="0"
                                 role="option"
                                 class="px-4 py-3 hover:bg-[#00e7ec] hover:text-black cursor-pointer transition-all glitch-hover">
                                <span x-text="option"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-[#FFDF00] font-semibold mb-2">📝 Your message</label>
                    <textarea id="message" name="message" rows="6" required
                              class="w-full bg-black border border-[#00e7ec] text-white rounded-lg p-3 focus:ring-[#00e7ec] focus:border-[#00e7ec]"
                              placeholder="Type your message here..."><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                </div>

                <!-- Mailing list -->
                <div class="flex items-center space-x-3">
                    <input type="checkbox" id="mailinglist" name="mailinglist"
                           class="w-5 h-5 accent-[#FE04FF] cursor-pointer" <?php echo isset($_POST['mailinglist']) ? 'checked' : ''; ?>>
                    <label for="mailinglist" class="text-[#FE04FF] cursor-pointer">
                        Sign me up for the RetroBio mailing list – trailers, events & popcorn news 🍿
                    </label>
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

<?php require_once 'footer.php'; ?>
</body>
</html>
