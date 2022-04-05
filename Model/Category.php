<?php
require_once 'Model/Dao.php';
class Category extends Dao
{
    public function get($id = '')
    {
        $query = '';
        if ($id == '') {
            $query = 'SELECT *
                        FROM category';
            return $this->get_query($query);
        } else {
            $query = 'SELECT *
                        FROM category WHERE Id=:Id';
            return $this->get_query($query, [":Id" => $id]);
        }
    }
    public function set($category = array())
    {
        $query = "INSERT INTO category(Id, `Name`)
         VALUES (:Id, :Name_category)";

        return $this->set_query($query, [":Id" => $category["Id"], ":Name_category" => $category["Name"]]);
    }
    public function delete($id = '')
    {
        $query = "DELETE FROM category WHERE Id=:Id";
        return $this->set_query($query, [":Id" => $id]);
    }
    public function update($category = array())
    {
        $query = "UPDATE category 
        SET `Name`=:Name_category
         WHERE Id=:Id";

        return $this->set_query($query, [":Id" => $category["Id"], ":Name_category" => $category["Name"]]);
    }
}
