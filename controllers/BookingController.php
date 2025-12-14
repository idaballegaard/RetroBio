<?php
require_once __DIR__ . "/BaseController.php";
require_once __DIR__ . "/../viewModels/BookingViewModel.php";
require_once __DIR__ . "/../repositories/ShowingRepository.php";
require_once __DIR__ . "/../repositories/SeatRepository.php";

class BookingController extends BaseController {
    public function showBookingPage($showingID): BookingViewModel {
        // Opret ViewModel
        $showingRepository = new ShowingRepository();
        $seatRepository = new SeatRepository();

        $showing = $showingRepository->getShowingById($showingID);
        if ($showing === null) {
            return new BookingViewModel(__DIR__ . "/../views/404.php");
        }

        $seats = $seatRepository->getSeatsByHallId($showing->getHall()->getHallID());
        $soldSeats = $seatRepository->getSoldSeatsByShowingId($showingID);

        $viewModel = new BookingViewModel(__DIR__ . "/../views/booking.php");
        $viewModel->setShowing($showing);
        $viewModel->setSeats($seats);
        $viewModel->setSoldSeats($soldSeats);
        return $viewModel;
    }

  public function processBooking() : ?BookingViewModel {
    $showingID = $_POST["showingId"];

    require_once __DIR__ . "/../repositories/OrderRepository.php";
    $seats = explode(",", $_POST['seats']);

    require_once __DIR__ . "/../repositories/ShowingRepository.php";
    $showingRepository = new ShowingRepository();
    $price = $showingRepository->getShowingPrice($showingID);

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
      print_r($seatRows);
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
        (int)$_POST['showingId'],
        $seats
    );

    require_once __DIR__ . "/../repositories/MovieRepository.php";
    $movieRepository = new MovieRepository();
    $movieTitle = $movieRepository->getMovieById((int)$_POST['showingId'])->getTitle();

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
                    'name' => $movieTitle
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
  }

  public function confirmBooking() : BasicViewModel {
    require_once __DIR__ . "/../repositories/OrderRepository.php";

    // Require Stripe and set API key
    require_once __DIR__ . "/../stripe/init.php";
    \Stripe\Stripe::setApiKey($this->getEnvVariable("STRIPE_KEY"));

    // Read parameters
    $orderId = isset($_GET['orderId']) ? (int)$_GET['orderId'] : null;
    $sessionId = isset($_GET['session_id']) ? $_GET['session_id'] : null;

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

  public function cancelBooking() {
    require_once __DIR__ . "/../repositories/OrderRepository.php";

    $orderId = (int)$_GET['orderId'];
    $orderRepository = new OrderRepository();
    $orderRepository->cancelOrder($orderId);

    return new BasicViewModel("__DIR__ . /../views/booking-cancel.php");
  }
}