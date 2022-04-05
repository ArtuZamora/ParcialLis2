<?php
require_once 'Dao.php';
class Sales extends Dao
{    
    public function getLast($id = '')
    { 
        $query = "CALL sp_GetLastSale(:userId)";
        $result = $this->get_query($query, [":userId" => $id]);
        return $result;
    }
    public function get()
    {
        $query = "SELECT s.Id, s.Total, s.PDF, s.CreatedDate, s.UserId, u.Name as UserName
                  FROM sales s
                  INNER JOIN users u ON u.Id = s.UserId
                  ORDER BY s.CreatedDate DESC";
        $result = $this->get_query($query);
        return $result;
    }
    public function set($object = array())
    {
        extract($object);
        $query = "CALL sp_SetSale(:total, :pdf, :userId)";
        $result = $this->set_query($query, [":total" => $total, ":pdf" => $pdf, ":userId" => $userId]);
        return $result;
    }
    public function update($object = array())
    {
    }
    public function delete($id = '')
    {        
    }
}
