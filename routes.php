<?php
session_start();
require_once __DIR__ . "/router.php";
require_once __DIR__ . "/helpers.php";
require_once __DIR__ . "/repositories/UserRepository.php";
require_once __DIR__ . "/repositories/NewsRepository.php";

// Frontpage
get(generateUrl("/"), function () {
  require_once __DIR__ . "/controllers/HomeController.php";
  $controller = new HomeController();
  $controller->frontpage()->presentView();
});

// Login
get(generateUrl("login"), "views/login.php");
post(generateUrl("login"), function () {
  require_once __DIR__ . "/controllers/UserController.php";
  $controller = new UserController();
  $controller->authenticate()->presentView();
});

// Logout
get(generateUrl("logout"), function () {
  require_once __DIR__ . "/controllers/UserController.php";
  $controller = new UserController();
  $controller->logout();
});

// Movie details
get(generateUrl("movie-details"), function () {
  require_once __DIR__ . "/controllers/MovieController.php";
  $controller = new MovieController();
  $controller->showMovieDetails()->presentView();
});

// Contact
get(generateUrl("contact"), function () {
  requestLoginRedirectIfNeeded();

  require_once __DIR__ . "/controllers/ContactController.php";
  $controller = new ContactController();
  $controller->showContactForm()->presentView();
});

post(generateUrl("contact"), function () {
  requestLoginRedirectIfNeeded();

  require_once __DIR__ . "/controllers/ContactController.php";
  $controller = new ContactController();
  $controller->sendMail()->presentView();
});

// Register
get(generateUrl("register"), function () {
  require_once __DIR__ . "/views/register.php";
});

post(generateUrl("register"), function () {
  require_once __DIR__ . "/controllers/UserController.php";
  $controller = new UserController();
  $controller->register()->presentView();
});

// Booking
get(generateUrl("booking"), function () {
  require_once __DIR__ . "/controllers/BookingController.php";
  $controller = new BookingController();
  $controller->showBookingPage()->presentView();
});

post(generateUrl("booking"), function () {
  require_once __DIR__ . "/controllers/BookingController.php";
  $controller = new BookingController();
  $controller->processBooking()->presentView();
});

get(generateUrl("confirmBooking"), function () {
  require_once __DIR__ . "/controllers/BookingController.php";
  $controller = new BookingController();
  $controller->confirmBooking()->presentView();
});

get(generateUrl("cancelBooking"), function () {
  require_once __DIR__ . "/controllers/BookingController.php";
  $controller = new BookingController();
  $controller->cancelBooking()->presentView();
});

// Profil
get(generateUrl("profile"), function () {
  require_once __DIR__ . "/controllers/UserController.php";
  $controller = new UserController();
  $controller->showProfile()->presentView();
});

// Admin
if (UserRepository::isAdmin()) {
  get(generateUrl("admin"), function () {
    require_once __DIR__ . "/controllers/admin/AdminController.php";
    $controller = new AdminController();
    $controller->adminFrontpage()->presentView();
  });
  post(generateUrl("admin-save-movie"), function () {
    require_once __DIR__ . "/controllers/admin/AdminController.php";
    $controller = new AdminController();
    $controller->saveMovie();
    header("Location: " . generateUrl("admin"));
  });
  post(generateUrl("admin-save-showing"), function () {
    require_once __DIR__ . "/controllers/admin/AdminController.php";
    $controller = new AdminController();
    $controller->saveShowing();
//    header("Location: " . generateUrl("admin"));
  });
  post(generateUrl("admin-save-news"), function () {
    require_once __DIR__ . "/controllers/admin/AdminController.php";
    $controller = new AdminController();
    $controller->saveNews();
    header("Location: " . generateUrl("admin"));
  });
  post(generateUrl("admin-save-about"), function () {
    require_once __DIR__ . "/controllers/admin/AdminController.php";
    $controller = new AdminController();
    $controller->saveAbout();
    header("Location: " . generateUrl("admin"));
  });
  get(generateUrl("admin-delete"), function () {
    require_once __DIR__ . "/controllers/admin/AdminController.php";
    $controller = new AdminController();
    $controller->delete();
    header("Location: " . generateUrl("admin"));
  });
} else {
  // Hvis brugeren ikke er admin, omdiriger til login-siden
  get(generateUrl("admin"), function () {
    header("Location: " . generateUrl("login"));
    exit();
  });
}

// 404
any(generateUrl('404'), 'views/404.php');