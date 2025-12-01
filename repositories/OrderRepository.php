<?php
require_once __DIR__ . "/repositories/BaseRepository.php";

class OrderRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
    }

    public function createOrder(float $price, int $numberOfTickets, int $userId, int $showingId, array $seats): int {
      $db = $this->connectDatabase();
      $stmt = $db->prepare("INSERT INTO Order (price, date, status, numberOfTickets, userId, showingId) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("id", $userId, $totalAmount);
      $stmt->execute();
      return $stmt->insert_id;


}