<?php
require_once __DIR__ . "/BaseRepository.php";
require_once __DIR__ . "/../models/Seat.php";

class SeatRepository extends BaseRepository {
    
    function getSeatsByHallId($hallID): array {
        $pdo = $this->connectDatabase();
        $stmt = $pdo->prepare("SELECT seatID, `number`, rowNumber, hallID FROM Seat WHERE hallID = :hallID ORDER BY rowNumber, `number`");
        $stmt->bindValue(":hallID", $hallID, PDO::PARAM_INT);
        $stmt->execute();
        $seats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $seat = new Seat();
            $seat->setSeatID($row['seatID']);
            $seat->setNumber($row['number']);
            $seat->setRowNumber($row['rowNumber']);
            $seat->setHallID($row['hallID']);
            $seats[] = $seat;
        }
        return $seats;
    }

    function getSoldSeatsByShowingId($showingID): array {
        $pdo = $this->connectDatabase();
        $stmt = $pdo->prepare("SELECT s.seatID, s.`number`, s.rowNumber, s.hallID 
                               FROM Seat s
                               JOIN OrderSeat os ON s.seatID = os.seatID
                               JOIN `Order` o ON os.orderID = o.orderID
                               WHERE o.showingID = :showingID
                               ORDER BY s.rowNumber, s.`number`");
        $stmt->bindValue(":showingID", $showingID, PDO::PARAM_INT);
        $stmt->execute();
        $seats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $seat = new Seat();
            $seat->setSeatID($row['seatID']);
            $seat->setNumber($row['number']);
            $seat->setRowNumber($row['rowNumber']);
            $seat->setHallID($row['hallID']);
            $seats[] = $seat;
        }
        return $seats;
    }

}