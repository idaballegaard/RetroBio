<?php
require_once __DIR__ . "/BaseController.php";
require_once __DIR__ . "/../viewModels/BookingViewModel.php";
require_once __DIR__ . "/../repositories/ShowingRepository.php";
require_once __DIR__ . "/../repositories/SeatRepository.php";
require_once __DIR__ . "/../repositories/MovieRepository.php";
class BookingController extends BaseController {
    public function showBookingPage(): BookingViewModel {
        $showingID = $this->retrieveInput("showing_id", FILTER_VALIDATE_INT);

        // Opret ViewModel
        $showingRepository = new ShowingRepository();
        $seatRepository = new SeatRepository();
        $movieRepository = new MovieRepository();

        $showing = $showingRepository->getShowingById($showingID);
        if ($showing === null) {
            return new BookingViewModel(__DIR__ . "/../views/404.php");
        }

        $seats = $seatRepository->getSeatsByHallId($showing->getHall()->getHallID());
        $soldSeats = $seatRepository->getSoldSeatsByShowingId($showingID);
        $movie = $movieRepository->getMovieById($showing->getMovieID());

        $viewModel = new BookingViewModel(__DIR__ . "/../views/booking.php");
        $viewModel->setShowing($showing);
        $viewModel->setSeats($seats);
        $viewModel->setSoldSeats($soldSeats);
        $viewModel->setMovie($movie);
        return $viewModel;
    }

  public function processBooking() : ?BookingViewModel {
    $showingID = $this->retrieveInput("showingId", FILTER_SANITIZE_NUMBER_INT);

    require_once __DIR__ . "/../repositories/OrderRepository.php";
    $seats = explode(",", $this->retrieveInput("seats"));

    require_once __DIR__ . "/../repositories/ShowingRepository.php";
    $showingRepository = new ShowingRepository();
    $price = $showingRepository->getShowingById($showingID)->getPrice();

    $movieRepository = new MovieRepository();
    $movie = $movieRepository->getMoviesByShowingId(array($showingID))[$showingID];

    require_once __DIR__ . "/../repositories/SeatRepository.php";
    $seatRepository = new SeatRepository();
    $seatRows = $seatRepository->getSeatRowsByIds($seats);

    $errors = array();
    if(count($seats) === 0) {
      $errors[] = "Please pick at least one seat.";
    } elseif (count($seats) > 5) {
      $errors[] = "You can only book up to 5 seats at a time.";
    } elseif ($price === null) {
      $errors[] = "Invalid showing selected.";
    } elseif(count($seatRows) > 1) {
      $errors[] = "Make sure to pick seats from the same row.";
    }

    if (!empty($errors)) {
      $viewModel = $this->showBookingPage($showingID);
      $viewModel->setErrorMessage('<li>' . implode('</li><li>', $errors) . '</li>');
      return $viewModel;
    }

    $orderRepository = new OrderRepository();
    $orderId = $orderRepository->createOrder(
        $price,
        count($seats),
        $_SESSION['user_id'],
        $this->retrieveInput("showingId", FILTER_SANITIZE_NUMBER_INT, 0),
        $seats
    );

    require_once __DIR__ . "/../stripe/init.php";
    \Stripe\Stripe::setApiKey($this->getEnvVariable("STRIPE_KEY"));
    header('Content-Type: application/json');

    $checkout_session = \Stripe\Checkout\Session::create([
        'client_reference_id' => (string)$orderId,
        'line_items' => [[
            'quantity' => count($seats),
            'price_data' => [
                'currency' => 'dkk',
                'unit_amount' => $price * 100, // amount in cents (e.g., $20.00)
                'product_data' => [
                    'name' => $movie->getTitle()
                ],
            ],
        ]],
        'mode' => 'payment',
        'success_url' => $this->getEnvVariable("BASE_URL") . '/confirmBooking?orderId=' . $orderId . '&session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => $this->getEnvVariable("BASE_URL") . '/cancelBooking?orderId=' . $orderId,
        'automatic_tax' => [
            'enabled' => true,
        ],
    ]);

    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);
    return null;
  }

  public function confirmBooking() : BasicViewModel {
    require_once __DIR__ . "/../repositories/OrderRepository.php";

    // Require Stripe and set API key
    require_once __DIR__ . "/../stripe/init.php";
    \Stripe\Stripe::setApiKey($this->getEnvVariable("STRIPE_KEY"));

    // Read parameters
    $orderId = $this->retrieveInput("orderId", FILTER_SANITIZE_NUMBER_INT);
    $sessionId = $_REQUEST['session_id'];

    // Basic validation
    if (!$orderId || !$sessionId) {
        // Missing parameters -> treat as cancelled/invalid
        return new BasicViewModel(__DIR__ . "/../views/booking-cancel.php");
    }

    try {
        // Retrieve the Checkout Session from Stripe
        $session = \Stripe\Checkout\Session::retrieve($sessionId);
    } catch (\Exception $e) {
        // If Stripe API call fails, treat as cancelled/failed
        // (You may want to log $e->getMessage() to your application log.)
        return new BasicViewModel(__DIR__ . "/../views/booking-cancel.php");
    }

    // Verify that the session matches the expected order (extra safety)
    if (!isset($session->client_reference_id) || (string)$session->client_reference_id !== (string)$orderId) {
        // Mismatch -> do not complete the order
        return new BasicViewModel(__DIR__ . "/../views/booking-cancel.php");
    }

    // Stripe Checkout Session has a payment_status property. It will be 'paid' when completed.
    if (isset($session->payment_status) && $session->payment_status === 'paid') {
        $orderRepository = new OrderRepository();
        $orderRepository->completeOrder($orderId);
        return new BasicViewModel(__DIR__ . "/../views/booking-confirm.php");
    } else {
        // Payment not completed — cancel the order to free seats
        $orderRepository = new OrderRepository();
        $orderRepository->cancelOrder($orderId);
        return new BasicViewModel(__DIR__ . "/../views/booking-cancel.php");
    }
}

  public function cancelBooking() : BasicViewModel {
    require_once __DIR__ . "/../repositories/OrderRepository.php";

    $orderId = $this->retrieveInput("orderId", FILTER_SANITIZE_NUMBER_INT);
    $orderRepository = new OrderRepository();
    $orderRepository->cancelOrder($orderId);

    return new BasicViewModel("__DIR__ . /../views/booking-cancel.php");
  }
}