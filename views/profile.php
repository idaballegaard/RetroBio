<?php require_once __DIR__ . '/partials/header.php'; ?>

<?php
$firstName = $viewModel->getFirstName();
$lastName = $viewModel->getLastName();
$username = $viewModel->getUsername();
$email = $viewModel->getEmail();
$phone = $viewModel->getPhone();
$country = $viewModel->getCountry();
$city = $viewModel->getCity();
$postalCode = $viewModel->getPostalCode();
$street = $viewModel->getStreet();
$streetNumber = $viewModel->getStreetNumber();
?>

<?php
session_start();
if(!isset($_SESSION['username'])) {
    $_SESSION['username'] = "RetroFan"; // Dummy session for layout-test
    // header("Location: login.php");
    // exit();
}
?>

<main class="bg-black min-h-screen text-white relative px-6 md:px-12 lg:px-24">

    <!-- Top Banner / Profil Header -->
    <section class="relative bg-black h-auto flex flex-col md:flex-row justify-between items-start py-8 mb-8 px-6 md:px-0 rounded-lg">
            
        <!-- Venstre: Brugerinfor -->
        <div class="flex flex-col text-left space-y-3">
            <h1 class="text-4xl font-bold text-[#00e7ec] animate-neon-flicker mb-2">
                <?php echo htmlspecialchars($user->getUsername()); ?>
            </h1>
            <p class="text-[#FFDF00] text-sm">
                <?php echo htmlspecialchars($user->getFirstName() . ' ' . $user->getLastName()); ?>
            </p>
            <p class="text-[#FFDF00] text-sm">
                <?php echo htmlspecialchars($user->getEmail()); ?>
            </p>
            <p class="text-[#FFDF00] text-sm">
                <?php echo htmlspecialchars($user->getPhone()); ?>
            </p>
            <p class="text-[#FFDF00] text-sm">
                <?php echo htmlspecialchars($user->getStreet() . ' ' . $user->getStreetNumber()); ?>
            </p>
            <p class="text-[#FFDF00] text-sm">
                <?php echo htmlspecialchars($user->getPostalCode() . ' ' . $user->getCity()); ?>
            </p>
        </div>

        <!-- Højre: Knapper -->
        <div class="mt-4 md:mt-0 flex space-x-4 self-end">
            <a href="#" class="px-4 py-2 border border-[#FFDF00] text-[#FFDF00] rounded-lg yellow-hover shadow-[0_0_10px_#FFDF00]">Edit Profile</a>
            <a href="#" class="px-4 py-2 border border-[#FFDF00] text-[#FFDF00] rounded-lg yellow-hover shadow-[0_0_10px_#FFDF00]">Logout</a>
        </div>
    </section>

    <!-- To-kolonne layout -->
    <div class="flex flex-col md:flex-row gap-8">

        <!-- Venstre kolonne -->
        <div class="w-full md:w-1/2 flex flex-col gap-8">
            <!-- Upcoming Tickets -->
            <section class="py-12">
                <h2 class="text-3xl text-[#00e7ec] font-semibold mb-6 animate-neon-flicker text-left">Upcoming Tickets</h2>
                <div class="relative flex items-center">
                    <button class="scroll-left z-10 bg-black/70 text-[#FFDF00] p-2 rounded-full neon-border">&#8249;</button>
                    <div id="tickets-container" class="flex overflow-x-auto space-x-6 pb-4 scroll-smooth cursor-grab"></div>
                    <button class="scroll-right z-10 bg-black/70 text-[#FFDF00] p-2 rounded-full neon-border">&#8250;</button>
                </div>
            </section>

            <!-- Watchlist -->
            <section class="py-12">
                <h2 class="text-3xl text-[#00e7ec] font-semibold mb-6 animate-neon-flicker text-left">Watchlist</h2>
                <div class="relative flex items-center">
                    <button class="scroll-left z-10 bg-black/70 text-[#FFDF00] p-2 rounded-full neon-border">&#8249;</button>
                    <div id="watchlist-container" class="flex overflow-x-auto space-x-6 pb-4 scroll-smooth cursor-grab"></div>
                    <button class="scroll-right z-10 bg-black/70 text-[#FFDF00] p-2 rounded-full neon-border">&#8250;</button>
                </div>
            </section>
        </div>

        <!-- Højre kolonne -->
        <div class="w-full md:w-1/2 flex flex-col gap-8">
            <!-- Watched Movies -->
            <section class="py-12">
                <h2 class="text-3xl text-[#00e7ec] font-semibold mb-6 animate-neon-flicker text-left">Watched Movies</h2>
                <div class="relative flex items-center">
                    <button class="scroll-left z-10 bg-black/70 text-[#FFDF00] p-2 rounded-full neon-border">&#8249;</button>
                    <div id="watched-container" class="flex overflow-x-auto space-x-6 pb-4 scroll-smooth cursor-grab"></div>
                    <button class="scroll-right z-10 bg-black/70 text-[#FFDF00] p-2 rounded-full neon-border">&#8250;</button>
                </div>
            </section>

            <!-- Reviews -->
            <section class="py-12">
                <h2 class="text-3xl text-[#00e7ec] font-semibold mb-6 animate-neon-flicker text-left">Reviews</h2>
                <div class="space-y-4 max-w-full">
                    <div class="border border-[#00e7ec] rounded-lg p-4 shadow-[0_0_12px_#00e7ec] hover:shadow-[0_0_25px_#00e7ec] transition-shadow">
                        <p class="text-[#FFDF00] font-semibold">Pulp Fiction – Rating: 5/5</p>
                        <p class="text-gray-300 mt-1">Classic Tarantino!</p>
                    </div>
                    <div class="border border-[#00e7ec] rounded-lg p-4 shadow-[0_0_12px_#00e7ec] hover:shadow-[0_0_25px_#00e7ec] transition-shadow">
                        <p class="text-[#FFDF00] font-semibold">Back to the Future – Rating: 4/5</p>
                        <p class="text-gray-300 mt-1">Always fun to watch!</p>
                    </div>
                </div>
            </section>
        </div>

    </div>
</main>


<style>
    /* Neon flicker animation for headings */
    @keyframes neonFlicker {
        0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% {
            text-shadow: 0 0 6px #00e7ec, 0 0 20px #00e7ec, 0 0 30px #00e7ec;
        }
        20%, 24%, 55% {
            text-shadow: none;
        }
    }
    .animate-neon-flicker {
        animation: neonFlicker 1.2s infinite alternate;
    }

    /* Scroll container */
    .flex.overflow-x-auto::-webkit-scrollbar { display: none; }
    .flex.overflow-x-auto { -ms-overflow-style: none; scrollbar-width: none; }
    .cursor-grab { cursor: grab; }
    .cursor-grabbing { cursor: grabbing; }

    /* Neon borders and shadows */
    .neon-border {
        border-color: #00e7ec;
        box-shadow: 0 0 12px #00e7ec, 0 0 20px #00e7ec;
    }

    /* Buttons hover yellow with glow */
    .yellow-hover {
        transition: all 0.3s;
    }
    .yellow-hover:hover {
        background-color: #FFDF00;
        color: black;
        box-shadow: 0 0 15px #FFDF00, 0 0 30px #FFDF00;
    }

    /* Scroll buttons hover */
    .scroll-left:hover, .scroll-right:hover {
        background-color: #00e7ec;
        color: black;
        box-shadow: 0 0 20px #00e7ec, 0 0 40px #00e7ec;
    }

    /* Movie cards hover */
    .movie-card:hover {
        box-shadow: 0 0 20px #00e7ec, 0 0 40px #00e7ec;
    }
</style>

<script>
    const upcomingTickets = [
        {title:'The Matrix', date:'2025-10-20', time:'19:00', poster:'img/back-to-the-future.jpg'},
        {title:'Inception', date:'2025-10-21', time:'21:00', poster:'img/back-to-the-future.jpg'},
        {title:'Jurassic Park', date:'2025-10-22', time:'20:30', poster:'img/back-to-the-future.jpg'}
    ];
    const watchlist = [
        {title:'The Godfather', poster:'img/back-to-the-future.jpg'},
        {title:'Blade Runner', poster:'img/back-to-the-future.jpg'}
    ];
    const watchedMovies = [
        {title:'The Rocky Horror', year:'1975', poster:'img/back-to-the-future.jpg'},
        {title:'Back to the Future', year:'1985', poster:'img/back-to-the-future.jpg'},
        {title:'Pulp Fiction', year:'1994', poster:'img/back-to-the-future.jpg'}
    ];

    function populateContainer(containerId, movies, repeat=6) {
        const container = document.getElementById(containerId);
        for (let i = 0; i < repeat; i++) {
            const movie = movies[i % movies.length];
            container.innerHTML += `
            <div class="flex-none w-48">
                <div class="movie-card overflow-hidden rounded-lg border border-[#00e7ec] shadow-[0_0_12px_#00e7ec] hover:shadow-[0_0_25px_#00e7ec] transition-shadow duration-300">
                    <img src="${movie.poster}" alt="${movie.title}" class="w-full h-64 object-cover">
                </div>
                <div class="mt-2 text-left">
                    <p class="text-[#FFDF00] font-semibold">${movie.title}</p>
                    ${movie.year ? `<p class="text-sm text-gray-300">${movie.year}</p>` : ''}
                    ${movie.date && movie.time ? `<p class="text-sm text-gray-300">${movie.date} | ${movie.time}</p>` : ''}
                </div>
            </div>`;
        }
    }

    populateContainer('tickets-container', upcomingTickets, 6);
    populateContainer('watchlist-container', watchlist, 12);
    populateContainer('watched-container', watchedMovies, 12);

    // Scroll funktion
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
        let isDown = false, startX, scrollLeft;

        container.addEventListener('mousedown', (e) => {
            isDown = true; container.classList.add('cursor-grabbing');
            startX = e.pageX - container.offsetLeft;
            scrollLeft = container.scrollLeft;
        });
        container.addEventListener('mouseleave', () => { isDown = false; container.classList.remove('cursor-grabbing'); });
        container.addEventListener('mouseup', () => { isDown = false; container.classList.remove('cursor-grabbing'); });
        container.addEventListener('mousemove', (e) => {
            if(!isDown) return;
            e.preventDefault();
            container.scrollLeft = scrollLeft - (e.pageX - container.offsetLeft - startX) * 2;
        });

        container.addEventListener('touchstart', (e) => { startX = e.touches[0].pageX; scrollLeft = container.scrollLeft; });
        container.addEventListener('touchmove', (e) => {
            container.scrollLeft = scrollLeft - (e.touches[0].pageX - startX) * 2;
        });
    });
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
