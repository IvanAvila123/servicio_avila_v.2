<?php
include("conexion.php");
$con = conectar();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener los datos del cliente a editar
    $id = $_GET['id'];

    // Obtener los datos del cliente de la base de datos
    $stmt = $con->prepare("SELECT * FROM clientes WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cliente = $result->fetch_assoc();
        echo json_encode($cliente);
    } else {
        $response = array('error' => 'Cliente no encontrado');
        echo json_encode($response);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del cliente del cuerpo de la solicitud POST
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $domicilio = $_POST['domicilio'];
    $estatus = $_POST['estatus'];

    // Realizar la actualización de la información del cliente en la base de datos
    $stmt = $con->prepare("UPDATE clientes SET nombre = ?, apellido = ?, telefono = ?, domicilio = ?, estatus = ? WHERE id = ?");
    $stmt->bind_param('sssssi', $nombre, $apellido, $telefono, $domicilio, $estatus, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response = array('success' => 'Cliente editado exitosamente');
    } else {
        $response = array('error' => 'Error al editar el cliente');
    }

    // Establecer la cabecera de respuesta como JSON
    header('Content-Type: application/json');

    // Devolver la respuesta en formato JSON
    echo json_encode($response);
}

?>




