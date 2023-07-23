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
    $pdf = $_POST['pdf'];
    $estatus_detalle = $_POST['estatus_detalle'];
    $id_cliente = $_POST['id_cliente'];

    // Realizar la actualización de la información del detalle en la base de datos
    $stmt = $con->prepare("UPDATE detalle SET equipo = ?, problema = ?, refacciones = ?, fecha = ?, observacion = ?, costo = ?, pdf = ?, estatus_detalle = ?, id_cliente = ? WHERE id = ?");
    $stmt->bind_param('ssssssssii', $equipo, $problema, $refacciones, $fecha, $observacion, $costo, $pdf, $estatus_detalle, $id_cliente, $id);
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
?>
