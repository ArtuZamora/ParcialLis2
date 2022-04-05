<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compras</title>
    <?php include_once "View/Shared/_HeaderClient.php" ?>
</head>

<body>
    <section class="h-100 h-custom" style="background-color: #136AF8;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12">
                    <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-lg-8">
                                    <div class="p-5">
                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <h1 class="fw-bold mb-0 text-black">Carrito de Compras</h1>
                                            <h6 class="mb-0 text-muted"><?= count($shoppingCart) ?> items</h6>
                                        </div>
                                        <hr class="my-4">

                                        <?php
                                        $totalPrice = 0;
                                        if (count($shoppingCart) > 0) {
                                            foreach ($shoppingCart as $product) {
                                                $totalPrice += $product["Price"] * $product["Quantity"];
                                        ?>
                                                <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                    <div class="col-md-2 col-lg-2 col-xl-2">
                                                        <img src="<?= PATH ?>/wwwroot/assets/client/img/<?= $product["Image"] ?>" class="img-fluid rounded-3">
                                                    </div>
                                                    <div class="col-md-3 col-lg-3 col-xl-3">
                                                        <h6 class="text-muted"><?= $product["Name"] ?></h6>
                                                        <h6 class="text-black mb-0"><?= $product["Description"] ?></h6>
                                                    </div>
                                                    <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                        <button data-id="<?= $product["ProductId"] ?>" class="btn btn-link px-2 editItem" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                            <i class="fas fa-minus"></i>
                                                        </button>

                                                        <input value="<?= $product["Quantity"] ?>" style="width: 4em; padding: 0.5em" min="0" max="<?= $product["Stock"] ?>" id="Q-<?= $product["ProductId"] ?>" name="quantity" value="1" type="number" class="form-control form-control-sm" readonly />

                                                        <button data-id="<?= $product["ProductId"] ?>" class="btn btn-link px-2 editItem" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                                        <h6 class="mb-0">$ <?= number_format((float)($product["Price"] * $product["Quantity"]), $decimals = 2) ?></h6>
                                                    </div>
                                                    <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                        <a data-id="<?= $product["Id"] ?>" href="#" class="text-muted removeItem"><i class="fas fa-times"></i></a>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            Tu carrito está vacío, agrega items a tu carrito
                                        <?php
                                        }
                                        ?>

                                        <hr class="my-4">

                                        <div class="pt-5">
                                            <h6 class="mb-0"><a href="<?= PATH ?>/Client/Index" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i> Regresar a la tienda</a></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 bg-grey">
                                    <div class="p-5">
                                        <h3 class="fw-bold mb-5 mt-2 pt-1">Resumen de orden</h3>
                                        <hr class="my-4">

                                        <div class="d-flex justify-content-between mb-4">
                                            <h5 class="text-uppercase">items - <?= count($shoppingCart) ?></h5>
                                            <h5>$ <?= number_format((float)$totalPrice, $decimals = 2) ?></h5>
                                        </div>


                                        <form method="POST" action="<?= PATH ?>/Sales/SetSale">
                                            <h5 class="text-uppercase mb-3">Envío</h5>

                                            <div class="mb-4 pb-2">
                                                <select name="shipping" class="select form-control" style="font-size: small; height: 100%;">
                                                    <option value="2.50">Envío Regular - $2.50</option>
                                                    <option value="5.00">Envío Express - $5.00</option>
                                                    <option value="7.50">Envío Premium - $7.50</option>
                                                </select>
                                            </div>

                                            <hr class="my-4">

                                            <div class="d-flex justify-content-between mb-2">
                                                <h5 class="text-uppercase">Total de la orden</h5>
                                                <h5 id="totalOrderPrice">$ <?= number_format((float)($totalPrice + 2.50), $decimals = 2) ?></h5>
                                                <input name="total" type="text" class="form-control" value="<?= (float)($totalPrice) ?>" readonly hidden />
                                            </div>

                                            <hr class="my-4">
                                            <div>
                                                <h5 class="text-uppercase">Detalles de pago</h5>
                                                <div class="form-group">
                                                    <input name="cardName" type="text" class="form-control form-control-sm mb-1" placeholder="Titular de tarjeta" required />
                                                    <input name="cardNum" type="text" class="form-control form-control-sm mb-3" placeholder="Número de tarjeta" pattern="^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$" required />
                                                    <h6 class="text-uppercase">Fecha de expiración</h6>
                                                    <div class="row">
                                                        <div class="col-12 d-flex justify-content-between">
                                                            <h6 class="text-uppercase">Mes</h6>
                                                            <h6 class="text-uppercase">Año</h6>
                                                            <h6 class="text-uppercase">CVV</h6>
                                                        </div>
                                                        <div class="col-12 d-flex justify-content-between">
                                                            <select name="cardExpMonth" class="form-control col-4 payment" name="month" style="height: 3em;">
                                                                <option value="1">01</option>
                                                                <option value="2">02</option>
                                                                <option value="3">03</option>
                                                                <option value="4">04</option>
                                                                <option value="5">05</option>
                                                                <option value="6">06</option>
                                                                <option value="7">07</option>
                                                                <option value="8">08</option>
                                                                <option value="9">09</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                            </select>

                                                            <select name="cardExpYear" class="form-control col-4 payment" style="height: 3em;">
                                                            </select>

                                                            <input name="cardCVV" type="text" class="form-control form-control-sm" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\.*)\./g, '$1');" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="my-4">
                                            <?php
                                            if (count($shoppingCart) > 0) {
                                            ?>
                                                <button name="setSale" type="submit" class="btn btn-dark btn-block btn-lg" data-mdb-ripple-color="dark">Efectuar Compra</button>
                                            <?php
                                            }
                                            ?>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
        let baseUrl = '<?= PATH ?>';
        let totalPrice = <?= $totalPrice ?>;
        let date = new Date();
        let year = parseInt(date.getFullYear().toString().substring(2));
        for (let i = year; i < year + 10; i++) {
            $('select[name=cardExpYear]').append('<option value="' + i + '">' + i.toString() + '</option>');
        }

        $('.removeItem').on('click', function() {
            Swal.fire({
                title: 'Estas seguro de querer eliminar este producto?',
                showDenyButton: true,
                confirmButtonText: 'Sí',
                denyButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    let id = $(this).attr('data-id');
                    $.ajax({
                        type: 'POST',
                        url: baseUrl + '/ShoppingCart/RemoveItem/' + id,
                        success: function(response) {
                            location.reload();
                        }
                    });
                }
            })
        });
        $('.editItem').on('click', function() {
            let productId = $(this).attr('data-id');
            let quantity = $('#Q-' + productId).val();
            if (parseInt(quantity) <= parseInt($('#Q-' + productId).attr('max')))
                $.ajax({
                    type: 'POST',
                    url: baseUrl + '/ShoppingCart/EditItem/',
                    data: {
                        'id': userId,
                        'productId': productId,
                        'quantity': quantity
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
        });
        $('select[name=shipping]').on('change', function() {
            let shippingCost = parseFloat($(this).val());
            $('#totalOrderPrice').html('$ ' + numberWithCommas((totalPrice + shippingCost).toFixed(2)));
        });

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
</body>

</html>