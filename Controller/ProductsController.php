<?php
include_once 'Controller.php';
include_once 'Model/Product.php';
include_once 'Model/Category.php';
require_once 'Core/Validate.php';
class ProductsController extends Controller
{
    private $model;
    private $modelC;
    function __construct()
    {
        $this->Authorize();
        $this->AuthorizeRole(['T0001','T0002']);
        $this->model = new Product();
        $this->modelC = new Category();
    }
    public function Index()
    {
        $viewBag = array();
        $viewBag['categories'] = $this->modelC->get();
        $viewBag['products'] = $this->model->get();
        $this->Render('Index', $viewBag);
    }
    public function Details($id)
    {
        $product = $this->model->get($id)[0];
        foreach ($product as $key => $value) {
            $product[$key] = utf8_encode($value);
        }
        echo json_encode($product);
    }
    public function Create()
    {
        $viewBag = array();
        $viewBag["categories"] = $this->modelC->get();
        $this->render('New', $viewBag);
    }
    public function Add()
    {
        $viewBag = array();
        $viewBag["categories"] = $this->modelC->get();
        extract($_POST);
        if (isset($_POST["Guardar"])) {
            $error_log = $this->Validate($_POST);
            $product['id_product'] = $id_product;
            $product['name_product'] = $name_product;
            $product['Description_prod'] = $description;
            $image = $_FILES['image']['name'];
            $temp = $_FILES['image']['tmp_name'];
            $product['Image_prod'] = $image;
            $product['Price'] = $price;
            $product['Stock'] = $stock;
            $product['category_Id'] = $category_id;
            $uploads_dir = "wwwroot/assets/client/img";
            move_uploaded_file($temp, "$uploads_dir/$image");
            if (count($error_log) > 0) {
                $viewBag = array();
                $viewBag['error_log'] = $error_log;
                $viewBag['product'] = $product;
                $viewBag["categories"] = $this->modelC->get();
                $this->render("New", $viewBag);
            } else {
                if ($this->model->set(($product)) > 0) {
                    header('location:' . PATH . '/Products/Index');
                } else {
                    $error_log["id_product_error"] = "Este código ya existe";
                    $viewBag['error_log'] = $error_log;
                    $viewBag['product'] = $product;
                    $viewBag["categories"] = $this->modelC->get();
                    $this->render('New', $viewBag);
                }
            }
        }
    }
    public function Delete($id)
    {
        $this->model->delete($id);
        header('location:' . PATH . '/Products/Index');
    }
    public function Edit($id)
    {
        if (isset($_POST["Guardar"])) {
            extract($_POST);
            $error_log = $this->Validate($_POST);
            $product['Id'] = $id_product;
            $product['Product'] = $name_product;
            $product['Descripcion'] = $description;
            $image = $_FILES['image']['name'];
            $temp = $_FILES['image']['tmp_name'];
            $product['Image'] = $image;
            $product['Price'] = $price;
            $product['Stock'] = $stock;
            $product['CategoryId'] = $category_id;
            $uploads_dir = "wwwroot/assets/client/img";
            move_uploaded_file($temp, "$uploads_dir/$image");
            if (count($error_log) > 0) {
                $viewBag = array();
                $viewBag['error_log'] = $error_log;
                $viewBag["categories"] = $this->modelC->get();
                $viewBag['product'] = $product;
                $this->render("Edit", $viewBag);
            } else {
                $this->model->update($product);
                header('location:' . PATH . '/Products/Index');
            }
        } else {
            $viewBag = array();
            $product = $this->model->get($id)[0];
            $viewBag['product'] = $product;
            $viewBag["categories"] = $this->modelC->get();
            $this->render('Edit', $viewBag);
        }
    }
    private function Validate($data)
    {
        $error_log = array();
        extract($data);
        if (!isset($id_product) || isEmpty($id_product))
            $error_log["id_product_error"] = "Debes ingresar el codigo del producto";
        else if (!isCode($id_product))
            $error_log["id_product_error"] = "Debe tener un formato PROD#####";

        if (!isset($name_product) || isEmpty($name_product))
            $error_log["name_product_error"] = "Debes ingresar el nombre del producto";
        else if (!isText($name_product))
            $error_log["name_product_error"] = "Debes ingresar solamente letras";

        if (!isset($description) || isEmpty($description))
            $error_log["description_error"] = "Debes ingresar una descripcion";

        if (!isset($price) || isEmpty($price))
            $error_log["price_error"] = "Debes ingresar el precio del producto";
        else if (!isMoney($price))
            $error_log["price_error"] = "Debes ingresar un precio válido";

        if (!isset($stock) || isEmpty($stock))
            $error_log["stock_error"] = "Debes ingresar la cantidad de producto existente";
        else if (!isEntero($stock))
            $error_log["stock_error"] = "Debes ingresar una cantidad valida solo números enteros";

        if (!isset($_FILES['image']['name']) || isEmpty($_FILES['image']['name']))
            $error_log["image_error"] = "Debes  escoger una imagen";
        else if (!isImage($_FILES['image']['name']))
            $error_log["image_error"] = "Debes ingresar una imagen valida";
        if (!isset($category_id) || isEmpty($category_id))
            $error_log["category_id_error"] = "Debes seleccionar una categoria";
        return $error_log;
    }
}
