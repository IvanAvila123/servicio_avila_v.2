<?php
include("conexion.php");
$con = conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del cliente a eliminar
    $id = $_POST['id'];

    // Realizar la eliminación del cliente en la base de datos
    $stmt = $con->prepare("DELETE FROM clientes WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response = array('tipo' => 'success', 'mensaje' => 'Cliente Eliminado exitosamente');
    } else {
        $response = array('tipo' => 'error', 'mensaje' => 'Error al eliminar al cliente');
    }

    // Establecer la cabecera de respuesta como JSON
    header('Content-Type: application/json');

    // Devolver la respuesta en formato JSON
    echo json_encode($response);
}
?>

