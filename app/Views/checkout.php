<?php $this->layout('layout', ['title' => 'Checkout']) ?>
<h1>Checkout</h1>

<table class="table">
  <thead><tr><th>Producto</th><th>Cant</th><th>Precio</th><th>Subtotal</th></tr></thead>
  <tbody>
  <?php foreach ($items as $it): 
    $cant = $cart[$it['id']] ?? 0;
    $sub = $it['precio'] * $cant; ?>
    <tr>
      <td><?= htmlspecialchars($it['titulo']) ?></td>
      <td><?= (int)$cant ?></td>
      <td>$<?= number_format($it['precio'],0,',','.') ?></td>
      <td>$<?= number_format($sub,0,',','.') ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
  <tfoot><tr><th colspan="3">Total</th><th>$<?= number_format($total,0,',','.') ?></th></tr></tfoot>
</table>

<form method="post" action="/checkout/pagar" class="checkout-form">
  <input name="email" type="email" placeholder="Correo" required>
  <input name="telefono" placeholder="Teléfono" required>
  <input name="direccion" placeholder="Dirección de entrega" required>
  <button class="btn">Pagar con Mercado Pago</button>
</form>
