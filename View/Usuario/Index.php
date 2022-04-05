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
                            <h6>Lista de usuarios</h6>
                            <a href="<?= PATH ?>/Usuario/Create" class="badge badge-sm bg-primary createOpt">Crear nuevo</a>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="usersTable">
                                    <thead>
                                        <tr>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Codigo</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Correo Electrónico</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Tipo de usuario</th>
                                            <th class="text-secondary text-xxs font-weight-bolder opacity-7">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($users as $user) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold px-3"><?= $user["Id"] ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold"><?= $user["UserName"] ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold"><?= $user["Email"] ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        <span data-href="<?= PATH ?>/Usuario/ToggleState/<?= $user['Id'] ?>" style="cursor: pointer;" class="badge badge-sm <?= (bool)$user["State"] ? "bg-success" : "bg-danger"  ?> tog-state-opt"><?= (bool)$user["State"] ? "Activo" : "Bloqueado"  ?></span>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold"><?= $user["TypeName"] ?></span>
                                                </td>
                                                <td class="align-start">
                                                    <a href="<?= PATH ?>/Usuario/Edit/<?= $user['Id'] ?>" class="btn btn-warning btn-circle editOpt">
                                                        <i class="fa fa-file-pen"></i>
                                                    </a>
                                                    <span data-href="<?= PATH ?>/Usuario/Delete/<?= $user['Id'] ?>" style="cursor: pointer;" class="btn btn-danger btn-circle deleteOpt">
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
            $('#usersTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        });
        $('#usersTable').on('click', 'span.deleteOpt', function() {
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
        $('#usersTable').on('click', 'span.tog-state-opt', function() {
            window.location = $(this).attr('data-href');
        });
    </script>
</body>

</html>