<?php
require_once('conexion.php');

$con = conectar();

$sql = "SELECT *  FROM clientes";
$query = mysqli_query($con, $sql);
?>

<?php include_once 'template/header.php'; ?>

<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        Clientes
                    </div>
                </div>
                <ul class="navbar-nav header-right">
                    <li class="nav-item">
                        <div class="input-group search-area">
                            <input type="text" class="form-control" placeholder="Buscar Cliente...">
                            <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
                        </div>
                    </li>

                    <li class="nav-item">
                        <div>
                            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg" id="btnNuevo">Crear Cliente</button>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a href="javascript:void(0);" class="btn btn-primary d-sm-inline-block d-none">Generar Excel<i class="las la-signal ms-3 scale5"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!--**********************************
            Header end ti-comment-alt
        ***********************************-->

<!--**********************************
            Sidebar start
        ***********************************-->
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="dropdown header-profile">
                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                    <img src="images/profile/pic1.jpg" width="20" alt="">
                    <div class="header-info ms-3">
                        <span class="font-w600 ">Hola,<b></b></span>
                        <small class="text-end font-w400"></small>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="page-error-404.html" class="dropdown-item ai-icon">
                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span class="ms-2">Logout </span>
                    </a>
                </div>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-025-dashboard"></i>
                    <span class="nav-text">Clientes</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="index.html">Lista De Clientes</a></li>
                    <li><a href="index-2.html">Ordenes pendientes</a></li>
                    <li><a href="my-wallet.html">Inventario</a></li>
                </ul>
        </ul>
    </div>
</div>
<!--**********************************
            Sidebar end
        ***********************************-->

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless" style="width:100%" id="tblClientes">
                            <thead>
                                <tr>
                                    <th class="text-primary">Nombre</th>
                                    <th class="text-primary">Apellido</th>
                                    <th class="text-primary">Telefono</th>
                                    <th class="text-primary">Direccion</th>
                                    <th class="text-primary">Estatus</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_array($query)) {
                                ?>
                                    <td><?php echo $row['nombre'] ?></td>
                                    <td><?php echo $row['apellido'] ?></td>
                                    <td><?php echo $row['telefono'] ?></td>
                                    <td><?php echo $row['domicilio'] ?></td>
                                    <td>
                                        <?php
                                        $estatus = $row['estatus']; // Obtén el valor del estatus desde tu fuente de datos

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
                                            <i class="fa fa-circle <?php echo $colorClass; ?> me-1"></i> <?php echo $row['estatus'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-primary shadow btn-xs sharp me-1 btnEditar" data-id="<?php echo $row['id']; ?>"><i class="fas fa-pencil-alt"></i></button>
                                            <button href="#" class="btn btn-danger shadow btn-xs me-1 sharp btnEliminar" data-id="<?php echo $row['id']; ?>"><i class="fa fa-trash"></i></button>
                                            <a href="detalle.php?id=<?php echo $row['id']; ?>" class="btn btn-primary shadow btn-xs me-1 sharp" data-id="<?php echo $row['id']; ?>"><i class="fas fa-eye"></i></a>
                                        </div>
                                    </td>
                            </tbody>
                        <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<div id="modalRegistro" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <form id="formulario">
                    <input type="hidden" id="id" name="id">
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
                <button type="submit" class="btn btn-primary">Guardar Cliente</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div id="editarModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
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
                <button type="submit" class="btn btn-primary">Editar Cliente</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once 'template/footer.php';
?>