<?php
function isSelected($controller, $action = null)
{
    $cssClass = '';
    $router = new Routing();
    if ($action != null) {
        if ($controller == str_replace('Controller', '', $router->controller) && $action == $router->method)
            $cssClass = "active";
    } else {
        if ($controller == str_replace('Controller', '', $router->controller))
            $cssClass = "active";
    }
    return $cssClass;
}
?>
<div class="min-height-300 bg-primary position-absolute w-100"></div>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="">
            <span class="ms-1 font-weight-bold"><?= utf8_encode($_SESSION["user"]["Name"]) ?></span>
            <br><small class="ms-1"><?= utf8_encode($_SESSION["user"]["Email"]) ?></small>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?= isSelected('Products') ?>" href="<?= PATH ?>/Products/Index">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-cart-shopping text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Productos</span>
                </a>
            </li>
        </ul>

        <?php
        if ($_SESSION["user"]["UserTypeId"] == "T0001") {
        ?>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?= isSelected('Categories') ?>" href="<?= PATH ?>/Categories/Index">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-folder-tree text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Categorias</span>
                    </a>
                </li>
            </ul>
        <?php
        }
        ?>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?= isSelected('Sales') ?>" href="<?= PATH ?>/Sales/Index">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-file-invoice-dollar text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Ventas</span>
                </a>
            </li>
        </ul>

        <?php
        if ($_SESSION["user"]["UserTypeId"] == "T0001") {
        ?>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?= isSelected('Usuario') ?>" href="<?= PATH ?>/Usuario/Index">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-user text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Usuarios</span>
                    </a>
                </li>
            </ul>
        <?php
        }
        ?>
    </div>
</aside>