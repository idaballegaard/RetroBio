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

  public function processBooking() {

    require_once __DIR__ . "/../repositories/OrderRepository.php";
    $seats = explode(",", $_POST['seats']);

    require_once __DIR__ . "/../repositories/ShowingRepository.php";
    $showingRepository = new ShowingRepository();
    $price = $showingRepository->getShowingPrice((int)$_POST['showingId']);

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
    $movieTitle = $movieRepository->getMovieTitleByShowingId((int)$_POST['showingId']);

    require_once __DIR__ . "/../stripe/init.php";
    \Stripe\Stripe::setApiKey($this->getEnvVariable("STRIPE_KEY"));
    header('Content-Type: application/json');

    $YOUR_DOMAIN = 'http://localhost:4242';

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
        'success_url' => $this->getEnvVariable("BASE_URL") . '/confirmBooking?orderId=' . $orderId,
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

    $orderId = (int)$_GET['orderId'];
    $orderRepository = new OrderRepository();
    $orderRepository->completeOrder($orderId);

    return new BasicViewModel("__DIR__ . /../views/booking-confirm.php");
  }

  public function cancelBooking() {
    require_once __DIR__ . "/../repositories/OrderRepository.php";

    $orderId = (int)$_GET['orderId'];
    $orderRepository = new OrderRepository();
    $orderRepository->cancelOrder($orderId);

    return new BasicViewModel("__DIR__ . /../views/booking-cancel.php");
  }
}