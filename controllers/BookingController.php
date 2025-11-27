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
}