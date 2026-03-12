<?php
session_start();
require '../config/db.php';


if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['toast'] = "Producto eliminado correctamente";
    $_SESSION['toast_type'] = "success";
}else {

    $_SESSION['toast'] = "ID de producto no proporcionado";
    $_SESSION['toast_type'] = "danger";
}

header("Location: ../pages/Dashboard.php?page=productos");
exit;
