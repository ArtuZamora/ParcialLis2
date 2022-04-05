<?php
require_once 'wwwroot/assets/pdf-creator/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

abstract class Controller
{
    public function RenderToPdf($view, $viewBag = array())
    {
        $file = 'View/' . static::class . '/' . $view . '.php';
        $file = str_replace("Controller", "", $file);
        if (is_file($file)) {
            ob_start();
            extract($viewBag);
            require_once $file;
            $content = ob_get_contents();
            ob_end_clean();
            $html = $content;
            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('isPhpEnabled', true);
            $options->set('isJavascriptEnabled', true);
            $options->set('isHtml5ParserEnabled', true);
            $dompdf = new Dompdf($options);
            $dompdf->getOptions()->getChroot();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('letter');
            $dompdf->render();
            $pdf = $dompdf->output();
            file_put_contents("wwwroot/assets/client/sales/" . $fileName, $pdf);
        } else {
            echo '<h1>Dirección no encontrada</h1>';
        }
    }
    public function Render($view, $viewBag = array())
    {
        $file = 'View/' . static::class . '/' . $view . '.php';
        $file = str_replace("Controller", "", $file);
        if (is_file($file)) {
            ob_start();
            extract($viewBag);
            require_once $file;
            $content = ob_get_contents();
            ob_end_clean();
            echo $content;
        } else {
            echo '<h1>Dirección no encontrada</h1>';
        }
    }
    public function Authorize()
    {
        if (!isset($_SESSION["user"])) {
            header("location: " . PATH . "/Home/Login");
        }
    }
    public function AuthorizeLogin()
    {
        if (isset($_SESSION["user"])) {
            switch ($_SESSION["user"]["UserTypeId"]) {
                case 'T0001':
                case 'T0002':
                    header("location: " . PATH . "/Products/Index");
                    break;
                default:
                    header("location: " . PATH . "/Client/Index");
                    break;
            }
        }
    }
    public function AuthorizeRole($rolesId = array())
    {
        $flag = false;
        foreach ($rolesId as $roleId) {
            if ($_SESSION["user"]["UserTypeId"] == $roleId) {
                $flag = true;
                break;
            }
        }
        if (!$flag)
            $this->AuthorizeLogin();
    }
}
