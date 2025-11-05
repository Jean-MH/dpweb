<?php
include("../conexion.php"); // Ajusta la ruta según tu estructura

// Consulta para obtener los productos
$sql = "SELECT * FROM productos";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Productos</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
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
</head>
<body class="container py-4">

  <h2 class="text-center mb-4">📦 Lista de Productos</h2>

  <div class="row" href="<?= BASE_URL ?>ver-producto">
    <?php while ($prod = mysqli_fetch_assoc($resultado)): ?>
      <div class="col-md-3 mb-4">
        <div class="card producto-card shadow-sm">
          <img src="../<?= htmlspecialchars($prod['imagen']) ?>" 
               class="producto-img card-img-top" 
               alt="<?= htmlspecialchars($prod['nombre']) ?>"
               onerror="this.src='../img/sin-imagen.jpg';">
          <div class="card-body text-center">
            <h5 class="card-title"><?= htmlspecialchars($prod['nombre']) ?></h5>
            <p class="text-muted mb-2"><?= htmlspecialchars($prod['descripcion']) ?></p>
            <span class="badge bg-success fs-6">S/ <?= htmlspecialchars($prod['precio']) ?></span>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

</body>
</html>

<?php mysqli_close($conn); ?>
