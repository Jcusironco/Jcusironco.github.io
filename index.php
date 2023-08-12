
<?php 
    @session_start();
    if (isset($_SESSION['nick']))
    {
        header('location:inicio');
    }
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>Sistema MARCELO MOTORS</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/logis.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .logo {
            width: 170px;
            height: 170px;
            border-radius: 50%;
            object-fit: cover;
            object-position: center;
            margin-top: 30px;
        }

        .login-container {
            background-color: #ffffff;
            border-radius: 30px;
            box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
            margin-top: 30px;
        }

        .login-container h1 {
            font-size: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container form {
            margin-bottom: 20px;
        }

        .login-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            top: 62%;
            right: -2px;
            transform: translate(0, -50%);
            cursor: pointer;
            opacity: 0.5;
            transition: opacity 0.3s ease;
        }

        .toggle-password:hover {
            opacity: 1;
        }

        .toggle-password i {
            color: #cccccc;
            background-image: url("https://img.icons8.com/material-outlined/24/000000/visible--v2.png");
            background-size: 97%;
            text-indent: -9999px;
            display: inline-block;
            width: 24px;
            height: 24px;
        }

        .toggle-password i.hidden {
            background-image: url("https://img.icons8.com/material-outlined/24/000000/invisible--v2.png");
        }

        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
            width: 100%;
        }

        .btn:hover {
            background-color: #45a049;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <img src="img/logo.jpeg" class="logo">
    <div class="login-container">
        <h1>SISTEMA DE VENTA</h1>
        <form action="login/index.php" method="POST" autocomplete="off">
            <div>
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" required pattern="[A-Za-z]{8,15}" autofocus>
            </div>
            <div class="password-container">
                <label for="password">Contraseña</label>
                <input type="password" name="contra" id="password" required pattern="[A-Za-z0-9]{8,15}">
                <span class="toggle-password">
                    <i class="visible"></i>
                </span>
            </div>
            <div>
                <input type="submit" name="submit" value="Acceder" class="btn">
            </div>
        </form>
    </div>

    <script>
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const passwordType = passwordInput.getAttribute('type');
            passwordInput.setAttribute('type', passwordType === 'password' ? 'text' : 'password');
            togglePassword.querySelector('i').classList.toggle('hidden');
        });
    </script>
</body>
</html>
