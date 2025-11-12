<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background:#4FB83B;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-box {
      background: black;
      border-radius: 15px;
      padding: 2rem;
      box-shadow: 0 0 15px rgba(255, 255, 255, 1);
      width: 100%;
      max-width: 400px;
    }
    .login-box h2 {
      color: white;
      margin-bottom: 1.5rem;
    }
    .login-box label{
      color: white;
    }
    .logo {
      width: 80px;
      margin-bottom: 1rem;
    }
    .w-100{
      background: #22960aff;
      color: white;
      border-radius: 10px;
    }
  </style>
  <script>
    const base_url = '<?= BASE_URL; ?>';
  </script>
</head>
<body>

<div class="login-box text-center">
  <img src="https://upload.wikimedia.org/wikipedia/commons/8/89/HD_transparent_picture.png" alt="Logo" class="logo">
  <h2>Iniciar Sesión</h2>
  <form id="frm_login">
    <div class="mb-3 text-start">
      <label for="username" class="form-label">Usuario</label>
      <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3 text-start">
      <label for="password" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="button" class=" w-100" id="boton" onclick="iniciar_sesion();">Ingresar</button>
  </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL; ?>view/function/user.js"></script>
</body>
</html>