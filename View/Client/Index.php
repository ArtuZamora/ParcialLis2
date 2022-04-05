<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>Textil Export</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php include_once 'View/Shared/_HeaderClient.php' ?>
</head>
<!-- body -->
<?php include_once 'Core/display_lists.php' ?>

<body class="main-layout">
    <!-- Modal -->
    <div class="modal fade" id="modalDetails" tabindex="-1" role="dialog" aria-labelledby="modalDetails" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color: white;"><span id="nameTxt"></span><small>#<span id="codeTxt"></span></small></h5>
                </div>
                <form id="shopFrm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <input name="code" type="text" class="form-control" readonly hidden />
                                <p>
                                    <strong style="font-weight: 600;">Descripción:</strong><br>
                                    <span id="descTxt"></span><br>
                                    <strong style="font-weight: 600;">Precio: </strong>$<span id="priceTxt"></span><br>
                                    <strong style="font-weight: 600;">Existencias: </strong><span id="stockTxt"></span>
                                </p><br>
                                <?php
                                if (isset($_SESSION["user"])) {
                                ?>
                                    <input name="Id" type="text" value="<?= $_SESSION["user"]["Id"] ?>" class="form-control" readonly hidden />
                                    <div class="form-group" style="font-size: small; width: 81%; margin-left: 2em;">
                                        <label>Cantidad a comprar</label>
                                        <input id="qtyTxt" name="quantity" type="number" value="1" min="1" class="form-control form-control-sm" style="font-size: small; padding: 1em; height: 3em; width: 11em;" />
                                    </div>
                                <?php
                                } ?>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <div>
                                    <img id="img" style="size: 50%;">
                                    <h3 style="text-align: center;"><label id="typeTxt" class="badge badge-secondary"></label></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="display: block !important;">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <?php
                                if (!isset($_SESSION["user"])) {
                                ?>
                                    <a href="<?= PATH ?>/Home/Login" class="btn btn-success mr-2">Iniciar Sesión para comprar</a>
                                <?php
                                } else {
                                ?>
                                    <button type="submit" class="btn btn-light">Agregar al carrito</button>
                                <?php
                                }
                                ?>
                                <button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal -->
    <!-- loader  
    <div class="loader_bg">
        <div class="loader"><img src="<?= PATH ?>/wwwroot/assets/client/img/loading.gif" alt="#" /></div>
    </div>
    end loader -->
    <!-- header -->
    <header class="section">
        <!-- header inner -->
        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        <?php
                        if (!isset($_SESSION["user"])) {
                        ?>
                            <a href="<?= PATH ?>/Home/Login" style="font-size: medium; color: white;">Iniciar Sesión</a>
                        <?php
                        } else {
                        ?>

                            <a href="<?= PATH ?>/ShoppingCart/Index" style="font-size: medium; color: white;">Carrito de compras</a>
                            <a class="ml-5" href="<?= PATH ?>/Home/Logout" style="font-size: medium; color: white;">Cerrar Sesión</a>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                        <div class="full">
                            <div class="center-desk">
                                <div class="logo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end header inner -->
    </header>
    <!-- end header -->
    <section>
        <div id="main_slider" class="section carousel slide banner-main" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#main_slider" data-slide-to="0" class="active"></li>
                <li data-target="#main_slider" data-slide-to="1"></li>
                <li data-target="#main_slider" data-slide-to="2"></li>
                <li data-target="#main_slider" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <div class="row marginii">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="carousel-caption">
                                    <h1>Bienvenido a Textil<strong class="color">Export</strong></h1>
                                    <p>Acá encontraras todos los productos que necesitas</p>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="img-box">
                                    <figure><img src="<?= PATH ?>/wwwroot/assets/client/img/some.png" alt="img" /></figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                foreach ($numbers as $key => $value) {
                ?>
                    <div class="carousel-item">
                        <div class="container">
                            <div class="row marginii">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="carousel-caption">
                                        <h1><?= $products[$value]["Product"] ?></h1>
                                        <p><?= $products[$value]["Descripcion"] ?></p>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="img-box">
                                        <figure><img class="round-image-bg" src="<?= PATH ?>/wwwroot/assets/client/img/<?= $products[$value]["Image"] ?>" alt="img" /></figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
                <i class='fa fa-angle-left'></i></a>
            <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
                <i class='fa fa-angle-right'></i>
            </a>
        </div>
    </section>
    <!-- plant -->
    <div id="plant" class="section  product">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2><strong class="black">Nuestros</strong> Productos</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clothes_main section">
        <div class="container">
            <div class="row">
                <?php
                foreach ($products as $product) {
                ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                        <div class="sport_product product" style="border-radius: 3%;" data-id="<?= $product["Id"] ?>">
                            <figure><img src="<?= PATH ?>/wwwroot/assets/client/img/<?= $product["Image"] ?>" alt="img" /></figure>
                            <h3>$<strong class="price_text"><?= number_format((float)$product["Price"], $decimals = 2) ?></strong></h3>
                            <h4><?= $product["Product"] ?></h4>
                            <?= (int)$product["Stock"] == 0 ? '<h5 class="text-danger">Producto no disponible</h5>' : '' ?>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    </div>
    <!-- end plant -->
    <!--about -->
    <div class="section about">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="titlepage">
                        <h2><strong class="black">Los +</strong> Baratos</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <section>
        <div id="main_slider" class="section carousel slide banner-main" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#main_slider" data-slide-to="0" class="active"></li>
                <li data-target="#main_slider" data-slide-to="1"></li>
                <li data-target="#main_slider" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <?php
                for ($i = 0; $i < 2; $i++) {
                ?>
                    <div class="carousel-item <?= $i == 0 ? "active" : "" ?>">
                        <div class="container">
                            <div class="row marginii">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="carousel-sporrt_text">
                                        <h1 class="sporrt_text"><?= $filtered[$i]["Product"] ?></h1>
                                        <p class="lorem_text"><?= $filtered[$i]["Descripcion"] ?></p>
                                        <h3>$<strong><?= number_format((float)$filtered[$i]["Price"], $decimals = 2) ?></strong></h3>
                                        <div class="btn_main">
                                            <span data-id="<?= $filtered[$i]["Id"] ?>" class="btn btn-lg btn-primary productBtn" role="button">Detalles</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="img-box">
                                        <figure><img src="<?= PATH ?>/wwwroot/assets/client/img/<?= $filtered[$i]["Image"] ?>" style="max-width: 70%; border: 15px solid #fff;" /></figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
    </section>
    </div>
    <!-- end about -->
    <!--Our  Clients -->
    <div id="plant" class="section_Clients layout_padding padding_bottom_0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Nosotros</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section Clients_2 layout_padding padding-top_0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">

                    <div id="testimonial" class="carousel slide" data-ride="carousel">

                        <!-- Indicators -->
                        <ul class="carousel-indicators">
                            <li data-target="#testimonial" data-slide-to="0" class="active"></li>
                            <li data-target="#testimonial" data-slide-to="1"></li>
                        </ul>

                        <!-- The slideshow -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="titlepage">
                                    <div class="john">
                                        <div class="john_image"><img class="round-image" src="<?= PATH ?>/wwwroot/assets/client/img/nao.png"></div>
                                        <div class="john_text">Naomi Iglesias<span style="color: #fffcf4;">(Back-End Developer)</span></div>
                                        <p class="lorem_ipsum_text">Deja que tu sonrisa cambie el mundo, pero no dejes que el mundo cambie tu sonrisa</p>
                                        <div class="icon_image"><img src="<?= PATH ?>/wwwroot/assets/client/img/icon-1.png"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="titlepage">
                                    <div class="john">
                                        <div class="john_image"><img class="round-image" src="<?= PATH ?>/wwwroot/assets/client/img/artu.png"></div>
                                        <div class="john_text">Arturo Zamora<span style="color: #fffcf4;">(Front-End Developer)</span></div>
                                        <p class="lorem_ipsum_text">Si hicieramos todo lo que somos capaces de hacer, nos quedaríamos completamente sorprendidos de nostros mismos</p>
                                        <div class="icon_image"><img src="<?= PATH ?>/wwwroot/assets/client/img/icon-1.png"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Left and right controls -->
                        <a class="carousel-control-prev" href="#testimonial" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#testimonial" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <!-- end Our  Clients -->

    </div>

    <!-- end Contact Us-->
    <!-- footer start-->
    <div id="plant" class="footer layout_padding">
        <div class="container">
            <p>© 2019 All Rights Reserved. Design by<a href="https://html.design/">Free Html Templates</a></p>
        </div>
    </div>

    <!-- Javascript files-->
    <script src="<?= PATH ?>/wwwroot/assets/client/js/jquery.min.js"></script>
    <script src="<?= PATH ?>/wwwroot/assets/client/js/popper.min.js"></script>
    <script src="<?= PATH ?>/wwwroot/assets/client/js/bootstrap.bundle.min.js"></script>
    <script src="<?= PATH ?>/wwwroot/assets/client/js/jquery-3.0.0.min.js"></script>
    <script src="<?= PATH ?>/wwwroot/assets/client/js/plugin.js"></script>
    <!-- sidebar -->
    <script src="<?= PATH ?>/wwwroot/assets/client/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?= PATH ?>/wwwroot/assets/client/js/custom.js"></script>
    <!-- javascript -->
    <script src="<?= PATH ?>/wwwroot/assets/client/js/owl.carousel.js"></script>
    <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <?php
    if (isset($_SESSION["user"])) {
    ?>
        <script>
            let userId = '<?= $_SESSION["user"]["Id"] ?>';
        </script>
    <?php
    }
    ?>
    <script>
        let products = [];
        let baseUrl = '<?= PATH ?>';
        $(document).ready(function() {
            $(" .fancybox").fancybox({
                openEffect: " none",
                closeEffect: " none"
            });

            $(" .zoom").hover(function() {

                $(this).addClass('transition');
            }, function() {

                $(this).removeClass('transition');
            });
            $(".product, .productBtn").on('click', function() {
                let id = $(this).attr('data-id');
                product = products.find(p => p.codigo == id);
                if (product.existencias == 0) {
                    Swal.fire('Producto sin existencias', '', 'error');
                    return;
                }
                $('#shopFrm input[name=code]').val(product.codigo);
                $('#shopFrm input[name=quantity]').val(1);
                $('#codeTxt').text(product.codigo);
                $('#nameTxt').text(product.nombre);
                $('#descTxt').text(product.descripcion);
                $('#img').attr('src', '<?= PATH ?>/wwwroot/assets/client/img/' + product.img);
                $('#typeTxt').text(product.categoria);
                $('#priceTxt').text(product.precio.toFixed(2));
                $('#stockTxt').text(product.existencias.toString());
                $('#qtyTxt').attr('max', product.existencias);
                $('#modalDetails').modal('show')
            });
            $('#qtyTxt').on('input', function() {
                if (parseInt($(this).val()) > parseInt($(this).attr('max')))
                    $(this).val($(this).attr('max'));
                if (parseInt($(this).val()) < 1)
                    $(this).val(1);
                if ($(this).val() == '')
                    $(this).val(1);
            });
            $('#shopFrm').on('submit', function(e) {
                e.preventDefault();
                var productId = $('#shopFrm input[name=code]').val();
                var quantity = $('#shopFrm input[name=quantity]').val();
                $.ajax({
                    type: 'POST',
                    url: baseUrl + '/ShoppingCart/AddItem',
                    data: {
                        'id': userId,
                        'productId': productId,
                        'quantity': quantity
                    },
                    success: function(response) {
                        $('#modalDetails').modal('hide');
                        if (response) {
                            Swal.fire(
                                'Producto añadido',
                                'Producto añadido exitosamente al carrito de compras',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Error',
                                'Ha habido un problema, intenta mas tarde',
                                'error'
                            );
                        }
                    }
                });
            });
        });

        function product(codigo, nombre, descripcion, img, categoria, precio, existencias) {
            return {
                codigo: codigo,
                nombre: nombre,
                descripcion: descripcion,
                img: img,
                categoria: categoria,
                precio: precio,
                existencias: existencias
            };
        }
    </script>
    <?php
    foreach ($products as $product) {
    ?>
        <script>
            products.push(new product(
                "<?= $product["Id"] ?>",
                "<?= $product["Product"] ?>",
                "<?= $product["Descripcion"] ?>",
                "<?= $product["Image"] ?>",
                "<?= utf8_encode($product["Categoria"]) ?>",
                <?= number_format((float)$product["Price"], $decimals = 2) ?>,
                <?= $product["Stock"] ?>
            ));
        </script>
    <?php
    }
    ?>
</body>

</html>