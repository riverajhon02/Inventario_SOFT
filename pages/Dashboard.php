<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    
    header("Location: ../index.php");
    exit();
}

// echo "Acceso denegado. Por favor, inicia sesión.";
require '../config/db.php';
$toast = $_SESSION['toast'] ?? null;
$toast_type = $_SESSION['toast_type'] ?? null;
unset($_SESSION['toast']);


?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <title>Sistema de Inventario</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ICONOS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background: #f4f6f9;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #343a40;
            position: fixed;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 15px;
        }

        .sidebar a:hover {
            background: #495057;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>

</head>

<body>

    <!-- SIDEBAR -->

    <div class="sidebar">

        <h4 class="text-center text-white mt-3">Inventario</h4>

        <hr class="text-white">

        <a href="?page=dashboard">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="?page=registrar_producto">
            <i class="bi bi-plus-square"></i> Registrar Producto
        </a>

        <a href="?page=productos">
            <i class="bi bi-box"></i> Ver Productos
        </a>

    </div>

    <!-- CONTENIDO -->

    <div class="content">

        <!-- NAVBAR -->

        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">

            <div class="container-fluid">

                <span class="navbar-brand">Sistema Inventario</span>

                <div class="d-flex">

                    <span class="me-3 mt-2">
                        👤 <?php echo $_SESSION['user_name']; ?>
                    </span>

                    <a href="../controllers/logout.php" class="btn btn-danger btn-sm">
                        Cerrar sesión
                    </a>

                </div>

            </div>

        </nav>


        <!-- AREA DINAMICA -->

        <?php

        $page = $_GET['page'] ?? 'dashboard';

        if ($page == "registrar_producto") {
        ?>

            <div class="card shadow">
                <div class="card-body">

                    <h4>Registrar Producto</h4>

                    <form action="../controllers/crear_producto.php" method="POST">

                        <div class="mb-3">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Precio</label>
                            <input type="number" name="precio" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Cantidad</label>
                            <input type="number" name="cantidad" class="form-control">
                        </div>

                        <button class="btn btn-primary">
                            Guardar
                        </button>

                    </form>

                </div>
            </div>

        <?php
        } elseif ($page == "productos") {
        ?>

            <div class="card shadow">
                <div class="card-body">

                    <h4>Productos</h4>

                    <table class="table table-striped">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Acciones</th>

                            </tr>
                        </thead>

                        <tbody>

                            <?php

                            // $conn = new mysqli("localhost", "root", "", "inventario");

                            $stmt = $pdo->query("SELECT * FROM productos");
                            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);


                            foreach ($productos as $row) {

                                echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['nombre']}</td>
                                    <td>{$row['precio']}</td>
                                    <td>{$row['cantidad']}</td>
                                    <td>

                                        <button 
                                            class='btn btn-warning btn-sm btn-editar'
                                            data-bs-toggle='modal'
                                            data-bs-target='#modalEditar'
                                            data-id='{$row['id']}'
                                            data-nombre=\"{$row['nombre']}\"
                                            data-precio='{$row['precio']}'
                                            data-cantidad='{$row['cantidad']}'
                                        >
                                            ✏️
                                        </button>

                                        <a 
                                            href='../controllers/eliminar_producto.php?id={$row['id']}'
                                            class='btn btn-danger btn-sm'
                                            onclick='return confirm(\"¿Eliminar este producto?\")'
                                        >
                                            🗑
                                        </a>

                                    </td>
                                    
                                    </tr>";
                            }

                            ?>

                        </tbody>

                    </table>

                    <div class="modal fade" id="modalEditar" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <form action="../controllers/editar_producto.php" method="POST">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Producto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <input type="hidden" name="id" id="edit_id">

                                        <div class="mb-3">
                                            <label>Nombre</label>
                                            <input type="text" name="nombre" id="edit_nombre" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label>Precio</label>
                                            <input type="number" name="precio" id="edit_precio" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label>Cantidad</label>
                                            <input type="number" name="cantidad" id="edit_cantidad" class="form-control">
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-primary">Guardar cambios</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        <?php
        } else {
            $stmt = $pdo->query("SELECT COUNT(*) FROM productos");
            $total_productos = $stmt->fetchColumn();
        ?>

            <div class="row">

                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5>Total Productos</h5>
                            <p class="fs-2"><?php echo $total_productos; ?></p>
                        </div>
                    </div>
                </div>


            </div>



        <?php
        }
        ?>

    </div>

    <!-- Include del Toast -->
     
    <?php include './includes/alerta.php'; ?>

    <!-- LLenar el modal -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const botones = document.querySelectorAll(".btn-editar");

            botones.forEach(boton => {

                boton.addEventListener("click", function() {

                    document.getElementById("edit_id").value = this.dataset.id;
                    document.getElementById("edit_nombre").value = this.dataset.nombre;
                    document.getElementById("edit_precio").value = this.dataset.precio;
                    document.getElementById("edit_cantidad").value = this.dataset.cantidad;

                });

            });

        });
    </script>

    <!-- JS BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>