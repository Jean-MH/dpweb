<div class="container">
  <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
    <h4><center>Lista de Clientes</center></h4>
    <div>
      <a href="<?= BASE_URL ?>new-clients" class="btn btn-primary btn-sm">+ Nuevo</a>
    </div>
  </div>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Nro</th>
        <th>DNI</th>
        <th>Nombres y Apellidos</th>
        <th>rol</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody id="content_clients"></tbody>
  </table>
</div>

<script src="<?= BASE_URL ?>view/function/clients.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    view_clients();
  });
</script>
