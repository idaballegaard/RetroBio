<?php
require_once __DIR__ . "/BaseRepository.php";
require_once __DIR__ . "/../models/Seat.php";

class SeatRepository extends BaseRepository {

    /** @return Seat[] */
    function getSeatsByHallId($hallID): array {
        $pdo = $this->connectDatabase();
        $stmt = $pdo->prepare("SELECT seatID, `number`, rowNumber, hallID FROM Seat WHERE hallID = :hallID ORDER BY rowNumber, `number`");
        $stmt->bindValue(":hallID", $hallID, PDO::PARAM_INT);
        $stmt->execute();
        $seats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $seats[] = $this->mapRowToSeat($row);
        }
        return $seats;
    }

    /** @return Seat[] */
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
            $seats[] = $this->mapRowToSeat($row);
        }
        return $seats;
    }

    private function mapRowToSeat($row): Seat {
        $seat = new Seat();
        $seat->setSeatID($row['seatID']);
        $seat->setNumber($row['number']);
        $seat->setRowNumber($row['rowNumber']);
        $seat->setHallID($row['hallID']);
        return $seat;
    }
    function getSeatRowsByIds(array $seatIDs): array {
        if (empty($seatIDs)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($seatIDs), '?'));
        $pdo = $this->connectDatabase();
        $stmt = $pdo->prepare("SELECT DISTINCT rowNumber FROM Seat WHERE seatID IN ($placeholders)");
        foreach ($seatIDs as $index => $seatID) {
            $stmt->bindValue($index + 1, $seatID, PDO::PARAM_INT);
        }
        $stmt->execute();

        $seatRows = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $seatRows[] = $row['rowNumber'];
        }
        return $seatRows;
    }
}