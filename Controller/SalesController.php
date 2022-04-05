<?php
include_once "Controller.php";
include_once "Model/ShoppingCart.php";
include_once "Model/Sales.php";
class SalesController extends Controller
{
    private $modelSC;
    private $modelS;
    function __construct()
    {
        $this->Authorize();
        $this->modelSC = new ShoppingCart();
        $this->modelS = new Sales();
    }
    public function Index(){
        $this->AuthorizeRole(['T0001','T0002']);
        $viewBag = array();
        $viewBag["sales"] = $this->modelS->get();
        $this->Render("Index", $viewBag);
    }
    public function SetSale()
    {
        if (isset($_POST["setSale"])) {
            $userId = $_SESSION["user"]["Id"];
            $shoppingCart = $this->modelSC->get($userId);
            if (count($shoppingCart) > 0) {
                $date = date('dmy his');
                $fileName = $userId . ' ' . $date . '.pdf';
                $total = floatval($_POST["total"]) + floatval($_POST["shipping"]);
                $this->modelS->set(["total" => $total, "pdf" => $fileName, "userId" => $userId]);
                $lastSale = $this->modelS->getLast($userId);
                $viewBag = array();
                $viewBag['shoppingCart'] = $shoppingCart;
                $viewBag['details'] = $_POST;
                $viewBag['fileName'] = $fileName;
                $viewBag['lastSale'] = $lastSale;
                $this->RenderToPdf("IndexForPdf", $viewBag);
                foreach ($shoppingCart as $product) {
                    $this->modelSC->updateProductsStock(["id" => $product["ProductId"], "quantity" => $product["Quantity"]]);
                }
                $this->modelSC->clearShoppingCart($userId);
                unset($_POST);
                $this->Render("Done", $viewBag);
            }
            else{
                header("location: " . PATH . "/Client/Index");
            }
        }
        else{
            header("location: " . PATH . "/Client/Index");
        }
    }
    public function Done()
    {
        $this->Render("Done");
    }
}
