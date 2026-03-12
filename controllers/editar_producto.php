<?php

require '../config/db.php';
session_start();


if($_SERVER["REQUEST_METHOD"] == "POST"){

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];


    $stmt = $pdo->prepare("
        
        UPDATE productos 
        SET nombre = ?, precio = ?, cantidad = ?
        WHERE id = ?
    ");

    $stmt->execute([$nombre, $precio, $cantidad, $id]);
    $_SESSION['toast'] = "Producto actualizado correctamente";
    $_SESSION['toast_type'] = "success";
 

}else{
    $_SESSION['toast'] = "Error al actualizar producto";
    $_SESSION['toast_type'] = "danger";
   
}

 header("Location: ../pages/Dashboard.php?page=productos");



exit;