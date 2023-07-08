<?php
include ("conexion.php");
$con = conectar();

$id_cliente = $_POST['id_cliente'];
$equipo = $_POST['equipo'];
$problema = $_POST['problema'];
$refacciones = $_POST['refacciones'];
$fecha = $_POST['fecha'];
$observacion = $_POST['observacion'];
$costo = $_POST['costo'];
$estatus = $_POST['estatus'];

$stmt = $con->prepare("INSERT INTO detalle (equipo, problema, refacciones, fecha, observacion, costo, estatus) VALUES (?, ?, ?, ?, ?, ?, ?) WHERE id_cliente = ?");
$stmt->bind_param('sssssssi', $equipo, $problema, $refacciones, $fecha, $observacion, $costo, $estatus, $id_cliente);
if ($stmt->execute()) {
    $response = array('tipo' => 'success', 'mensaje' => 'Servicio registrado exitosamente');
} else {
    $response = array('tipo' => 'error', 'mensaje' => 'Error al registrar el Servicio');
}

echo json_encode($response);

?>