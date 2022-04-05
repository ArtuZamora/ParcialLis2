<?php
include_once "Controller.php";
include_once "Model/Usuario.php";
include_once "Core/Validate.php";
class HomeController extends Controller
{
    private $model;
    function __construct()
    {
        $this->model = new Usuario();
    }
    public function Login()
    {
        $this->AuthorizeLogin();
        if (isset($_POST['submit'])) {
            if ($this->model->login($_POST)) {
                if ($_SESSION["user"]["UserTypeId"] == 'T0001' || $_SESSION["user"]["UserTypeId"] == 'T0002')
                    header("location: " . PATH . "/Products/Index");
                else
                    header("location: " . PATH . "/Client/Index");
            } else {
                $viewBag = array();
                $viewBag['error_log'] = ['invalid_credentials' => 'Credenciales inválidas'];
                $viewBag['temp_data'] = ['email' => $_POST['email']];
                $this->render("Login", $viewBag);
            }
        } else
            $this->render("Login");
    }
    public function Signin()
    {
        $this->AuthorizeLogin();
        extract($_POST);
        if (isset($_POST["submit"])) {
            $error_log = $this->Validate($_POST);

            $user['Name'] = $name;
            $user['Email'] = $email;
            $user['Password'] = $password;
            $user['PasswordRepeat'] = $passwordRepeat;
            $user['UserTypeId'] = 'T0003'; //ActualValue for Clients
            if (count($error_log) > 0) {
                $viewBag = array();
                $viewBag['error_log'] = $error_log;
                $viewBag['user'] = $user;
                $this->render("Signin", $viewBag);
            } else {
                if ($this->model->set($user) > 0) {
                    header('location:' . PATH . '/Home/Login');
                } else {
                    $viewBag = array();
                    $error_log["name_error"] = "Ha existido un problema, porfavor intente mas tarde";
                    $viewBag['error_log'] = $error_log;
                    $viewBag['user'] = $user;
                    $this->render('Signin', $viewBag);
                }
            }
        } else {
            $this->render('Signin');
        }
    }
    public function Logout()
    {
        session_unset();
        header("location: " . PATH . "/Home/Login");
    }
    private function Validate($data)
    {
        $error_log = array();
        extract($data);
        if (!isset($name) || isEmpty($name))
            $error_log["name_error"] = "Debes ingresar el nombre del usuario";
        else if (!isText($name))
            $error_log["name_error"] = "Debes ingresar solamente letras";
        if (!isset($email) || isEmpty($email))
            $error_log["email_error"] = "Debes ingresar el correo electrónico";
        else if (!isEmail($email))
            $error_log["email_error"] = "Debes ingresar un correo electrónico válido";
        else if ($this->model->existsEmail($email))
            $error_log["email_error"] = "Este correo electrónico ya existe";
        if (!isset($password) || isEmpty($password))
            $error_log["password_error"] = "Debes ingresar una contraseña";
        if (strcmp($password, $passwordRepeat) !== 0)
            $error_log["passwordRepeat_error"] = "Las contraseñas no coinciden";
        return $error_log;
    }
}
