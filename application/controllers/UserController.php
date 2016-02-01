<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
    }

    public function addAction()
    {
        // action body
    }

    public function editAction()
    {
        // action body
    }

    public function deleteAction()
    {
        // action body
    }

    public function listOfUsersAction()
    {
        $usersTBL = new Application_Model_DbTable_User(); //propojeni s modelem pres autoloader v bootstrapu...je to podle adresarove slozky application/model/dbtable/user
        $this->view->user = $usersTBL->fetchAll(); //fetchall metoda, která vypíše všechny údaje z tabulky
    }


}











