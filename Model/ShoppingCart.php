<?php
require_once 'Dao.php';
class ShoppingCart extends Dao
{
    public function get($id = '')
    {
        $query = "CALL sp_GetShoppingCart(:userId)";
        $result = $this->get_query($query, [":userId" => $id]);
        return $result;
    }
    public function set($object = array())
    {
        extract($object);
        $query = "CALL sp_SetShoppingCart(:userId, :productId, :quantity)";
        $result = $this->set_query($query, [":userId" => $id, ":productId" => $productId, ":quantity" => $quantity]);
        return $result;
    }
    public function update($object = array())
    {
        extract($object);
        $query = "CALL sp_UpdateShoppingCart(:userId, :productId, :quantity)";
        $result = $this->set_query($query, [":userId" => $id, ":productId" => $productId, ":quantity" => $quantity]);
        return $result;
    }
    public function delete($id = '')
    {
        $query = "DELETE FROM `shoppingcart` WHERE Id = :id";
        $result = $this->set_query($query, [":id" => $id]);
        return $result;
    }
    public function updateProductsStock($object = array())
    {
        extract($object);
        $query = "CALL sp_UpdateProductsStock(:id, :quantity)";
        $result = $this->set_query($query, [":id" => $id, ":quantity" => $quantity]);
        return $result;
    }
    public function clearShoppingCart($id = '')
    {      
        $query = "CALL sp_ClearShoppingCart(:id)";
        $result = $this->set_query($query, [":id" => $id]);
        return $result;
    }
}
