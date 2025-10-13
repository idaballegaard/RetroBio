<?php
session_start();
if(!isset($_SESSION['username'])) {
    $_SESSION['username'] = "RetroFan"; // Dummy session for layout-test
    // header("Location: login.php");
    // exit();
}

/* Database-kode er kommenteret ud indtil databasen er klar
try {
    $host = "localhost";
    $dbname = "retrobio";
    $user = "dbuser";  
    $pass = "dbpass";  

    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Hent brugerinfo
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_SESSION['username']]);
    $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

    // Hent watched movies baseret på købte billetter
    $stmt = $conn->prepare("
        SELECT m.title, m.year 
        FROM tickets t
        JOIN movies m ON t.movie_id = m.id
        WHERE t.user_id = ?
        ORDER BY t.purchase_date DESC
    ");
    $stmt->execute([$currentUser['id']]);
    $watchedMovies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
*/


// Dummy brugerdata
$currentUser = [
    'username' => $_SESSION['username'],
    'email' => 'retrofan@example.com'
];

// Dummy upcoming tickets
$upcomingTickets = [
    ['title' => 'The Matrix', 'date' => '2025-10-20', 'time' => '19:00', 'poster' => 'img/back-to-the-future.jpg'],
    ['title' => 'Inception', 'date' => '2025-10-21', 'time' => '21:00', 'poster' => 'img/back-to-the-future.jpg'],
    ['title' => 'Jurassic Park', 'date' => '2025-10-22', 'time' => '20:30', 'poster' => 'img/back-to-the-future.jpg'],
    ['title' => 'Jurassic Park', 'date' => '2025-10-22', 'time' => '20:30', 'poster' => 'img/back-to-the-future.jpg'],
    ['title' => 'Jurassic Park', 'date' => '2025-10-22', 'time' => '20:30', 'poster' => 'img/back-to-the-future.jpg'],
    ['title' => 'Jurassic Park', 'date' => '2025-10-22', 'time' => '20:30', 'poster' => 'img/back-to-the-future.jpg']
];

// Dummy watchlist
$watchlist = [
    ['title' => 'The Godfather', 'poster' => 'img/back-to-the-future.jpg'],
    ['title' => 'Blade Runner', 'poster' => 'img/back-to-the-future.jpg'],
    ['title' => 'Blade Runner', 'poster' => 'img/back-to-the-future.jpg'],
    ['title' => 'Blade Runner', 'poster' => 'img/back-to-the-future.jpg'],
    ['title' => 'Blade Runner', 'poster' => 'img/back-to-the-future.jpg'],
    ['title' => 'Blade Runner', 'poster' => 'img/back-to-the-future.jpg']
];

// Dummy watched movies
$watchedMovies = [
    ['title' => 'The Rocky Horror', 'year' => '1975', 'poster' => 'img/back-to-the-future.jpg'],
    ['title' => 'Back to the Future', 'year' => '1985', 'poster' => 'img/back-to-the-future.jpg'],
    ['title' => 'Pulp Fiction', 'year' => '1994', 'poster' => 'img/back-to-the-future.jpg'],
    ['title' => 'Pulp Fiction', 'year' => '1994', 'poster' => 'img/back-to-the-future.jpg'],
    ['title' => 'Pulp Fiction', 'year' => '1994', 'poster' => 'img/back-to-the-future.jpg'],
    ['title' => 'Pulp Fiction', 'year' => '1994', 'poster' => 'img/back-to-the-future.jpg']
];

// Dummy reviews
$reviews = [
    ['movie' => 'Pulp Fiction', 'rating' => 5, 'comment' => 'Classic Tarantino!'],
    ['movie' => 'Back to the Future', 'rating' => 4, 'comment' => 'Always fun to watch!']
];
?>

<?php include 'header.php'; ?>

<main class="bg-black min-h-screen text-white relative px-6 md:px-12 lg:px-24">

    <!-- Top Banner / Profil Header -->
    <section class="relative bg-gradient-to-r from-[#1a1a1a] via-[#000000] to-[#1a1a1a] h-48 flex items-center mb-8">
        <div class="flex flex-col md:flex-row justify-between w-full items-center">
            <div class="text-center md:text-left">
                <h1 class="text-4xl font-bold text-[#FE04FF] animate-neon-flicker"><?php echo htmlspecialchars($currentUser['username']); ?></h1>
                <p class="text-[#FFDF00] mt-2"><?php echo htmlspecialchars($currentUser['email']); ?></p>
            </div>
            <div class="mt-4 md:mt-0 space-x-4">
                <a href="#" class="px-4 py-2 border border-[#FFDF00] text-[#FFDF00] rounded-lg hover:bg-[#FFDF00] hover:text-black transition-shadow shadow-[0_0_10px_#FE04FF]">Edit Profile</a>
                <a href="/logout.php" class="px-4 py-2 border border-[#FFDF00] text-[#FFDF00] rounded-lg hover:bg-[#FFDF00] hover:text-black transition-shadow shadow-[0_0_10px_#FE04FF]">Logout</a>
            </div>
        </div>
    </section>

    <!-- To-kolonne layout -->
    <div class="flex flex-col md:flex-row gap-8">

        <!-- Venstre kolonne -->
        <div class="w-full md:w-1/2 flex flex-col gap-8">
            <?php renderMovieSection('Upcoming Tickets', $upcomingTickets, 'tickets-container'); ?>
            <?php renderMovieSection('Watchlist', $watchlist, 'watchlist-container'); ?>
        </div>

        <!-- Højre kolonne -->
        <div class="w-full md:w-1/2 flex flex-col gap-8">
            <?php renderMovieSection('Watched Movies', $watchedMovies, 'watched-container'); ?>

            <!-- Reviews -->
            <section class="py-12">
                <h2 class="text-3xl text-[#FE04FF] font-semibold mb-6 animate-neon-flicker text-left">Reviews</h2>
                <?php if(count($reviews) > 0): ?>
                    <div class="space-y-4 max-w-full">
                        <?php foreach($reviews as $review): ?>
                            <div class="border border-[#FE04FF] rounded-lg p-4 shadow-[0_0_10px_#FE04FF] hover:shadow-[0_0_20px_#FE04FF] transition-shadow">
                                <p class="text-[#FFDF00] font-semibold"><?php echo htmlspecialchars($review['movie']); ?> – Rating: <?php echo $review['rating']; ?>/5</p>
                                <p class="text-gray-300 mt-1"><?php echo htmlspecialchars($review['comment']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-400 text-left">No reviews yet.</p>
                <?php endif; ?>
            </section>
        </div>

    </div>
</main>

<script>
// Scroll funktion for alle sektioner med pile
document.querySelectorAll('.scroll-left').forEach((btn) => {
    btn.addEventListener('click', () => {
        const container = btn.parentElement.querySelector('.overflow-x-auto');
        container.scrollBy({ left: -300, behavior: 'smooth' });
    });
});
document.querySelectorAll('.scroll-right').forEach((btn) => {
    btn.addEventListener('click', () => {
        const container = btn.parentElement.querySelector('.overflow-x-auto');
        container.scrollBy({ left: 300, behavior: 'smooth' });
    });
});

// Swipe / drag funktion
document.querySelectorAll('.flex.overflow-x-auto').forEach((container) => {
    let isDown = false;
    let startX;
    let scrollLeft;

    container.addEventListener('mousedown', (e) => {
        isDown = true;
        container.classList.add('cursor-grabbing');
        startX = e.pageX - container.offsetLeft;
        scrollLeft = container.scrollLeft;
    });
    container.addEventListener('mouseleave', () => { isDown = false; container.classList.remove('cursor-grabbing'); });
    container.addEventListener('mouseup', () => { isDown = false; container.classList.remove('cursor-grabbing'); });
    container.addEventListener('mousemove', (e) => {
        if(!isDown) return;
        e.preventDefault();
        const x = e.pageX - container.offsetLeft;
        const walk = (x - startX) * 2;
        container.scrollLeft = scrollLeft - walk;
    });

    // Touch events
    let touchStartX = 0;
    let touchScrollLeft = 0;

    container.addEventListener('touchstart', (e) => {
        touchStartX = e.touches[0].pageX;
        touchScrollLeft = container.scrollLeft;
    });
    container.addEventListener('touchmove', (e) => {
        const x = e.touches[0].pageX;
        const walk = (x - touchStartX) * 2;
        container.scrollLeft = touchScrollLeft - walk;
    });
});
</script>

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

/* Scroll container */
.flex.overflow-x-auto::-webkit-scrollbar { display: none; }
.flex.overflow-x-auto { -ms-overflow-style: none; scrollbar-width: none; }
.cursor-grab { cursor: grab; }
.cursor-grabbing { cursor: grabbing; }
</style>

<?php include 'footer.php'; ?>

<?php
// Funktion til at rendere sektioner med horisontal scroll uden at pile overlapper plakater
function renderMovieSection($title, $movies, $idContainer) { ?>
    <section class="py-12">
        <h2 class="text-3xl text-[#FE04FF] font-semibold mb-6 animate-neon-flicker text-left"><?php echo $title; ?></h2>
        <?php if(count($movies) > 0): ?>
            <div class="relative flex items-center">

                <!-- Venstre pil -->
                <button class="scroll-left z-10 bg-black/70 text-[#FFDF00] p-2 rounded-full hover:bg-[#FE04FF] hover:text-black transition-all shadow-[0_0_10px_#FE04FF] mr-2 flex-none">
                    &#8249;
                </button>

                <!-- Scroll-container -->
                <div id="<?php echo $idContainer; ?>" class="flex overflow-x-auto space-x-6 pb-4 scroll-smooth cursor-grab">
                    <?php foreach($movies as $movie): ?>
                        <div class="flex-none w-48">
                            <div class="overflow-hidden rounded-lg border border-[#FE04FF] shadow-[0_0_10px_#FE04FF] hover:shadow-[0_0_20px_#FE04FF] transition-shadow duration-300">
                                <img src="<?php echo $movie['poster']; ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="w-full h-64 object-cover">
                            </div>
                            <div class="mt-2 text-left">
                                <p class="text-[#FFDF00] font-semibold"><?php echo htmlspecialchars($movie['title']); ?></p>
                                <?php if(isset($movie['year'])): ?><p class="text-sm text-gray-300"><?php echo htmlspecialchars($movie['year']); ?></p><?php endif; ?>
                                <?php if(isset($movie['date']) && isset($movie['time'])): ?><p class="text-sm text-gray-300"><?php echo $movie['date'].' | '.$movie['time']; ?></p><?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Højre pil -->
                <button class="scroll-right z-10 bg-black/70 text-[#FFDF00] p-2 rounded-full hover:bg-[#FE04FF] hover:text-black transition-all shadow-[0_0_10px_#FE04FF] ml-2 flex-none">
                    &#8250;
                </button>
            </div>
        <?php else: ?>
            <p class="text-gray-400 text-left">No items found.</p>
        <?php endif; ?>
    </section>
<?php } ?>
