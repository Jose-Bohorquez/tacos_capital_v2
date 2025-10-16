<?php
$cart = $cart ?? [];
if (!$cart) { echo '<span>Carrito vacío</span>'; return; }
echo '<a class="btn" href="/checkout">Ir al checkout (' . array_sum($cart) . ')</a>';
