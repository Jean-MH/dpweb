<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    body {
      font-family:Georgia, 'Times New Roman', Times, serif;
      background-color:rgb(68, 125, 248);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .login-form {
      background-color:paleturquoise;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 300px;
    }
    .login-form h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    .login-form input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .login-form button {
      width: 100%;
      padding: 10px;
      background-color:rgba(40, 54, 250, 0.95);
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .login-form button:hover {
      background-color:cadetblue;
    }
    .login-form .forgot-password {
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <div class="login-form">
    <h2>Iniciar sesión</h2>
    <form action="/ruta-del-servidor" method="POST">
    <center><img src="view/img/m.gif" alt="" width="60px"></center>
      <input type="text" name="usuario" placeholder="Usuario" required>
      <input type="password" name="contraseña" placeholder="Contraseña" required>
      <button type="submit">Entrar</button>
    </form>
    <div class="forgot-password">
      <a href="#">¿Olvidaste tu contraseña?</a>
    </div>
  </div>

</body>
</html>
