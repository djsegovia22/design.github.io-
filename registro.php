<?php
// Incluimos el archivo de conexión a la base de datos
include 'conexion.php';

// Inicializamos una variable para almacenar mensajes de éxito o error
$mensaje = "";

// Verificamos si el formulario fue enviado mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Capturamos los datos enviados desde el formulario
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : 'Anónimo';
    $tipo_reporte = $_POST['tipo_reporte'];
    $descripcion = $_POST['descripcion'];
    
    // Verificamos si se cargó un archivo (imagen)
    if (isset($_FILES['captura']) && $_FILES['captura']['error'] == 0) {
        $file_name = $_FILES['captura']['name'];
        $file_tmp = $_FILES['captura']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Validamos que sea un archivo de imagen permitido
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
        
        if (in_array($file_ext, $allowed_ext)) {
            // Asignamos un nombre único a la imagen
            $new_file_name = uniqid() . '.' . $file_ext;
            $upload_dir = 'uploads/';
            $upload_path = $upload_dir . $new_file_name;
            
            // Movemos la imagen subida a la carpeta de destino
            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Insertamos los datos en la base de datos
                $sql = "INSERT INTO design (nombre, tipo_reporte, descripcion, imagen) 
                        VALUES ('$nombre', '$tipo_reporte', '$descripcion', '$new_file_name')";
                
                if ($conn->query($sql) === TRUE) {
                    // Mensaje de éxito
                    $mensaje = "<div style='color: #28a745; text-align: center;'>Reporte enviado con éxito.</div>";
                } else {
                    // Error al guardar en la base de datos
                    $mensaje = "<div style='color: #dc3545; text-align: center;'>Error al guardar el reporte: " . $conn->error . "</div>";
                }
            } else {
                // Error al mover el archivo
                $mensaje = "<div style='color: #dc3545; text-align: center;'>Error al subir la imagen.</div>";
            }
        } else {
            // Archivo no permitido
            $mensaje = "<div style='color: #dc3545; text-align: center;'>Formato de archivo no permitido. Solo se aceptan imágenes.</div>";
        }
    } else {
        // No se subió ningún archivo
        $mensaje = "<div style='color: #dc3545; text-align: center;'>Por favor, adjunta una imagen.</div>";
    }
} else {
    // Método de solicitud no válido
    $mensaje = "<div style='color: #dc3545; text-align: center;'>Método de solicitud no válido.</div>";
}

// Cerramos la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Enviado</title>
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <?php echo $mensaje; ?>
        <br><br>
        <a href="index.php" style="color: #28a745; text-decoration: none; font-size: 18px;">Volver a enviar otro reporte</a>
    </div>
</body>
</html>
