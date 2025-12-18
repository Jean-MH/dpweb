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

  <h2 class="text-center mb-4">Vista de Productos</h2>

  <div class="row">
    <!-- Columna de Productos -->
    <div class="col-lg-8">
      <div class="row">
        <?php if (empty($productos)): ?>
          <div class="col-12 text-center">
            <div class="alert alert-info">
              No hay productos disponibles en este momento.
            </div>
          </div>
        <?php else: ?>
          <?php foreach ($productos as $prod): ?>
            <div class="col-md-4 mb-4">
              <div class="card producto-card shadow-sm h-100">
                <?php
                $img_rel = !empty($prod->imagen) ? htmlspecialchars($prod->imagen) : 'view/img/exito.gif';
                $img_src = BASE_URL . $img_rel;
                ?>
                <img src="<?= $img_src ?>"
                  class="producto-img card-img-top"
                  alt="<?= htmlspecialchars($prod->nombre) ?>"
                  onerror="this.src='<?= BASE_URL ?>view/img/error.png';">
                <div class="card-body d-flex flex-column text-center">
                  <h5 class="card-title"><?= htmlspecialchars($prod->nombre) ?></h5>
                  <p class="text-muted mb-2 flex-grow-1"><?= htmlspecialchars($prod->detalle) ?></p>
                  <span class="badge bg-success fs-6 mb-3">S/ <?= htmlspecialchars(number_format((float)$prod->precio, 2)) ?></span>
                  <div class="d-grid gap-2 mt-auto">
                    <!-- AGREGAR AL CARRITO -->
                    <button class="btn btn-success btn-sm"
                      onclick="agregarAlCarrito(<?= $prod->id ?>)">
                      <i class="fas fa-cart-plus me-1"></i> Agregar al carrito
                    </button>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>

    <!-- Columna del Carrito de Compras -->
    <div class="col-lg-4">
      <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i> Carrito de Compras</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Cant.</th>
                  <th>Subtotal</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="lista_compra">
                <!-- Los productos se cargarán aquí -->
                <tr><td colspan="4" class="text-center">Cargando...</td></tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <strong>Subtotal:</strong>
                <span id="subtotal_general">S/ 0.00</span>
            </div>
            <div class="d-flex justify-content-between">
                <strong>IGV (18%):</strong>
                <span id="igv_general">S/ 0.00</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-bold fs-5">
                <strong>Total:</strong>
                <span id="total_general">S/ 0.00</span>
            </div>
            <button onclick="iniciarProcesoVenta()" class="btn btn-success w-100 mt-3">Proceder al Pago</button>
        </div>
      </div>
    </div>
  </div>

</div>
<script>
  // La función agregarAlCarrito que ya tenías
  async function agregarAlCarrito(idProducto) {
    const datos = new FormData();
    datos.append("id_producto", idProducto);
    datos.append("cantidad", 1);

    try {
      const res = await fetch(
        base_url + 'control/VentaController.php?tipo=registrarTemporal',
        { method: "POST", body: datos }
      );
      const data = await res.json();

      if (data.status) {
        // Refrescar el carrito
        listar_temporales();
        // Mostrar notificación de éxito
        Swal.fire({
          icon: 'success',
          title: '¡Agregado!',
          text: 'Producto añadido al carrito.',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true
        });
      } else {
        Swal.fire('Error', data.msg || 'No se pudo agregar el producto', 'error');
      }
    } catch (error) {
      console.error("Error:", error);
      Swal.fire('Error', 'Ocurrió un problema de conexión.', 'error');
    }
  }

  // Nueva función para el proceso de venta
  function iniciarProcesoVenta() {
    Swal.fire({
      title: 'Confirmar Venta',
      html: `
        <p>Ingrese el DNI del cliente para continuar.</p>
        <input type="text" id="swal-dni" class="swal2-input" placeholder="DNI del Cliente">
      `,
      confirmButtonText: 'Buscar Cliente',
      showCancelButton: true,
      cancelButtonText: 'Cancelar',
      focusConfirm: false,
      preConfirm: () => {
        const dni = document.getElementById('swal-dni').value;
        if (!dni) {
          Swal.showValidationMessage(`Por favor, ingrese un DNI`);
          return false;
        }
        // Llamamos a la función que busca en la BD
        return buscarClientePorDni(dni);
      }
    }).then((result) => {
      // Si se encontró el cliente y se confirmó la venta
      if (result.isConfirmed && result.value) {
        const cliente = result.value;
        Swal.fire({
          title: 'Venta Confirmada',
          html: `Se registrará la venta a nombre de: <br><strong>${cliente.razon_social}</strong>`,
          icon: 'success',
          timer: 2000,
          showConfirmButton: false
        });
        // Llamamos a la función para registrar la venta final
        registrarVentaFinal(cliente.id);
      }
    });
  }
</script>