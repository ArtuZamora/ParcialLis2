<?php
include_once "Controller.php";
include_once "Model/Usuario.php";
require_once 'Core/Validate.php';
class UsuarioController extends Controller
{
    private  $model;
    function __construct()
    {
        $this->Authorize();        
        $this->AuthorizeRole(['T0001']);
        $this->model = new Usuario();
    }

    public function Index()
    {
        $viewBag = array();
        $viewBag['users'] = $this->model->get();
        $this->Render('Index', $viewBag);
    }

    public function ToggleState($id = '')
    {
        $this->model->toggleState($id);
        header("location: " . PATH . "/Usuario/Index");
    }

    public function Create()
    {
        $viewBag = array();
        $viewBag["userTypes"] = $this->model->getTypes();
        $this->render('New', $viewBag);
    }

    public function Add()
    {
        extract($_POST);
        if (isset($_POST["Guardar"])) {
            $error_log = $this->Validate($_POST);

            $user['Name'] = $name;
            $user['Email'] = $email;
            $user['Password'] = $password;
            $user['PasswordRepeat'] = $passwordRepeat;
            $user['UserTypeId'] = $userTypeId;
            if (count($error_log) > 0) {
                $viewBag = array();
                $viewBag['error_log'] = $error_log;
                $viewBag['user'] = $user;
                $viewBag["userTypes"] = $this->model->getTypes();
                $this->render("New", $viewBag);
            } else {
                if ($this->model->set(($user)) > 0) {
                    header('location:' . PATH . '/Usuario/Index');
                } else {
                    $viewBag = array();
                    $viewBag["userTypes"] = $this->model->getTypes();
                    $error_log["name_error"] = "Ha existido un problema, porfavor intente mas tarde";
                    $viewBag['error_log'] = $error_log;
                    $viewBag['user'] = $user;
                    $this->render('New', $viewBag);
                }
            }
        } else
            header('location:' . PATH . '/Usuario/Index');
    }
    public function Delete($id)
    {
        $this->model->delete($id);
        header('location:' . PATH . '/Usuario/Index');
    }
    public function Edit($id)
    {
        extract($_POST);
        if (isset($_POST["Guardar"])) {
            $error_log = $this->ValidateEdit($_POST);
            $user['Id'] = $id;
            $user['Name'] = $name;
            $user['Email'] = $email;
            if (isset($password))
                $user['Password'] = $password;
            if (isset($passwordRepeat))
                $user['PasswordRepeat'] = $passwordRepeat;
            $user['UserTypeId'] = $userTypeId;
            if (count($error_log) > 0) {
                $viewBag = array();
                $viewBag['error_log'] = $error_log;
                $viewBag['user'] = $user;
                $viewBag["userTypes"] = $this->model->getTypes();
                $this->render("Edit", $viewBag);
            } else {
                if ($this->model->update(($user)) > 0) {
                    header('location:' . PATH . '/Usuario/Index');
                } else {
                    $viewBag = array();
                    $viewBag["userTypes"] = $this->model->getTypes();
                    $error_log["name_error"] = "Ha existido un problema, porfavor intente mas tarde";
                    $viewBag['error_log'] = $error_log;
                    $viewBag['user'] = $user;
                    $this->render('Edit', $viewBag);
                }
            }
        } else {
            $viewBag = array();
            $viewBag["userTypes"] = $this->model->getTypes();
            $viewBag['user'] = $this->model->get($id)[0];
            $this->render('Edit', $viewBag);
        }
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
        if (!isset($userTypeId) || isEmpty($userTypeId))
            $error_log["userType_error"] = "Debes seleccionar un tipo de usuario";
        return $error_log;
    }
    private function ValidateEdit($data)
    {
        $error_log = array();
        extract($data);
        if (!isset($name) || isEmpty($name))
            $error_log["name_error"] = "Debes ingresar el nombre del usuario";
        else if (!isText($name))
            $error_log["name_error"] = "Debes ingresar solamente letras";
        if (isset($password))
            if (strcmp($password, $passwordRepeat) !== 0)
                $error_log["passwordRepeat_error"] = "Las contraseñas no coinciden";
        if (!isset($userTypeId) || isEmpty($userTypeId))
            $error_log["userType_error"] = "Debes seleccionar un tipo de usuario";
        return $error_log;
    }
}
