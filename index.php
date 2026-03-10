<?php
session_start();

require 'config/db.php';

$toast = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];

        header("Location: dashboard.php");
        exit();
    } else {

        $toast = "Email o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            height: 100vh;
        }

        .auth-card {
            width: 420px;
            border-radius: 15px;
        }
    </style>

</head>

<body class="d-flex justify-content-center align-items-center">

    <div class="card auth-card shadow-lg p-4">

        <div class="text-center mb-4">

            <h3 class="fw-bold">Iniciar sesión</h3>
            <p class="text-muted">Sistema Inventario</p>

        </div>

        <form method="POST">

            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Correo electrónico">
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Contraseña">
            </div>

            <button class="btn btn-primary w-100 mb-3">
                Entrar
            </button>

            <div class="text-center">

                <span class="text-muted">¿No tienes cuenta?</span>

                <a href="register.php" class="fw-semibold text-decoration-none">
                    Crear cuenta
                </a>

            </div>

        </form>

    </div>

    <?php if ($toast): ?>

        <div class="position-fixed top-0 end-0 p-3" style="z-index:9999">

            <div id="liveToast" class="toast text-bg-danger border-0">

                <div class="d-flex">

                    <div class="toast-body">
                        <?php echo $toast ?>
                    </div>

                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>

                </div>

            </div>

        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {

                var toastEl = document.getElementById("liveToast");

                var toast = new bootstrap.Toast(toastEl, {
                    delay: 3000
                });

                toast.show();

            });
        </script>

    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>