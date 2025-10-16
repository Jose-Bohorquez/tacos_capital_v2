<?php
namespace App\Support;

final class Csrf {
  public static function token(): string {
    if (empty($_SESSION['csrf_token'])) {
      $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
  }
  public static function check(?string $t): bool {
    return is_string($t) && hash_equals($_SESSION['csrf_token'] ?? '', $t);
  }
}
