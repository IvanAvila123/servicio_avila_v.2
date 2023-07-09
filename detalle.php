<?php
require_once('conexion.php');

$con = conectar();

if (isset($_GET['id'])) {
    $id_cliente = $_GET['id'];

    $sql = "SELECT clientes.id, detalle.id_cliente, clientes.nombre, clientes.apellido, detalle.equipo, detalle.problema, detalle.refacciones, detalle.fecha, detalle.observacion, detalle.costo, detalle.estatus 
            FROM clientes
            INNER JOIN detalle ON clientes.id = detalle.id_cliente
            WHERE clientes.id = '$id_cliente'";
    $query = mysqli_query($con, $sql);

    if (mysqli_num_rows($query) > 0) {
        // Resto del código para mostrar los detalles del cliente y otros datos de la tabla detalle
        $row = mysqli_fetch_array($query);
        // Acceder a los campos del cliente
        $id = $row['id'];
        $nombre = $row['nombre'];
        $apellido = $row['apellido'];

        // Acceder a los campos de la tabla detalle
        $id_cliente = $row['id_cliente'];
        $equipo = $row['equipo'];
        $problema = $row['problema'];
        $refacciones = $row['refacciones'];
        $fecha = $row['fecha'];
        $observacion = $row['observacion'];
        $costo = $row['costo'];
        $estatus = $row['estatus'];
    } else {
        echo "Cliente no encontrado";
    }
} else {
    echo "ID de cliente no proporcionado";
}
?>


<?php
include 'template/header.php';
?>

<head>
    <title>Expediente De Servicios</title>
</head>
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        Servicios
                    </div>
                </div>
                <ul class="navbar-nav header-right">
                    <li class="nav-item">
                        <div class="input-group search-area">
                            <input type="text" class="form-control" placeholder="Buscar Expediente...">
                            <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
                        </div>
                    </li>

                    <li class="nav-item">
                        <div>
                            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg" id="btnServicio">Crear Servicio</button>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a href="javascript:void(0);" class="btn btn-primary d-sm-inline-block d-none">Generar Orden<i class="las la-signal ms-3 scale5"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<div class="content-body">
        <div class="card-body">
            <h3 class="text-primary m-3"><?php echo $nombre . ' ' . $apellido; ?></h3>
        </div>
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless" style="width:100%" id="tblServicio ">
                                <thead>
                                    <tr>
                                        <th><strong>Equipo</strong></th>
                                        <th><strong>Problema</strong></th>
                                        <th><strong>Refacciones</strong></th>
                                        <th><strong>Fecha</strong></th>
                                        <th><strong>Observacion</strong></th>
                                        <th><strong>Costo</strong></th>
                                        <th><strong>Status</strong></th>
                                        <th><strong></strong></th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="d-flex align-items-center"><strong><?php echo $equipo ?></strong></td>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="w-space-no"><?php echo $problema ?></span></div>
                                        </td>
                                        <td><?php echo $refacciones ?></td>
                                        <td><?php echo $fecha ?></td>
                                        <td><?php echo $observacion ?></td>
                                        <td>$<?php echo $costo ?></td>
                                        <td>
                                            <?php
                                            $estatus = $estatus; // Obtén el valor del estatus desde tu fuente de datos

                                            // Determina la clase de Bootstrap según el estatus
                                            if ($estatus == 'completado') {
                                                $colorClass = 'text-success'; // Verde
                                            } elseif ($estatus == 'pendiente') {
                                                $colorClass = 'text-warning'; // Naranja
                                            } elseif ($estatus == 'cancelado') {
                                                $colorClass = 'text-danger'; // Rojo
                                            } else {
                                                $colorClass = ''; // Clase por defecto xsi no se cumple ninguna condición
                                            }
                                            ?>
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-circle <?php echo $colorClass; ?> me-1"></i> <?php $estatus ?>
                                            </div>

                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <button class="btn btn-primary shadow btn-xs sharp me-1 btnEditarServicio" data-id="<?php echo $id_cliente; ?>"><i class="fas fa-pencil-alt"></i></button>
                                                <button href="#" class="btn btn-danger shadow btn-xs me-1 sharp btnEliminarServicio" data-id="<?php echo $id_cliente; ?>"><i class="fa fa-trash"></i></button>
                                                <button href="#" class="btn btn-primary shadow btn-xs me-1 sharp btnEliminarServicio" data-id="<?php echo $id_cliente; ?>"><i class="fas fa-file-pdf"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="modalRegistroServicio" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="title"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <?php

                                    if (isset($_GET['id'])) {
                                        $id_cliente = $_GET['id'];

                                        $sql = "SELECT * FROM detalle WHERE id_cliente = '$id_cliente'";
                                        $query = mysqli_query($con, $sql);

                                        if ($row = mysqli_fetch_array($query)) {
                                    ?>
                                            <form id="formulario_detalle">
                                                <input type="hidden" id="id_cliente" name="id_cliente" value="<?php echo $row['id']; ?>">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="equipo">Equipo</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="material-icons">build</i></span>
                                                            <input class="form-control" type="text" id="equipo" name="equipo" placeholder="Equipo" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="problema">Problema</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="material-icons">report_problem</i></span>
                                                            <input class="form-control" type="text" id="problema" name="problema" placeholder="Problema" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="refacciones">Refacciones</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="material-icons">engineering</i></span>
                                                            <input class="form-control" type="text" id="refacciones" name="refacciones" placeholder="Refacciones" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label for="fecha">Fecha</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="material-icons">calendar_month</i></span>
                                                            <input class="form-control" type="date" id="fecha" name="fecha" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="observacion">Observación</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="material-icons">error_outline</i></span>
                                                            <input class="form-control" type="text" id="observacion" name="observacion" placeholder="Observación" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="costo">Costo</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="material-icons">paid</i></span>
                                                            <input class="form-control" type="text" id="costo" name="costo" placeholder="Costo" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label for="estatus">Estatus</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="material-icons">location_on</i></span>
                                                            <select class="form-control" id="estatus" name="estatus" required>
                                                                <?php
                                                                $enumOptions = ['completado', 'pendiente', 'cancelado']; // Reemplaza con las opciones de tu ENUM

                                                                foreach ($enumOptions as $option) {
                                                                    echo "<option value='" . $option . "'>" . $option . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary">Guardar Servicio</button>
                                                </div>
                                            </form>
                                    <?php
                                        } else {
                                            echo "Cliente no encontrado";
                                        }
                                    } else {
                                        echo "ID de cliente no proporcionado";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div id="editarModalServicio" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="title"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="formularioEditar">
                                        <input type="hidden" id="id_cliente_editar" name="id">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="nombre">Nombre</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="material-icons">format_list_bulleted</i></span>
                                                    <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="apellido">Apellido</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="material-icons">format_list_bulleted</i></span>
                                                    <input class="form-control" type="text" id="apellido" name="apellido" placeholder="Apellido" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="telefono">Telefono</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="material-icons">phone</i></span>
                                                    <input class="form-control" type="number" id="telefono" name="telefono" placeholder="Telefono" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="domicilio">Domicilio</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="material-icons">location_on</i></span>
                                                    <input class="form-control" type="text" id="domicilio" name="domicilio" placeholder="Direccion" required>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="estatus">Estatus</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="material-icons">location_on</i></span>
                                                    <select class="form-control" id="estatus" name="estatus" required>
                                                        <?php
                                                        $enumOptions = ['completado', 'pendiente', 'cancelado']; // Reemplaza con las opciones de tu ENUM

                                                        foreach ($enumOptions as $option) {
                                                            echo "<option value='" . $option . "'>" . $option . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>




                    <?php
                    include 'template/footer.php';
                    ?>