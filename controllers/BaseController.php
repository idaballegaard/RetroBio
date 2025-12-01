<?php
abstract class BaseController {

  private array $data = [];

  public function __construct() {
    $this->data = parse_ini_file(__DIR__ . "/../.env");
  }

  protected function getEnvVariable(string $key): ?string {
    return $this->data[$key] ?? null;
  }
}