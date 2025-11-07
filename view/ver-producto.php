<?php
require_once "./model/ProductoModel.php";
$objProducto = new ProductoModel();
$productos = $objProducto->verProductos();

// Debugging
if (empty($productos)) {
    error_log("No hay productos para mostrar en la vista");
}
?>
<style>
  .producto-card {
    transition: transform 0.2s;
  }
  .producto-card:hover {
    transform: scale(1.05);
  }
  .producto-img {
    height: 200px;
    object-fit: cover;
    border-radius: 8px 8px 0 0;
  }
</style>
<div class="container py-4">

  <h2 class="text-center mb-4">Lista de Productos</h2>

  <div class="row">
    <?php if (empty($productos)): ?>
      <div class="col-12 text-center">
        <div class="alert alert-info">
          No hay productos disponibles en este momento.
        </div>
      </div>
    <?php else: ?>
      <?php foreach ($productos as $prod): ?>
        <div class="col-md-3 mb-4">
          <div class="card producto-card shadow-sm">
            <?php
              $img_rel = !empty($prod->imagen) ? htmlspecialchars($prod->imagen) : 'view/img/exito.gif';
              $img_src = BASE_URL . $img_rel;
            ?>
            <img src="<?= $img_src ?>" 
                 class="producto-img card-img-top" 
                 alt="<?= htmlspecialchars($prod->nombre) ?>"
                 onerror="this.src='<?= BASE_URL ?>view/img/error.png';">
            <div class="card-body text-center">
              <h5 class="card-title"><?= htmlspecialchars($prod->nombre) ?></h5>
              <p class="text-muted mb-2"><?= htmlspecialchars($prod->detalle) ?></p>
              <span class="badge bg-success fs-6">S/ <?= htmlspecialchars($prod->precio) ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

</div>
