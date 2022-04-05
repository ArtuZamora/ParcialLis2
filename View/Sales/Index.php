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
                            <h6>Lista de ventas</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="salesTable">
                                    <thead>
                                        <tr>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Codigo</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Código Cliente</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Cliente</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Factura</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($sales as $sale) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold px-3"><?= str_pad($sale["Id"], 8, "0", STR_PAD_LEFT) ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold">$ <?= number_format((float)$sale["Total"], 2) ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold"><?= ($sale["CreatedDate"]) ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold"><?= ($sale["UserId"]) ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold"><?= ($sale["UserName"]) ?></span>
                                                </td>
                                                <td>
                                                    <a class="btn btn-success" href="<?= PATH ?>/wwwroot/assets/client/sales/<?= $sale["PDF"] ?>" target="_blank">Mostrar</a>
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
            $('#salesTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        });
    </script>
</body>

</html>