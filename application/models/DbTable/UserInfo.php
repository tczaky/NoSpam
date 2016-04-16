<?php

class Application_Model_DbTable_UserInfo extends Zend_Db_Table_Abstract {

    protected $_name = 'user_info';
    protected $_primary = 'id';
    protected $_referenceMap = array(
        'User' => array(
            'columns' => 'UserId',
            'refTableClass' => 'Application_Model_DbTable_User', 
            'refColumns' => 'id',
        )
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

    public function addUserInfo($firstName, $lastName, $telNumber, $comment, $userId) {
        $data = array(
            'FirstName' => $firstName,
            'LastName' => $lastName,
            'TelNumber' => $telNumber,
            'Comment' => $comment,
            'UserId' => $userId
        );
        $this->insert($data);
    }

    public function updateUserInfo($id, $firstName, $lastName, $telNumber, $comment) {
        $data = array(
            'FirstName' => $firstName,
            'LastName' => $lastName,
            'TelNumber' => $telNumber,
            'Comment' => $comment
        );
        $this->update($data, 'id = ' . (int) $id);
    }

    public function deleteUserInfo($id) {
        $this->delete('id =' . (int) $id);
    }

}
