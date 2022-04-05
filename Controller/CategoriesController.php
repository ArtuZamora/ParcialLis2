<?php
include_once "Controller.php";
include_once "Model/Category.php";
require_once 'Core/Validate.php';
class CategoriesController extends Controller
{
    private  $model;
    function __construct()
    {
        $this->Authorize();
        $this->AuthorizeRole(['T0001']);
        $this->model = new Category();
    }

    public function Index()
    {
        $viewBag = array();
        $viewBag['categories'] = $this->model->get();
        $this->Render('Index', $viewBag);
    }

    public function Create()
    {
        $this->render('New');
    }

    public function Add()
    {
        extract($_POST);
        if (isset($_POST["Guardar"])) {
            $error_log = $this->Validate($_POST);

            $category['Id'] = $Id;
            $category['Name'] = $Name;
            if (count($error_log) > 0) {
                $viewBag = array();
                $viewBag['error_log'] = $error_log;
                $viewBag['category'] = $category;
                $this->render("New", $viewBag);
            } else {
                if ($this->model->set(($category)) > 0) {
                    header('location:' . PATH . '/Categories/Index');
                } else {
                    $error_log["Id_category_error"] = "Este código ya existe";
                    $viewBag['error_log'] = $error_log;
                    $viewBag['category'] = $category;
                    $this->render('New', $viewBag);
                }
            }
        }
    }
    public function Delete($id)
    {
        $this->model->delete($id);
        header('location:' . PATH . '/Categories/Index');
    }
    public function Edit($id)
    {
        if (isset($_POST["Guardar"])) {
            extract($_POST);
            $error_log = $this->Validate($_POST);
            $category['Id'] = $Id;
            $category['Name'] = $Name;
            if (count($error_log) > 0) {
                $viewBag = array();
                $viewBag['error_log'] = $error_log;
                $viewBag['category'] = $category;
                $this->render("Edit", $viewBag);
            } else {
                $this->model->update($category);
                header('location:' . PATH . '/Categories/Index');
            }
        } else {
            $viewBag = array();
            $category = $this->model->get($id)[0];
            $viewBag['category'] = $category;
            $this->render('Edit', $viewBag);
        }
    }
    private function Validate($data)
    {
        $error_log = array();
        extract($data);
        if (!isset($Id) || isEmpty($Id))
            $error_log["Id_category_error"] = "Debes ingresar el codigo de la categoria";
        else if (!isEntero($Id))
            $error_log["Id_category_error"] = "Debe tener un formato de solo numeros #####";
        if (!isset($Name) || isEmpty($Name))
            $error_log["Name_category_error"] = "Debes ingresar el nombre de la categoria";
        else if (!isText($Name))
            $error_log["Name_category_error"] = "Debes ingresar solamente letras";
        return $error_log;
    }
}
