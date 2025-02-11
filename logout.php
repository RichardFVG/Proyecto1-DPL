<?php
    // 1. Inicia o reanuda una sesión 
    // existente
    session_start();

    // 2. Destruye la sesión actual, eliminando 
    // todos los datos de sesión
    session_destroy();

    // 3. Redirige al usuario a 'login.php' 
    // después de cerrar sesión
    header('Location: login.php');
    exit();
?>
