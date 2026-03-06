<?php
// Inicia la sesión
session_start();

// Elimina todas las variables de sesión
session_unset();

// Destruye la sesión completamente
session_destroy();

// Redirige al login (o index.php si allí está tu formulario de login)
header("Location: index.php");
exit;