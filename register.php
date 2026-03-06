<?php
session_start();
require 'config/db.php';
include 'templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($nombre) || empty($email) || empty($password)) {
        echo "<p>Todos los campos son obligatorios</p>";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (nombre, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$nombre, $email, $password_hash]);
            echo "<p>Registro exitoso. <a href='login.php'>Inicia sesión</a></p>";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                echo "<p>El email ya está registrado</p>";
            } else {
                echo "<p>Error: " . $e->getMessage() . "</p>";
            }
        }
    }
}
?>

<form method="POST" action="register.php">
    <input type="text" name="nombre" placeholder="Nombre" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <button type="submit">Registrarse</button>
</form>

<?php include 'templates/footer.php'; ?>