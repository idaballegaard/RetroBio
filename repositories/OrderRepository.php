<?php
require_once __DIR__ . "/BaseRepository.php";
require_once __DIR__ . "/../models/Order.php";

class OrderRepository extends BaseRepository
{
  public function createOrder(float $unitPrice, int $numberOfTickets, int $userId, int $showingId, array $seats): int
  {
    $date = date("Y-m-d");
    $status = "pending";
    $totalPrice = $unitPrice * $numberOfTickets;

    $db = $this->connectDatabase();

    $db->beginTransaction();

    $stmt = $db->prepare("INSERT INTO `Order` (price, date, status, numberOfTickets, userId, showingId) VALUES (:price, :date, :status, :numberOfTickets, :userId, :showingId)");
    $stmt->execute([
      ':price' => $totalPrice,
      ':date' => $date,
      ':status' => $status,
      ':numberOfTickets' => $numberOfTickets,
      ':userId' => $userId,
      ':showingId' => $showingId,
    ]);

    $orderId = $db->lastInsertId();
    $seatStmt = $db->prepare("INSERT INTO OrderSeat (orderId, seatId) VALUES (:orderId, :seatId)");
    foreach ($seats as $seatId) {
      $seatStmt->execute([
        ':orderId' => $orderId,
        ':seatId' => $seatId,
      ]);
    }

    $db->commit();

    return $orderId;
  }

  public function completeOrder(int $orderId) {
    $db = $this->connectDatabase();

    $stmt = $db->prepare("UPDATE `Order` SET status = 'completed' WHERE orderId = :orderId");
    $stmt->execute([
      ':orderId' => $orderId,
    ]);
  }

  public function cancelOrder(int $orderId) {
    $db = $this->connectDatabase();

    $db->beginTransaction();

    $stmt = $db->prepare("DELETE FROM `Order` WHERE orderId = :orderId");
    $stmt->execute([
      ':orderId' => $orderId,
    ]);

    $seatStmt = $db->prepare("DELETE FROM OrderSeat WHERE orderId = :orderId");
    $seatStmt->execute([
      ':orderId' => $orderId,
    ]);

    $db->commit();
  }

  public function getOrdersByUserId(int $userId): array {
    require_once __DIR__ . "/MovieRepository.php";
    $movieRepository = new MovieRepository();
    
    $db = $this->connectDatabase();
    $stmt = $db->prepare("SELECT * FROM `Order` WHERE userId = :userId ORDER BY date DESC");
    $stmt->execute([':userId' => $userId]);

    $orders = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $order = new Order();
      $order->setOrderId((int)$row['orderID']);
      $order->setPrice((float)$row['price']);
      $order->setDate($row['date']);
      $order->setStatus($row['status']);
      $order->setNumberOfTickets((int)$row['numberOfTickets']);
      $order->setUserId((int)$row['userID']);
      $order->setShowingId((int)$row['showingID']);
      $order->setMovie($movieRepository->getMovieByShowingId((int)$row['showingID']));
      $orders[] = $order;
    }
    return $orders;
  }

  /** @return Order[] */
  public function getAllOrders(): array {
    UserRepository::dieIfNotAdmin();

    require_once __DIR__ . "/MovieRepository.php";
    $movieRepository = new MovieRepository();

    $db = $this->connectDatabase();
    $stmt = $db->prepare("SELECT * FROM `Order`");
    $stmt->execute();

    $orders = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $order = new Order();
      $order->setOrderId((int)$row['orderID']);
      $order->setPrice((float)$row['price']);
      $order->setDate($row['date']);
      $order->setStatus($row['status']);
      $order->setNumberOfTickets((int)$row['numberOfTickets']);
      $order->setUserId((int)$row['userID']);
      $order->setShowingId((int)$row['showingID']);
      $order->setMovie($movieRepository->getMovieByShowingId((int)$row['showingID']));
      $orders[] = $order;
    }
    return $orders;
  }
}