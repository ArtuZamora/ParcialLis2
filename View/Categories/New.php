<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <?php
    include_once 'View/Shared/_Header.php';
    ?>
</head>

<body class="g-sidenav-show bg-gray-100">
    <!-- Sidebar -->
    <?php
    include_once 'View/Shared/_Sidebar.php';
    ?>
    <!-- End Sidebar -->

    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <?php
        include_once 'View/Shared/_Navbar.php';
        ?>
        <!-- End Navbar -->

        <!-- Bootstrap modal -->
        <div class="modal fade" id="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <h3 class="titulo-modal"></h3>
                    </div>
                    <div class="modal-body form">
                        <ul class="list-group">
                            <li class="list-group-item"> <b>Nombre del producto: </b> <span id="name_product"></span></li>
                            <li class="list-group-item"> <b>Descripcion: </b> <span id="Description_prod"></span></li>
                            <li class="list-group-item"> <b>Imagen: </b> <span id="Image_prod"></span></li>
                            <li class="list-group-item"> <b>Precio: </b> $<span id="Price"></span></li>
                            <li class="list-group-item"> <b>Existencias: </b> <span id="Stock"></span></li>
                            <li class="list-group-item"> <b>Categoria: </b> <span id="category_Id"></span></li>

                        </ul>

                    </div>
                    <div class="modal-footer">

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- End Bootstrap modal -->

        <!-- Page Content -->
        <div class="containter-fluid py-4">
            <div class="row">
                <div class="col-12 px-5">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Crear nueva categoría</h6>
                        </div>
                        <div class="card-body p-5">
                            <form role="form" action="<?= PATH ?>/Categories/Add" enctype="multipart/form-data" method="POST">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-5">
                                        <input type="hidden" name="op" value="insertar" />
                                        <div class="well well-sm"><strong><span class="glyphicon glyphicon-asterisk"></span>Campos requeridos</strong></div>
                                        <div class="form-group">
                                            <label for="codigo">Codigo de categoria:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="Id" id="Id" value="<?= isset($category) ? $category['Id'] : '' ?>" placeholder="Ingresa el codigo de la categoria">
                                            </div>
                                            <p class="text-danger"><?= isset($error_log['Id_category_error']) ? $error_log['Id_category_error'] : '' ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="nombre">Nombre de la categoria:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="Name" id="Name" value="<?= isset($category) ? $category['Name'] : '' ?>" placeholder="Ingresa el nombre de la categoria">
                                            </div>
                                            <p class="text-danger"><?= isset($error_log['Name_category_error']) ? $error_log['Name_category_error'] : '' ?></p>
                                        </div>


                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center">
                                                <input type="submit" class="btn btn-info mx-3" value="Guardar" name="Guardar">
                                                <a class="btn btn-danger" href="<?= PATH ?>/Categories/Index">Cancelar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        <!-- End Page Content -->


        <!-- Footer -->
        <?php
        include_once 'View/Shared/_Footer.php';
        ?>
        <!-- End Footer -->
    </main>
    <!-- Footer Scripts -->
    <?php
    include_once 'View/Shared/_FooterScripts.php';
    ?>
    <!-- End Footer Scripts -->
</body>

</html>