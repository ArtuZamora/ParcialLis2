<?php
abstract class Dao
{
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $db_conn;
    function __construct()
    {
        $this->db_host = "localhost";
        $this->db_user = "root";
        $this->db_pass = "";
        $this->db_name = "textil_export";
    }

    private function db_open()
    {
        try {
            $this->db_conn = new PDO("mysql:host=$this->db_host;dbname=$this->db_name;", $this->db_user, $this->db_pass);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    private function db_close()
    {
        $this->db_conn = null;
    }
    protected function set_query($query, $params = array())
    {
        try{
            $this->db_open();
            $stmt = $this->db_conn->prepare($query);
            $stmt->execute($params);
            $rowsAffected = $stmt->rowCount();
            $this->db_close();
            return $rowsAffected;
        }
        catch(exception $e)
        {
            echo $e;
            return 0;
        }
    }
    protected function get_query($query, $params = array())
    {
        $this->db_open();
        $stmt = $this->db_conn->prepare($query);
        $stmt->execute($params);
        $rows = [];
        while ($rows[] = $stmt->fetch(PDO::FETCH_ASSOC));
        $this->db_close();
        array_pop($rows);
        return $rows;
    }
    abstract function get();
    abstract function set();
    abstract function delete();
    abstract function update();
}
