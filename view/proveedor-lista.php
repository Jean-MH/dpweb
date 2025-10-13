<div class="container">
    <h4 class="mt-3 mb-3">Lista de Proveedores</h4>
    <table class="table table-bordered table-striped">
      <div>
  <a href="<?= BASE_URL ?>new-proveedor" class="btn btn-primary btn-sm">+ Nuevo</a>
    </div>
        <thead>
            <tr>
                <th>Nro</th>
                <th>RUC</th>
                <th>Razón Social</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="content_proveedores">

        </tbody>
    </table>
</div>
<script src="<?= BASE_URL ?>view/function/clients.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    view_proveedores();
  });
</script>