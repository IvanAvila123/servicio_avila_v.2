<?php
include("conexion.php");
$con = conectar();

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$domicilio = $_POST['domicilio'];
$estatus = $_POST['estatus'];

// Validar los datos (puedes agregar tus propias validaciones aquí)

$stmt = $con->prepare("INSERT INTO clientes (nombre, apellido, telefono, domicilio ,estatus) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('sssss', $nombre, $apellido, $telefono, $domicilio, $estatus);
if ($stmt->execute()) {
    $res = array('tipo' => 'success', 'mensaje' => 'Cliente registrado exitosamente');
} else {
    $res = array('tipo' => 'error', 'mensaje' => 'Error al registrar el cliente');
}

// Devolver la respuesta en formato JSON
echo json_encode($res);
?>

