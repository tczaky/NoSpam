<?php

class Application_Model_DbTable_User extends Zend_Db_Table_Abstract {

    protected $_name = 'users'; // nazev DB tabulky
    protected $_primary = 'id';
    protected $_dependentTables = array(
        'Application_Model_DbTable_UserInfo',
        'Application_Model_DbTable_Address',
    );

    public function getUser($id) {
        $iduser = (int) $id;
        $row = $this->fetchRow('id = ') . $iduser;
        if (!$row) {
            throw new Exception("Could not find row $iduser");
        }
        return $row->toArray();
    }

    public function findPrimaryKey($id) {
        return $this->fetchRow($this->select()->where('id = ?', $id));
    }

    public function addUser($accessLevel, $email, $password, $confirmPassword, $comment, $contractNumber, $creator) {
        $data = array(
            'AccessLevel' => $accessLevel,
            'Email' => $email,
            'Password' => sha1($password),
            'ConfirmPassword' => sha1($confirmPassword),
            'Comment' => $comment,
            'ContractNumber' => $contractNumber,
            'Creator' => $creator
        );
        $this->insert($data);
    }

    public function updateUser($id, $accessLevel, $comment, $contractNumber) {
        $data = array(
            'AccessLevel' => $accessLevel,
            'Comment' => $comment,
            'ContractNumber' => $contractNumber
        );
        $this->update($data, 'id = ' . (int) $id);
    }

    public function deleteUser($id) {
        $this->delete('id =' . (int) $id);
    }

    public function fetchRowWithUserInfo($id) {
        $select = $this->getAdapter()->select();
        $select->from(array('u' => 'user_info'));    
        $select->where('u.UserId = ?', $id);
        //$select->join(array('a' => 'address'), 'u.UserId = a.UserId');
        $data['user_info'] = $this->getAdapter()->fetchAll($select);

        if (empty($data['user_info'])) {
            return null;
        } else {
            return $data;
        }
    }
    
    public function fetchRowWithUserAddress($id) {
        $select = $this->getAdapter()->select();
        $select->from(array('a' => 'address'));    
        $select->where('a.UserId = ?', $id);       
        $data['address'] = $this->getAdapter()->fetchAll($select);

        if (empty($data['address'])) {
            return null;
        } else {
            return $data;
        }
    }
    
    

}
