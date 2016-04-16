<?php

class UserController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        
    }

    public function addAction() {
        $form = new Application_Form_UserInfo();
        $form->submit->setLabel('Uložit'); //popisek odesílacího tlačítka
        $this->view->UserInfoForm = $form; //předání view

        if ($this->getRequest()->isPost()) {  //Pokud metoda isPost() na objektu requestu vrací true, tak byl formulář odeslán
            $formData = $this->getRequest()->getPost(); //pomocí getPost() získáme data
            if ($form->isValid($formData)) {    //pomocí isValid() ověříme, že jsou data správná
                $person = Zend_Auth::getInstance()->getIdentity(); //získání údajů aktuálního příhlášeného uživatele
                $userId = $person->id;
                $firstName = $form->getValue('FirstName');
                $lastName = $form->getValue('LastName');
                $telNumber = $form->getValue('TelNumber');
                $comment = $form->getValue('Comment');

                $userInfo = new Application_Model_DbTable_UserInfo();
                $userInfo->addUserInfo($firstName, $lastName, $telNumber, $comment, $userId);
                $this->_helper->redirector('show', 'user', 'default', array('id' => $userId));
            } else {
                $form->populate($formData); //Pokud zadaná data nejsou validní, pak jimi naplníme formulář a znovu ho zobrazíme.
            }
        }
    }

    public function editAction() {
        $form = new Application_Form_UserInfo();
        $form->submit->setLabel('Uložit'); //popisek odesílacího tlačítka
        $this->view->UserInfoForm = $form; //předání view       

        if ($this->getRequest()->isPost()) { //jestli to není post ale get tak to vykreslí data z databáze
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $person = Zend_Auth::getInstance()->getIdentity(); //získání údajů aktuálního příhlášeného uživatele
                $userId = $person->id;
                $id = $form->getValue('id');
                $firstName = $form->getValue('FirstName');
                $lastName = $form->getValue('LastName');
                $telNumber = $form->getValue('TelNumber');
                $comment = $form->getValue('Comment');

                $userInfo = new Application_Model_DbTable_UserInfo();
                $userInfo->updateUserInfo($id, $firstName, $lastName, $telNumber, $comment);               
                $this->_helper->redirector('show', 'user', 'default', array('id' => $userId));                
            }
        } else {
            $userInfo = new Application_Model_DbTable_UserInfo();
            $selecteduser = $this->_getParam('id', 0); // zjištění id
            $data = $userInfo->findPrimaryKey($selecteduser);
            $form->populate($data->toArray());
        }
    }

    public function showAction() {
        $id = $this->getRequest()->getParam('id');
        $user = new Application_Model_DbTable_User();
        $userData = $user->fetchRowWithUserInfo($id);
        $userDataAddress = $user->fetchRowWithUserAddress($id);

        if ($userData == null) {
            $this->_helper->redirector('add', 'user', 'default');
        } else {
            $this->view->userInfo = $userData;
        }

        if ($userDataAddress == null) {
            $this->_helper->redirector('add', 'address', 'default');
        } else {
            $this->view->address = $userDataAddress;
        }
    }

}
