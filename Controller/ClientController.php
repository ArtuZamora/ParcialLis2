<?php
include_once "Controller.php";
include_once "Model/Product.php";
include_once "Model/ShoppingCart.php";
class ClientController extends Controller
{
    private $modelP;
    function __construct()
    {
        $this->modelP = new Product();
        $this->modelSC = new ShoppingCart();
    }
    public function Index()
    {
        $viewBag = array();
        $viewBag['products'] = $this->modelP->get();
        $this->render("Index", $viewBag);
    }
}
