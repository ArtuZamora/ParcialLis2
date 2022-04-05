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

       

        <!-- Page Content -->
        <div class="containter-fluid py-4">
            <div class="row">
                <div class="col-12 px-5">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Crear nuevo producto</h6>
                        </div>
                        <div class="card-body p-5">
                            <form role="form" action="<?= PATH ?>/Products/Add" enctype="multipart/form-data" method="POST">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label for="codigo">Codigo del producto</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="id_product" id="id_product" value="<?= isset($product) ? $product['id_product'] : '' ?>" placeholder="Ingresa el codigo del producto">
                                            </div>
                                            <p class="text-danger"><?= isset($error_log['id_product_error']) ? $error_log['id_product_error'] : '' ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="name_product">Nombre del producto</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="name_product" id="name_product" value="<?= isset($product) ? $product['name_product'] : '' ?>" placeholder="Ingresa el nombre del producto">

                                            </div>
                                            <p class="text-danger"><?= isset($error_log['name_product_error']) ? $error_log['name_product_error'] : '' ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="Description">Descripcion</label>
                                            <div class="input-group col-md-12">
                                                <textarea class="form-control" rows="3" id="description" name="description"><?= isset($product) ? $product['Description_prod'] : '' ?></textarea>
                                            </div>
                                            <p class="text-danger"><?= isset($error_log['description_error']) ? $error_log['description_error'] : '' ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="Stock">Existencias</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="stock" name="stock" value="<?= isset($product) ? $product['Stock'] : '' ?>" placeholder="Ingresa las existencias del producto">

                                            </div>
                                            <p class="text-danger"><?= isset($error_log['stock_error']) ? $error_log['stock_error'] : '' ?></p>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label for="precio">Precio</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= isset($product) ? $product['Price'] : '' ?>" placeholder="Ingresa el precio del producto">

                                            </div>
                                            <p class="text-danger"><?= isset($error_log['price_error']) ? $error_log['price_error'] : '' ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="category">Categoria</label>
                                            <div class="input-group mb-3">
                                                <select id="category_Id" name="category_id" class="form-select">
                                                    <option value="">Seleccione...</option>
                                                    <?php
                                                    foreach ($categories as $category) {
                                                    ?>
                                                        <option value="<?= $category['Id'] ?>"><?= utf8_encode($category['Name']) ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                            <p class="text-danger"><?= isset($error_log['category_id_error']) ? $error_log['category_id_error'] : '' ?></p>
                                        </div>

                                        <div class="form-group  ">
                                            <label for="image">Imagen del producto</label>
                                            <div class="input-group ">
                                                <input class="form-control" id="image" type="file" value="<?= isset($product) ? $product['Image_prod'] : '' ?>" name="image">

                                            </div>
                                            <p class="text-danger"><?= isset($error_log['image_error']) ? $error_log['image_error'] : '' ?></p>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center">
                                                <input type="submit" class="btn btn-info mx-2" value="Guardar" name="Guardar">
                                                <a class="btn btn-danger" href="<?= PATH ?>/Products/Index">Cancelar</a>
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
    <?php 
    if(isset($product)){
        ?>
        <script>
            $('select[name=category_id]').val('<?= $product['category_Id'] ?>');
        </script>
        <?php
    }
    ?>
</body>

</html>