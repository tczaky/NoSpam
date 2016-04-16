<?php

class Application_Model_DbTable_Address extends Zend_Db_Table_Abstract
{

    protected $_name = 'address';
    protected $_primary = 'id';
    protected $_referenceMap = array(
        'User' => array(
            'columns' => 'UserId',
            'refTableClass' => 'Application_Model_DbTable_User', 
            'refColumns' => 'id',
        )
    );
    
     public function getAddress($id) {
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

    public function addUserAddress($city, $street, $zipCode, $state, $userId) {
        $data = array(
            'City' => $city,
            'Street' => $street,
            'ZipCode' => $zipCode,
            'State' => $state,
            'UserId' => $userId
        );
        $this->insert($data);
    }
    
     public function updateUserAddress($id, $city, $street, $zipCode, $state) {
        $data = array(
            'City' => $city,
            'Street' => $street,
            'ZipCode' => $zipCode,
            'State' => $state,
            
        );
        $this->update($data, 'id = ' . (int) $id);
    }


}

