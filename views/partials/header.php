<?php
$currentPage = basename($_SERVER['PHP_SELF']);

$menuLinks = [
    generateUrl("") => 'Home',
    generateUrl('movie-details') => 'Movies',
    generateUrl('contact') => 'Contact'
];

// Tilføj "Profile" kun hvis brugeren er logget ind
if (isset($_SESSION['username'])) {
    $menuLinks[generateUrl('profile')] = 'Profile';
}

// Tilføj "Admin" kun hvis brugeren er admin
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $menuLinks[generateUrl('admin')] = 'Admin';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RetroBio</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=VT323&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="assets/style.css" rel="stylesheet">
</head>
<body class="bg-black text-white">
<nav class="custom-navbar bg-black border-b border-[#FFDF00]/50 sticky w-full z-20 top-0 left-0 shadow-lg">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      <!-- Logo -->
      <a href="index.php" class="film-logo glow text-[#FFDF00] font-bold text-2xl">RetroBio</a>

      <!-- Menu (desktop) -->
      <ul class="hidden md:flex space-x-10 font-medium relative">
        <?php foreach($menuLinks as $file => $label): ?>
            <li>
                <a href="<?php echo $file; ?>" 
                   class="transition duration-300 <?php echo $currentPage == $file ? 'nav-link-active' : 'text-[#FFDF00] hover:text-[#FE04FF]'; ?>">
                   <?php echo $label; ?>
                </a>
            </li>
        <?php endforeach; ?>
      </ul>

      <!-- User-login -->
      <div class="hidden md:flex items-center space-x-4">
        <?php if(isset($_SESSION['username'])): ?>
            <span class="text-[#FE04FF] font-semibold">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="<?php echo generateUrl("logout") ?>" class="text-[#FFDF00] border border-[#FFDF00] px-3 py-1 rounded-lg hover:bg-[#FFDF00] hover:text-black transition-all">Logout</a>
        <?php else: ?>
            <a href="<?php echo generateUrl("login") ?>" class="text-[#FFDF00] border border-[#FFDF00] px-3 py-1 rounded-lg hover:bg-[#FFDF00] hover:text-black transition-all">Login</a>
            <a href="<?php echo generateUrl("register") ?>" class="text-[#FE04FF] border border-[#FE04FF] px-3 py-1 rounded-lg hover:bg-[#FE04FF] hover:text-black transition-all">Sign Up</a>
        <?php endif; ?>
      </div>

      <!-- Søgefelt (desktop) -->
      <form class="hidden md:flex items-center space-x-2">
        <input type="search" placeholder="Søg" class="navbar-search">
        <button type="submit" class="navbar-btn">Søg</button>
      </form>

      <!-- Mobilmenu-knap -->
      <button id="menu-btn" class="md:hidden text-[#FFDF00] text-3xl focus:outline-none">☰</button>
    </div>
  </div>

  <!-- Mobilmenu -->
  <div id="mobile-menu" class="hidden md:hidden bg-black border-t border-[#FFDF00]/30 px-6 pb-4 space-y-2 slide-down">
    <?php foreach($menuLinks as $file => $label): ?>
        <a href="<?php echo $file; ?>" 
           class="<?php echo $currentPage == $file ? 'nav-link-active' : 'text-[#FFDF00] hover:text-[#FE04FF]'; ?>">
           <?php echo $label; ?>
        </a>
    <?php endforeach; ?>

    <?php if(isset($_SESSION['username'])): ?>
        <span class="text-[#FE04FF] block mt-2">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
        <a href="logout" class="text-[#FFDF00] block mt-1 border border-[#FFDF00] px-3 py-1 rounded-lg hover:bg-[#FFDF00] hover:text-black transition-all">Logout</a>
    <?php else: ?>
        <a href="login" class="text-[#FFDF00] block mt-2 border border-[#FFDF00] px-3 py-1 rounded-lg hover:bg-[#FFDF00] hover:text-black transition-all">Login</a>
        <a href="register" class="text-[#FE04FF] block mt-1 border border-[#FE04FF] px-3 py-1 rounded-lg hover:bg-[#FE04FF] hover:text-black transition-all">Sign Up</a>
    <?php endif; ?>
  </div>
</nav>