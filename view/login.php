<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    body {
      background-image: url('view/img/fondo.jpg');
      font-family: Georgia, 'Times New Roman', Times, serif;
      display: flex;
      background-repeat: no-repeat;
      background-size: cover;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-form {
      background-color:transparent;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 300px;
      text-align: center;
    }

    .login-form h2 {
      margin-bottom: 10px;
    }

    .login-form img {
      width: 60px;
      margin-bottom: 15px;
    }

    .login-form input {
      width: 100%;
      padding: 5px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .login-form button {
      width: 100%;
      padding: 10px;
      background-color: #63b7f2;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .login-form button:hover {
      background-color: #a0d0f1;
    }

    .forgot-password {
      margin-top: 10px;
    }

    .forgot-password a {
      color: #000;
      text-decoration: none;
    }

    .forgot-password a:hover {
      color: #a0d0f1;
      text-decoration: underline;
    }
  </style>
  <script>
    const base_url = '<?= BASE_URL; ?>';
  </script>
</head>
<body>
  <div class="login-form">
    <h2>Iniciar sesión</h2>
    <form id="frm_login">
      <img src="view/img/m.gif" alt="Logo">
      <input type="text" placeholder="username" id="username" name="username" >
      <input type="text" placeholder="password" id="password" name="password" >
      <button type="button" onclick="iniciar_sesion();">Entrar</button>
    </form>
    <div class="forgot-password">
      <a href="#">¿Olvidaste tu contraseña?</a>
    </div>
  </div>
  <script src="<?= BASE_URL; ?>view/function/user.js"></script>
</body>
</html>
