<?php
session_start();
require 'config/db.php';

// Si ya está logueado, redirige al dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Login exitoso
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nombre'] = $user['nombre'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Email o contraseña incorrectos";
    }
}


?>

<h2>Iniciar sesión</h2>

<?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST" action="index.php">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <button type="submit">Iniciar sesión</button>
</form>

<p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>

<?php include 'templates/footer.php'; ?>