<?php
namespace App\Support;

final class MercadoPago
{
  /**
   * @param array $items Cada item: ['title'=>string, 'quantity'=>int, 'unit_price'=>float]
   * @param int   $pedidoId
   * @return array ['init_point'=>string, 'id'=>string]
   */
  public static function crearPreferencia(array $items, int $pedidoId): array
  {
    $token = $_ENV['MP_ACCESS_TOKEN'] ?? '';
    if (!$token) throw new \RuntimeException('Falta MP_ACCESS_TOKEN en .env');

    $payload = [
      "items" => array_map(fn($it) => [
        "title"       => (string)$it['title'],
        "quantity"    => (int)$it['quantity'],
        "currency_id" => "COP",
        "unit_price"  => (float)$it['unit_price'],
      ], $items),
      "external_reference" => (string)$pedidoId,
      "back_urls" => [
        "success"  => rtrim($_ENV['APP_URL'], '/') . "/pago/exito",
        "failure"  => rtrim($_ENV['APP_URL'], '/') . "/pago/fallo",
        "pending"  => rtrim($_ENV['APP_URL'], '/') . "/pago/pendiente",
      ],
      "auto_return"      => "approved",
      "notification_url" => rtrim($_ENV['APP_URL'], '/') . "/webhooks/mercadopago"
    ];

    $ch = curl_init("https://api.mercadopago.com/checkout/preferences");
    curl_setopt_array($ch, [
      CURLOPT_HTTPHEADER     => ["Authorization: Bearer {$token}", "Content-Type: application/json"],
      CURLOPT_POST           => true,
      CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT        => 25,
    ]);
    $resp = curl_exec($ch);
    $code = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    $err  = curl_error($ch);
    curl_close($ch);

    if ($resp === false || $code >= 400) throw new \RuntimeException("Error MP ({$code}): {$err} {$resp}");
    $json = json_decode($resp, true);
    if (!is_array($json) || empty($json['init_point']) || empty($json['id'])) {
      throw new \RuntimeException("Respuesta MP inválida: {$resp}");
    }
    return ["init_point" => $json['init_point'], "id" => $json['id']];
  }
}
