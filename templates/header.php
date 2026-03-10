<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>]Inventario SOFT</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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