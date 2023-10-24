<?php
session_start();
include "conexion.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT `id`, `nombre_usuario`, `contraseña` FROM `usuarios` WHERE `nombre_usuario` = '$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $hashed_password = $user['contraseña'];

        if (password_verify($password, $hashed_password)) {
            $_SESSION['usuario'] = $user['nombre_usuario'];
            $_SESSION['user_id'] = $user['id'];

            if ($user['nombre_usuario'] === 'administrador') {
                $_SESSION['nivel'] = 'superadmin';
            } else {
                $_SESSION['nivel'] = 'usuario_general';
            }

            header('Location: index.php');
            exit();
        } else {
            $error_message = "Contraseña incorrecta";
        }
    } else {
        $error_message = "Usuario no encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('https://media.admagazine.com/photos/642c731f514e94833674f3a5/3:2/w_3000,h_2000,c_limit/Arequipa%20Peru.jpg'); 
            background-size: cover; 
            background-repeat: no-repeat; 
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8); 
            padding: 20px;
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0,0,0,.05); 
            max-width: 400px; 
            margin-top: 50px; 
        }

        .btn-primary {
            background-color: #007bff; 
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #b490ca; 
            border-color: #fed6e3;
        }

        nav h1 {
            color: #5ee7df; 
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-light justify-content-center fs-3 mb-5">
        <h1 style="color: #ffffff;">Iniciar Sesión</h1>
    </nav>
    <div class="container text-center mx-auto my-5">
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Nombre de Usuario:</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary" name="login">Iniciar Sesión</button>
            </div>
        </form>
        <?php
        if (isset($error_message)) {
            echo '<div class="alert alert-danger mt-3">' . $error_message . '</div>';
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
