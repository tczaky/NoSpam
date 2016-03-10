<?php

class Application_Model_DbTable_Black extends Zend_Db_Table_Abstract
{

    protected $_name = 'rules_black'; //spojeni s tabulkou v db
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

    public function addRule($name, $description) {
        $data = array(
            'Name' => $name,
            'Description' => $description
        );
        $this->insert($data);
    }
    
    public function updateRule($id, $name, $description)
    {
        $data = array(
            'Name' => $name,
            'Description' => $description
        );
        $this->update($data, 'id = '. (int)$id);
    }
    
    public function deleteRule($id)
    {
        $this->delete('id =' . (int)$id);
    }

}

