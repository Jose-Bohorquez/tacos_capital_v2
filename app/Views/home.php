<?php $this->layout('layout', ['title' => 'Inicio']) ?>

<h1>Novedades</h1>
<div class="grid">
  <?php foreach ($productos as $p): ?>
    <article class="card">
      <a class="card-link" href="/p/<?= htmlspecialchars($p['slug']) ?>">
        <img src="/media/<?= htmlspecialchars($p['slug']) ?>-cover.webp"
             alt="<?= htmlspecialchars($p['titulo']) ?>" loading="lazy" />
        <h2><?= htmlspecialchars($p['titulo']) ?></h2>
        <strong>$<?= number_format($p['precio'], 0, ',', '.') ?></strong>
      </a>
      <button 
        class="btn"
        hx-post="/api/carrito/agregar"
        hx-vals='{"producto_id": <?= (int)$p["id"] ?>, "cantidad": 1}'
        hx-target="#mini-carrito"
        hx-swap="outerHTML">Agregar</button>
    </article>
  <?php endforeach; ?>
</div>

<div id="mini-carrito">
  <?php echo $this->insert('partials/mini_carrito', ['cart' => $_SESSION['cart'] ?? []]); ?>
</div>
