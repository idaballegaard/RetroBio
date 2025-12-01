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
    $seats = $_POST['seats'];
    $showingID = (int)$_POST['showingId'];
    $tickets = $_POST['tickets'];

    print_r($seats);
    print_r($showingID);
    print_r($tickets);

    return;



    require_once __DIR__ . "/../stripe/init.php";

    $env = parse_ini_file(__DIR__ . "/../.env");
    \Stripe\Stripe::setApiKey($this->getEnvVariable("STRIPE_KEY"));
    header('Content-Type: application/json');

    $YOUR_DOMAIN = 'http://localhost:4242';

    $checkout_session = \Stripe\Checkout\Session::create([
        'client_reference_id' => $showingID,
        'line_items' => [[
            'quantity' => 1,
            'price_data' => [
                'currency' => 'usd',
                'unit_amount' => 2000, // amount in cents (e.g., $20.00)
                'product_data' => [
                    'name' => 'My Product'
                ],
            ],
        ]],
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN . '/success.html',
        'automatic_tax' => [
            'enabled' => true,
        ],
    ]);

    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);
  }
}