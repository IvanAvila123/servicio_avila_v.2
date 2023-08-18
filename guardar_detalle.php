<?php
include("conexion.php");
$con = conectar();

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $id_cliente = $_POST['id_cliente'];
    $equipo = $_POST['equipo'];
    $problema = $_POST['problema'];
    $refacciones = $_POST['refacciones'];
    $fecha = $_POST['fecha'];
    $observacion = $_POST['observacion'];
    $costo = $_POST['costo'];
    $estatus_detalle = $_POST['estatus_detalle'];

    // Ruta de la carpeta donde se almacenarán los archivos PDF
    $carpetaPDFs = "pdfs/";

    // Verificar si la carpeta existe, de lo contrario, crearla
    if (!is_dir($carpetaPDFs)) {
        mkdir($carpetaPDFs, 0755, true);
    }

    // Procesar el archivo PDF
    if ($_FILES['archivo_pdf']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $_FILES['archivo_pdf']['name'];
        $archivoTemporal = $_FILES['archivo_pdf']['tmp_name'];

        // Generar un nombre único para el archivo PDF
        $nombreUnico = uniqid() . '_' . $nombreArchivo;

        // Mover el archivo PDF a la carpeta
        $rutaDestino = $carpetaPDFs . $nombreUnico;
        move_uploaded_file($archivoTemporal, $rutaDestino);

        // Guardar el nombre único del archivo PDF en la base de datos
        $pdf = $nombreUnico;

        // Preparar la consulta SQL
        $stmt = $con->prepare("INSERT INTO detalle (equipo, problema, refacciones, fecha, observacion, costo, estatus_detalle, id_cliente, pdf) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssssssss', $equipo, $problema, $refacciones, $fecha, $observacion, $costo, $estatus_detalle, $id_cliente, $pdf);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Consulta exitosa
            $res = array('tipo' => 'success', 'mensaje' => 'Servicio registrado exitosamente');
        } else {
            // Error en la consulta
            $res = array('tipo' => 'error', 'mensaje' => 'Error al registrar el Servicio: ' . $stmt->error);
        }
    } else {
        // Error al subir el archivo PDF
        $res = array('tipo' => 'error', 'mensaje' => 'Error al subir el archivo PDF: ' . $_FILES['archivo_pdf']['error']);
    }
} else {
    // Error en la solicitud del formulario
    $res = array('tipo' => 'error', 'mensaje' => 'Error en la solicitud del formulario');
}

echo json_encode($res, JSON_UNESCAPED_UNICODE);
die();
?>





