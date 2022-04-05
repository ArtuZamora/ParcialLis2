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
                            <h6>Lista de productos</h6>
                            <a href="<?= PATH ?>/Products/Create" class="badge badge-sm bg-primary createOpt">Crear nuevo</a>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="productsTable">
                                    <thead>
                                        <tr>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Codigo</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Descripcion</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Imagen</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Precio</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Existencias</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Categoria</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($products as $product) {
                                            $id_product = $product['Id'];
                                        ?>
                                            <tr>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold px-3"><?= $product["Id"] ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold"><?= $product["Product"] ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold"><?= $product["Descripcion"] ?></span>
                                                </td>
                                                <td>
                                                    <img class="capture-img" src="<?= PATH . '/wwwroot/assets/client/img/' . $product['Image'] ?>"></img>
                                                </td>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold">$ <?= number_format($product["Price"], 2) ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold"><?= $product["Stock"] ?></span>
                                                </td>
                                                <td class="text-sm">
                                                    <span class="badge badge-sm bg-gradient-primary"><?= utf8_encode($product["Categoria"]) ?></span>
                                                </td>
                                                <td class="align-start">
                                                    <a data-toggle="tooltip" title="Detalles" class="btn btn-primary btn-circle" href="javascript:void(0)" onclick="detalles('<?= $product['Id'] ?>')">
                                                        <i class="fa fa-book-open"></i>
                                                    </a>
                                                    <a href="<?= PATH ?>/Products/Edit/<?= $product['Id'] ?>" class="btn btn-warning btn-circle editOpt">
                                                        <i class="fa fa-file-pen"></i>
                                                    </a>
                                                    <span data-href="<?= PATH ?>/Products/Delete/<?= $product['Id'] ?>" style="cursor: pointer;" class="btn btn-danger btn-circle deleteOpt">
                                                        <i class="fa fa-trash"></i>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
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
    <script>
        let baseUrl = "<?= PATH ?>";
        $(document).ready(function() {
            $('#productsTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        });
        $('#productsTable').on('click', 'span.deleteOpt', function() {
            Swal.fire({
                title: '¿Está seguro de querer eliminar este registro?',
                showDenyButton: true,
                confirmButtonText: 'Sí',
                denyButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = $(this).attr('data-href');
                }
            })
        });

        function detalles(id) {
            $.ajax({
                url: baseUrl + "/Products/Details/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(datos) {
                    $('#name_product').text(datos.Product);
                    $('#Description_prod').text(datos.Descripcion);
                    $('#Image_prod').text(datos.Image);
                    $('#Price').text(datos.Price);
                    $('#Stock').text(datos.Stock);
                    $('#category_Id').text(datos.Categoria);
                    $('.titulo-modal').text(datos.Id);
                    $('#modal').modal('show');
                }
            })
        }
    </script>
</body>

</html>