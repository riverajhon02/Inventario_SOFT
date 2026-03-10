<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'config/db.php';

$toast = "";
$toastType = "";

/* Cuando se envía el formulario */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($nombre == "" || $email == "" || $password == "") {

        $toast = "Todos los campos son obligatorios";
        $toastType = "danger";

    } else {

        $stmt = $pdo->prepare("SELECT id FROM users WHERE email=?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {

            $toast = "El correo ya está registrado";
            $toastType = "danger";

        } else {

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users(nombre,email,password) VALUES(?,?,?)");

            if ($stmt->execute([$nombre,$email,$passwordHash])) {

                $toast = "Usuario creado correctamente";
                $toastType = "success";

            } else {

                $toast = "Error al registrar usuario";
                $toastType = "danger";

            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<title>Registro</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
height:100vh;
}

.auth-card{
width:420px;
border-radius:15px;
}
</style>

</head>

<body class="d-flex align-items-center justify-content-center">

<div class="card auth-card shadow-lg p-4">

<div class="text-center mb-4">
<h3 class="fw-bold">Crear cuenta</h3>
<p class="text-muted">Sistema Inventario</p>
</div>

<form method="POST">

<div class="mb-3">
<input type="text" name="nombre" class="form-control" placeholder="Nombre completo">
</div>

<div class="mb-3">
<input type="email" name="email" class="form-control" placeholder="Correo electrónico">
</div>

<div class="mb-3">
<input type="password" name="password" class="form-control" placeholder="Contraseña">
</div>

<button class="btn btn-primary w-100 mb-3">
Crear cuenta
</button>

<div class="text-center">
<span class="text-muted">¿Ya tienes cuenta?</span>
<a href="index.php">Iniciar sesión</a>
</div>

</form>

</div>

<?php if($toast!=""): ?>

<div class="position-fixed top-0 end-0 p-3" style="z-index:9999">

<div id="liveToast" class="toast text-bg-<?php echo $toastType; ?> border-0">

<div class="d-flex">

<div class="toast-body">
<?php echo $toast; ?>
</div>

<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>

</div>
</div>
</div>

<script>
document.addEventListener("DOMContentLoaded",function(){

var toastEl=document.getElementById("liveToast");
var toast=new bootstrap.Toast(toastEl,{delay:3000});
toast.show();

});
</script>

<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>