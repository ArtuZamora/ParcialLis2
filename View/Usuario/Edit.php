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
                            <h6>Editar usuario</h6>
                        </div>
                        <div class="card-body p-5">
                            <form role="form" action="<?= PATH ?>/Usuario/Edit" enctype="multipart/form-data" method="POST">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-5">
                                        <input type="hidden" name="op" value="insertar" />
                                        <div class="well well-sm"><strong><span class="glyphicon glyphicon-asterisk"></span>Campos requeridos</strong></div>
                                        <div class="form-group">
                                            <label for="codigo">Código</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="id" value="<?= isset($user) ? $user['Id'] : '' ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="codigo">Nombre</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="name" value="<?= isset($user) ? $user['Name'] : '' ?>" placeholder="Ingresa el nombre del usuario">
                                            </div>
                                            <p class="text-danger"><?= isset($error_log['name_error']) ? $error_log['name_error'] : '' ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="nombre">Correo electrónico</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="email" value="<?= isset($user) ? $user['Email'] : '' ?>" placeholder="Ingresa el correo del usuario" readonly>
                                            </div>
                                            <p class="text-danger"><?= isset($error_log['email_error']) ? $error_log['email_error'] : '' ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="nombre">Contraseña</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="password" value="<?= isset($user['Password']) ? $user['Password'] : '' ?>" placeholder="Ingresa la contraseña">
                                            </div>
                                            <p class="text-danger"><?= isset($error_log['password_error']) ? $error_log['password_error'] : '' ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="nombre">Repetir Contraseña</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="passwordRepeat" value="<?= isset($user['PasswordRepeat']) ? $user['PasswordRepeat'] : '' ?>" placeholder="Repita la contraseña">
                                            </div>
                                            <p class="text-danger"><?= isset($error_log['passwordRepeat_error']) ? $error_log['passwordRepeat_error'] : '' ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="nombre">Tipo de usuario</label>
                                            <div class="input-group">
                                                <select class="form-control" name="userTypeId">
                                                    <option value="">Seleccione...</option>
                                                    <?php
                                                    foreach ($userTypes as $userType) {
                                                    ?>
                                                    <option value="<?= $userType["Id"] ?>"><?= $userType["Name"] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <p class="text-danger"><?= isset($error_log['userType_error']) ? $error_log['userType_error'] : '' ?></p>
                                        </div>


                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center">
                                                <input type="submit" class="btn btn-info mx-3" value="Guardar" name="Guardar">
                                                <a class="btn btn-danger" href="<?= PATH ?>/Usuario/Index">Cancelar</a>
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
    if(isset($user)){
        ?>
        <script>
            $('select[name=userTypeId]').val('<?= $user['UserTypeId'] ?>');
        </script>
        <?php
    }
    ?>
</body>

</html>