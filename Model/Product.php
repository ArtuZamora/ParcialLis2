<?php
require_once 'Model/Dao.php';
class Product extends Dao
{
    public function get($id = '')
    {
        $query = '';
        if ($id  == '') {
            $query = "CALL sp_GetProducts()";
            $result = $this->get_query($query);
        } else {
            $query = "CALL sp_GetProduct(:productId)";
            $result = $this->get_query($query, [":productId" => $id]);
        }
        return $result;
    }
    public function set($product = array())
    {
        $query = "INSERT INTO products(Id, `Name`, `Description`, `Image`, Price, Stock, category_Id, CategoryId)
         VALUES (:id_product, :name_product, :Description_prod, :Image_prod, :Price, :Stock, :category_Id, :category_Id)";

        return $this->set_query($query, $product);
    }
    public function delete($id = '')
    {
        $query = "DELETE FROM products WHERE Id=:id_product";
        return $this->set_query($query, [":id_product" => $id]);
    }
    public function update($product = array())
    {
        $query = "UPDATE products 
        SET `Name`=:name_product,
        `Description`=:Description_prod,
        `Image`=:Image_prod,
        Price=:Price,
        Stock=:Stock,
        category_Id=:category_Id,
        CategoryId=:category_Id
         WHERE `Id`=:id_product";

        return $this->set_query(
            $query,
            [
                ":name_product" => $product["Product"],
                ":Description_prod" => $product["Descripcion"],
                ":Price" => $product["Price"],
                ":Image_prod" => $product["Image"],
                ":Stock" => $product["Stock"],
                ":category_Id" => $product["CategoryId"],
                ":id_product" => $product["Id"],
            ]
        );
    }
}
