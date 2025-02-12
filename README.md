# RFVG - Proyecto 1 

## (https://github.com/RichardFVG/Proyecto1-DPL.git) 

## Descripción del proyecto
He desarrollado un pequeño proyecto de tienda en línea llamado **MegaMercado**, donde se pueden registrar usuarios (incluso con roles de administrador), cambiar entre diferentes idiomas (español e inglés) y alternar entre estilos claro y oscuro. Además, permite agregar productos a un carrito de compras, eliminar productos, vaciarlo y visualizar detalles como la cantidad total de artículos y el precio acumulado.

## Tecnologías utilizadas
- **PHP** (para la lógica del servidor y el manejo de sesiones).
- **HTML5** y **CSS3** (para la estructura y el estilo de las páginas).
- **JavaScript** (no se ha usado en gran medida, pero podría incorporarse para funcionalidades adicionales).
- **XAMPP** (Apache + MySQL) para facilitar el entorno de desarrollo local.

## Instrucciones de instalación y ejecución
1. **Instalar XAMPP (opcional si se requiere una base de datos)**  
   - Descargo e instalo [XAMPP](https://www.apachefriends.org/).  
   - Inicio los módulos de **Apache** (para PHP) y, si fuera necesario, **MySQL** (para la base de datos).

2. **Configurar base de datos (si aplica)**  
   - Si el proyecto necesitara una base de datos y un archivo `.sql` para importar (en este caso concreto no hay un archivo SQL, pero si en el futuro se necesitara):  
     1. Abro phpMyAdmin (desde XAMPP).  
     2. Creo una nueva base de datos.  
     3. Importo el archivo `.sql` correspondiente.  
   - En este proyecto específico, no se está utilizando MySQL para almacenar datos, pero XAMPP se emplea principalmente para probar la ejecución de los archivos PHP en un servidor local.

3. **Clonar o descargar el repositorio**  
   - Una vez que tengo el repositorio, lo ubico en la carpeta `htdocs` (dentro de la carpeta donde instalé XAMPP, por ejemplo: `C:\xampp\htdocs` en Windows).  
   - La ruta quedaría algo así: `C:\xampp\htdocs\PROYECTO1-DPL\...`

4. **Ejecutar el proyecto en el navegador**  
   - Abro el navegador y escribo la ruta local, por ejemplo:  
     ```
     http://localhost:3000/login.php
     ```  
   - Así podré visualizar la página de inicio de sesión y, posteriormente, el funcionamiento de toda la aplicación.

5. **Visual Studio Code con la extensión PHP Server**  
   - Otra forma de probar el proyecto es abrir la carpeta del repositorio en Visual Studio Code y usar la extensión **PHP Server**.  
   - Tras instalar la extensión, hago clic derecho sobre el archivo `index.php` y selecciono **"Open PHP/HTML/JS in Browser"** (o la opción equivalente que proporcione la extensión).  
   - El proyecto se abrirá en el navegador a través del servidor integrado de PHP que lanza la extensión.

## Capturas de pantalla de la prueba de ejecución
*(Espacio reservado para insertar imágenes en el futuro)*