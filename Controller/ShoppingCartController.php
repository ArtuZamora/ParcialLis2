<?php
include_once "Controller.php";
include_once "Model/ShoppingCart.php";
class ShoppingCartController extends Controller
{
    private $modelSC;
    function __construct()
    {
        $this->Authorize();
        $this->modelSC = new ShoppingCart();
    }
    public function RenderPdf()
    {
        $viewBag = array();
        $viewBag['shoppingCart'] = $this->modelSC->get($_SESSION["user"]["Id"]);
        $this->render("IndexForPdf", $viewBag);
    }

    public function Index()
    {
        $this->Authorize();
        $viewBag = array();
        $viewBag['shoppingCart'] = $this->modelSC->get($_SESSION["user"]["Id"]);
        $this->render("Index", $viewBag);
    }
    public function AddItem()
    {
        if ($this->modelSC->set($_POST) > 0)
            echo true;
        else
            echo false;
    }
    public function RemoveItem($id)
    {
        $this->modelSC->delete($id);
    }
    public function EditItem()
    {
        $this->modelSC->update($_POST);
    }
}
