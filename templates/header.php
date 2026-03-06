<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>]Inventario SOFT</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav>
    <a href="index.php">Inicio</a>
    <?php if(isset($_SESSION['user_id'])): ?>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Cerrar sesión</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Registro</a>
    <?php endif; ?>
</nav>
<hr>