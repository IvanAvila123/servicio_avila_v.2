<?php
include("conexion.php");
$con = conectar();

$equipo = $_POST['equipo'];
$problema = $_POST['problema'];
$refacciones = $_POST['refacciones'];
$fecha = $_POST['fecha'];
$observacion = $_POST['observacion'];
$costo = $_POST['costo'];
$estatus = $_POST['estatus'];
$id_cliente = $_POST['id_cliente'];

var_dump($_POST);

$stmt = $con->prepare("INSERT INTO detalle (equipo, problema, refacciones, fecha, observacion, costo, estatus, id_cliente) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('ssssssii', $equipo, $problema, $refacciones, $fecha, $observacion, $costo, $estatus, $id_cliente);

if ($stmt->execute()) {
    $response = array('tipo' => 'success', 'mensaje' => 'Servicio registrado exitosamente');
} else {
    $response = array('tipo' => 'error', 'mensaje' => 'Error al registrar el Servicio');
}

echo json_encode($response);
?>

