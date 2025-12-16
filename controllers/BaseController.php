<?php
abstract class BaseController {

  private array $data = [];

  public function __construct() {
    $this->data = parse_ini_file(__DIR__ . "/../.env");
  }

  protected function getEnvVariable(string $key): ?string {
    return $this->data[$key] ?? null;
  }

  protected function handleUpload(int $idPrefix, string $type, string $fieldName, int $maxWidth, int $maxHeight) {
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
      return null;
    }

    $fileTmpPath = $_FILES[$fieldName]['tmp_name'];
    $fileName = $_FILES[$fieldName]['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($fileExtension, $allowedExtensions)) {
      return null;
    }

    list($width, $height) = getimagesize($fileTmpPath);
    if ($width > $maxWidth || $height > $maxHeight) {
      // Resize image
      $ratio = min($maxWidth / $width, $maxHeight / $height);
      $newWidth = (int)($width * $ratio);
      $newHeight = (int)($height * $ratio);
      $srcImage = null;
      switch ($fileExtension) {
        case 'jpg':
        case 'jpeg':
          $srcImage = imagecreatefromjpeg($fileTmpPath);
          break;
        case 'png':
          $srcImage = imagecreatefrompng($fileTmpPath);
          break;
        case 'gif':
          $srcImage = imagecreatefromgif($fileTmpPath);
          break;
        case 'webp':
          $srcImage = imagecreatefromwebp($fileTmpPath);
          break;
      }
      $dstImage = imagecreatetruecolor($newWidth, $newHeight);
      imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    }

    $newFileName = $idPrefix . '_' . $fileName;
    $uploadFileDir = __DIR__ . '/../uploads/' . $type . '/';
    $destPath = $uploadFileDir . $newFileName;

    if (!is_dir($uploadFileDir)) {
      mkdir($uploadFileDir, 0755, true);
    }

    if (isset($dstImage)) {
      // Save the resized image instead of the temp file
      switch ($fileExtension) {
        case 'jpg':
        case 'jpeg':
          imagejpeg($dstImage, $destPath, 90);
          break;
        case 'png':
          imagepng($dstImage, $destPath);
          break;
        case 'gif':
          imagegif($dstImage, $destPath);
          break;
        case 'webp':
          imagewebp($dstImage, $destPath);
          break;
      }
    }
  }

  protected function retrieveInput(string $fieldName, ?int $filter = null, mixed $defaultValue = ''): mixed {
    if($filter) {
      return isset($_REQUEST[$fieldName]) ? filter_var(trim($_REQUEST[$fieldName]), $filter) : $defaultValue;
    } else {
      return isset($_REQUEST[$fieldName]) ? htmlspecialchars($_REQUEST[$fieldName]) : $defaultValue;
    }
  }
}