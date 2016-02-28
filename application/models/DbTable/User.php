<?php

class Application_Model_DbTable_User extends Zend_Db_Table_Abstract {

    protected $_name = 'users'; // nazev DB tabulky
    protected $_primary = 'id';

    public function getUser($id) {
        $iduser = (int)$id;
        $row = $this->fetchRow('id = ') . $iduser;
        if (!$row) {
            throw new Exception("Could not find row $iduser");
        }
        return $row->toArray();
    }
    
    public function findPrimaryKey($id) {
        return $this->fetchRow($this->select()->where('id = ?', $id));
        
    }

    public function addUser($accessLevel, $email, $password, $confirmPassword, $fistName, $lastName, $telNumber, $comment) {
        $data = array(
            'AccessLevel' => $accessLevel,
            'Email' => $email,
            'Password' => sha1($password),
            'ConfirmPassword' => sha1($confirmPassword),
            'FirstName' => $fistName,
            'LastName' => $lastName,
            'TelNumber' => $telNumber,
            'Comment' => $comment
        );
        $this->insert($data);
    }
    
    public function updateUser($id, $accessLevel, $email, $password, $confirmPassword, $fistName, $lastName, $telNumber, $comment)
    {
        $data = array(
            'AccessLevel' => $accessLevel,
            'Email' => $email,
            'Password' => sha1($password),
            'ConfirmPassword' => sha1($confirmPassword),
            'FirstName' => $fistName,
            'LastName' => $lastName,
            'TelNumber' => $telNumber,
            'Comment' => $comment
        );
        $this->update($data, 'id = '. (int)$id);
    }
    
    public function deleteUser($id)
    {
        $this->delete('id =' . (int)$id);
    }
}
