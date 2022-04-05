<?php
require_once 'Dao.php';
class Usuario extends Dao
{
    public function login($object = array())
    {
        extract($object);
        $query = 'CALL sp_login(:email, :password)';
        $result = $this->get_query($query, [":email" => $email, ":password" => $password]);
        if (count($result) == 1) {
            $_SESSION["user"] = $result[0];
            return true;
        }
        session_unset();
        return false;
    }

    public function existsEmail($email = "")
    {
        $query = 'SELECT * FROM users WHERE Email = :Email';
        $result = $this->get_query($query, [":Email" => $email]);
        if (count($result) >= 1)
            return true;
        else
            return false;
    }

    public function get($id = '')
    {
        $query = '';
        if ($id  == '') {
            $query = "CALL sp_GetUsers()";
            $result = $this->get_query($query);
        } else {
            $query = "CALL sp_GetUser(:userId)";
            $result = $this->get_query($query, [":userId" => $id]);
        }
        return $result;
    }

    public function signin($object = array())
    {
        extract($object);
        $query = 'CALL sp_signIn(?,?)';
        return $this->set_query($query, 'ss', array($code, $password));
    }

    public function getTypes()
    {
        $query = 'SELECT * FROM usertypes';
        $result = $this->get_query($query);
        return $result;
    }


    //TODO: SHOULD change
    public function set($object = array())
    {
        extract($object);
        $query = "CALL sp_SetUser(:Name,:Password,:Email,:TypeId)";
        $result = $this->set_query(
            $query,
            [
                ":Name" => $Name,
                ":Password" => $Password,
                ":Email" => $Email,
                ":TypeId" => $UserTypeId
            ]
        );
        return $result;
    }
    public function update($object = array())
    {
        extract($object);
        $query = "";
        $result = "";
        if (isset($Password) && $Password != "") {
            $query = "UPDATE users 
                SET `Name` = :Name,
                 `Password` = PASSWORD(:Password),
                 `Email` = :Email,
                 UserTypeId = :TypeId,
                 usertypes_Id = :TypeId
                  WHERE Id = :userId";
            $result = $this->set_query(
                $query,
                [
                    ":userId" => $Id,
                    ":Name" => $Name,
                    ":Password" => $Password,
                    ":Email" => $Email,
                    ":TypeId" => $UserTypeId
                ]
            );
        } else {
            $query = "UPDATE users 
                  SET `Name` = :NameIpt,
                   `Email` = :Email,
                   UserTypeId = :TypeId,
                   usertypes_Id = :TypeId
                    WHERE Id = :userId";
            $result = $this->set_query(
                $query,
                [
                    ":userId" => $Id,
                    ":NameIpt" => $Name,
                    ":Email" => $Email,
                    ":TypeId" => $UserTypeId
                ]
            );
        }
        return $result;
    }
    public function delete($id = '')
    {
        $query = "DELETE FROM users WHERE Id = :Id";
        $result = $this->set_query($query, [":Id" => $id]);
        return $result;
    }
    public function toggleState($id = '')
    {
        $query = "UPDATE users SET `State` = !`State` WHERE Id = :Id";
        $result = $this->set_query($query, [":Id" => $id]);
        return $result;
    }
}
