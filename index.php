<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte</title>
    <style>
        /* Estilos CSS del formulario */
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(255, 255, 255, 0.2);
            width: 100%;
            max-width: 500px;
            position: relative;
            overflow: hidden;
            background-image: url('logo_design.jpg');
            background-position: center;
            background-size: 50%;
            background-repeat: no-repeat;
        }
        h2 {
            text-align: center;
            color: #F1C40F; /* Amarillo del logo */
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white;
            color: black;
        }
        input[type="submit"] {
            background-color: #F1C40F;
            color: black;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #E0B307;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Reporte</h2>
        <form action="registro.php" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre (opcional):</label>
            <input type="text" id="nombre" name="nombre" placeholder="Tu nombre">

            <label for="tipo_reporte">Tipo de reporte:</label>
            <select id="tipo_reporte" name="tipo_reporte" required>
                <option value="">Selecciona una opción</option>
                <option value="comentario">Comentario</option>
                <option value="foto">Foto</option>
                <option value="otro">Otro</option>
            </select>

            <label for="descripcion">Descripción del problema:</label>
            <textarea id="descripcion" name="descripcion" rows="4" placeholder="Describe el problema" required></textarea>

            <label for="captura">Tomar Foto:</label>
            <input type="file" accept="image/*" capture="user" id="captura" name="captura">

            <input type="submit" value="Enviar reporte">
        </form>
    </div>
</body>
</html>

