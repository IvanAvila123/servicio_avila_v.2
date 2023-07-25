<?php
include("conexion.php");
$con = conectar();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener los datos del detalle a editar
    $id = $_GET['id']; 

    // Obtener los datos del detalle de la base de datos
    $stmt = $con->prepare("SELECT * FROM detalle WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $detalle = $result->fetch_assoc();
        echo json_encode($detalle);
    } else {
        $response = array('error' => 'Detalle no encontrado');
        echo json_encode($response);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del detalle del cuerpo de la solicitud POST
    $id = $_POST['id'];
    $equipo = $_POST['equipo'];
    $problema = $_POST['problema'];
    $refacciones = $_POST['refacciones'];
    $fecha = $_POST['fecha'];
    $observacion = $_POST['observacion'];
    $costo = $_POST['costo'];
    $estatus_detalle = $_POST['estatus_detalle'];
    $id_cliente = $_POST['id_cliente'];

    // Manejar el archivo PDF (si se cargó uno)
    $pdf_path = ''; // Variable para almacenar la ruta del archivo PDF en el servidor

    if ($_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        // Obtener información del archivo PDF cargado
        $pdf_temp = $_FILES['pdf']['tmp_name'];
        $pdf_name = $_FILES['pdf']['name'];

        // Ruta donde deseas guardar los archivos PDF en el servidor
        $upload_dir = 'pdfs/' . $id . '/'; // Utiliza el ID del detalle como parte de la ruta

        // Verificar si la carpeta para el detalle existe, si no, crearla
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true); // El tercer parámetro "true" crea carpetas recursivamente
        }

        // Genera un nombre único para el archivo PDF
        $pdf_path = $upload_dir . uniqid() . '_' . $pdf_name;

        // Mueve el archivo a la ubicación permanente en el servidor
        move_uploaded_file($pdf_temp, $pdf_path);
    }

    // Realizar la actualización de la información del detalle en la base de datos
    $stmt = $con->prepare("UPDATE detalle SET equipo = ?, problema = ?, refacciones = ?, fecha = ?, observacion = ?, costo = ?, pdf = ?, estatus_detalle = ?, id_cliente = ? WHERE id = ?");
    $stmt->bind_param('ssssssssii', $equipo, $problema, $refacciones, $fecha, $observacion, $costo, $pdf_path, $estatus_detalle, $id, $id_cliente);
    $stmt->execute();


    if ($stmt->affected_rows > 0) {
        $response = array('success' => 'Expediente editado exitosamente');
    } else {
        $response = array('error' => 'Error al editar el Expediente');
    }

    // Establecer la cabecera de respuesta como JSON
    header('Content-Type: application/json');

    // Devolver la respuesta en formato JSON
    echo json_encode($response);
}
