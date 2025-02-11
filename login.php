<?php
// 1. Inicia o reanuda una sesión existente
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 2. Sanitiza las entradas del formulario 
    // para prevenir inyecciones
    $nombre_usuario = 
    trim(htmlspecialchars(
        $_POST['nombre_usuario']
    ));
    $contrasena = 
    trim(htmlspecialchars(
        $_POST['contrasena']
    ));

    // 3. Verifica que los campos no estén 
    // vacíos
    if (!empty($nombre_usuario) && !empty($contrasena)) {
        // 4. Comprueba si el usuario es 'admin' 
        // con contraseña '1234'
        if (
            $nombre_usuario === 'admin' && 
            $contrasena === '1234'
        ) {
            // 5. Establece variables de sesión 
            // para el administrador
            $_SESSION['usuario'] = 'admin';
            $_SESSION['nombre_usuario'] = 'admin';
        } 
        
        else {
            // 6. Establece variables de sesión para 
            // un usuario normal
            $_SESSION['usuario'] = 'normal';
            $_SESSION['nombre_usuario'] = $nombre_usuario;
        }

        // 7. Redirige al usuario a 'index.php' 
        // después del inicio de sesión exitoso
        header('Location: index.php');
        exit();
    } 
    
    else {
        // 8. Si los campos están vacíos, asigna 
        // un mensaje de error
        $error = "Por favor, completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <!-- 9. Establece el título de la página -->
    <title>Inicio de Sesión</title>
    <!-- 10. Agrega el favicon -->
    <link rel="icon" type="image/png" 
    href="img/RFVG.png">
    <!-- 11. Hace que el sitio sea responsive -->
    <meta name="viewport" 
    content="width=device-width, initial-scale=1.0">
    <!-- 12. Incluye la hoja de estilo por 
     defecto -->
    <link rel="stylesheet" href="css/claro.css">
</head>
<body class="login-body">
    <!-- Título y nombre del autor fuera del 
     contenedor con borde -->
    <div class="header">
        <h1 class="megmercado-title">MegaMercado</h1>
    </div>
    <div class="container login-container">
        <h1>Iniciar Sesión</h1>
        <?php 
            if (isset($error)) { 
                echo "<p class='error'>$error</p>"; 
            } 
        ?>
        <form method="post" action="">
            <!-- 13. Campo para el nombre de 
             usuario -->
            <label for="nombre_usuario">
                Nombre de Usuario:
            </label>
            <input type="text" name="nombre_usuario" 
            id="nombre_usuario" required>
            <!-- 14. Campo para la contraseña -->
            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" 
            id="contrasena" required>
            <!-- 15. Botón para enviar el 
             formulario -->
            <input type="submit" value="Iniciar Sesión">
        </form>
    </div>
    <!-- Texto del autor fuera del contenedor con 
     borde -->
    <div class="footer">
        <!-- 16. Muestra el nombre del autor y 
         curso -->
        <p class="autor">
            Richard Francisco Vaca Garcia, 2do CFGS DAW
        </p>
    </div>
</body>
</html>
