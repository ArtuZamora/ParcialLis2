<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Factura</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                <h3>Textil Export</h3>
                            </td>

                            <td>
                                # Factura: <?= str_pad($lastSale[0]["Id"], 8, '0', STR_PAD_LEFT); ?><br />
                                Creada: <?= date('d/m/y h:i:s') ?><br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                Universidad Don Bosco<br />
                                Soyapango<br />
                                San Salvador
                            </td>

                            <td>
                                Textil Export<br />
                                Rafael Zamora<br />
                                Naomi Nicole
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Forma de Pago</td>

                <td colspan="2" style="text-align: center;">N??mero de tarjeta</td>

                <td style="text-align: end;">Titular</td>
            </tr>

            <tr class="details">
                <td>Tarjeta de cr??dito</td>
                <td colspan="2" style="text-align: center;">XXXX XXXX XXXX <?= substr($details["cardNum"], strlen($details["cardNum"]) - 4, 4) ?></td>
                <td style="text-align: end;"><?= $details["cardName"] ?></td>
            </tr>

            <tr class="heading">
                <td>Item</td>
                <td style="text-align: center;">Cantidad</td>
                <td style="text-align: center;">Precio Unitario</td>
                <td style="text-align: end;">Precio</td>
            </tr>

            <?php
            $totalPrice = 0;
            foreach ($shoppingCart as $product) {
                $totalPrice += $product["Price"] * $product["Quantity"];
            ?>
                <tr class="item">
                    <td><?= $product["Name"] ?></td>
                    <td style="text-align: center;"><?= $product["Quantity"] ?></td>
                    <td style="text-align: center;">$ <?= number_format((float)$product["Price"], $decimals = 2) ?></td>
                    <td style="text-align: end;">$ <?= number_format((float)($product["Price"] * $product["Quantity"]), $decimals = 2) ?></td>
                </tr>
            <?php
            }
            ?>

            <tr class="item">
                <td>Env??o</td>
                <td style="text-align: center;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: end;">$ <?= number_format((float)$details["shipping"], $decimals = 2) ?></td>
            </tr>

            <tr class="total">
                <td colspan="3"></td>

                <td>Total: $ <?= number_format((float)($totalPrice + $details["shipping"]), $decimals = 2) ?></td>
            </tr>
        </table>
    </div>
</body>

</html>