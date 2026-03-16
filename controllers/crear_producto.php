
<?php
    session_start();
    require '../config/db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];

        $sql = "INSERT INTO productos (nombre, precio, cantidad)
                VALUES (?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$nombre, $precio, $cantidad])) {

            $_SESSION['toast'] = "Producto creado correctamente";
            $_SESSION['toast_type'] = "success";
        } else {

            $_SESSION['toast'] = "Error al crear producto";
            $_SESSION['toast_type'] = "danger";
        }
    }

    header("Location: ../pages/Dashboard.php?page=productos");
exit;
