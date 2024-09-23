<?php
// Incluimos el archivo de conexión
include 'conexion.php';

// Verificamos si se ha enviado el formulario correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recibir datos del formulario
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : 'Anónimo';
    $tipo_reporte = $_POST['tipo_reporte'];
    $descripcion = $_POST['descripcion'];
    
    // Verificamos si hay un archivo cargado
    if (isset($_FILES['captura']) && $_FILES['captura']['error'] == 0) {
        $file_name = $_FILES['captura']['name'];
        $file_tmp = $_FILES['captura']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Validar que sea una imagen
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
        
        if (in_array($file_ext, $allowed_ext)) {
            // Asignar un nuevo nombre único a la imagen
            $new_file_name = uniqid() . '.' . $file_ext;
            $upload_dir = 'uploads/'; // Asegúrate de tener esta carpeta
            $upload_path = $upload_dir . $new_file_name;
            
            // Subir la imagen
            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Insertar los datos en la base de datos
                $sql = "INSERT INTO design (nombre, tipo_reporte, descripcion, imagen) VALUES ('$nombre', '$tipo_reporte', '$descripcion', '$new_file_name')";
                
                if ($conn->query($sql) === TRUE) {
                    // Mostrar un mensaje de éxito en verde
                    echo "<div style='background-color: #28a745; color: white; padding: 20px; text-align: center;'>
                            <h2>Reporte enviado con éxito.</h2>
                          </div>";
                    
                    // Botón para volver a enviar otro reporte
                    echo "<div style='text-align: center; margin-top: 20px;'>
                            <a href='index.php' style='padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px;'>Enviar otro reporte</a>
                          </div>";
                } else {
                    echo "<div style='background-color: #dc3545; color: white; padding: 20px; text-align: center;'>
                            <h2>Error al guardar el reporte: " . $conn->error . "</h2>
                          </div>";
                }
            } else {
                echo "<div style='background-color: #dc3545; color: white; padding: 20px; text-align: center;'>
                        <h2>Error al subir la imagen.</h2>
                      </div>";
            }
        } else {
            echo "<div style='background-color: #dc3545; color: white; padding: 20px; text-align: center;'>
                    <h2>Formato de archivo no permitido. Solo se aceptan imágenes.</h2>
                  </div>";
        }
    } else {
        echo "<div style='background-color: #dc3545; color: white; padding: 20px; text-align: center;'>
                <h2>Por favor, adjunta una imagen.</h2>
              </div>";
    }
} else {
    echo "<div style='background-color: #dc3545; color: white; padding: 20px; text-align: center;'>
            <h2>Método de solicitud no válido.</h2>
          </div>";
}

$conn->close();
?>
