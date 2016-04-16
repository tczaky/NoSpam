<?php

class RegisterController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
        $form = new Application_Form_Register();        //instance (odkaz na form registr.php)
        $form->submit->setLabel('Přidat'); //popisek odesílacího tlačítka
        $this->view->RegisterForm = $form; //předání view
        $password_string = 'abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';

        if ($this->getRequest()->isPost()) {  //Pokud metoda isPost() na objektu requestu vrací true, tak byl formulář odeslán
            $formData = $this->getRequest()->getPost(); //pomocí getPost() získáme data
            if ($form->isValid($formData)) {    //pomocí isValid() ověříme, že jsou data správná
                $accessLevel = $form->getValue('AccessLevel');
                $email = $form->getValue('Email');                
                $password = substr(str_shuffle($password_string), 0, 12);                
                $confirmPassword = $password;
                $comment = $form->getValue('Comment');
                $contractNumber = $form->getValue('ContractNumber');
                $person = Zend_Auth::getInstance()->getIdentity();
                $creator = $person->Email;

                $user = new Application_Model_DbTable_User();                
                $user->addUser($accessLevel, $email, $password, $confirmPassword, $comment, $contractNumber, $creator);

                $mail = new Zend_Mail('UTF-8');
                $mail->addTo($email, 'Tomas Czakan') //prijemnce
                        ->setFrom('sportevents1@seznam.cz', 'Enwico DATA') //odesilatel
                        ->setSubject('Potvrzeni registrace')
                        ->setBodyText($form->getValue('FirstName') . ', Byl jste registrován do aplikace NOSPAM, vaše dočasné heslo je: ' . $password . '. Heslo změníte v sekci Můj profil!!!')
                        ->send();

                $this->_helper->redirector('list-of-users'); //přesměrování na list-of-users
            } else {
                $form->populate($formData); //Pokud zadaná data nejsou validní, pak jimi naplníme formulář a znovu ho zobrazíme.
            }
        }
    }

    public function editAction() {
        $form = new Application_Form_Register(); //instance (odkaz na form registr.php)
        $form->submit->setLabel('Uložit'); //popisek odesílacího tlačítka
        $form->getElement('Email')->removeValidator('Db_NoRecordExists');
        $this->view->RegisterForm = $form; //předání view         

        if ($this->getRequest()->isPost()) { //jestli to není post ale get tak to vykreslí data z databáze
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = $form->getValue('id');
                $accessLevel = $form->getValue('AccessLevel');            
                $comment = $form->getValue('Comment');
                $contractNumber = $form->getValue('ContractNumber'); 
                
                $user = new Application_Model_DbTable_User();
                $user->updateUser($id, $accessLevel, $comment, $contractNumber);
                $this->_helper->redirector('list-of-users');
            }
        } else {
            $user = new Application_Model_DbTable_User();
            $selecteduser = $this->_getParam('id', 0); // zjištění id
            $data = $user->findPrimaryKey($selecteduser);
            $form->populate($data->toArray());
        }
    }

     public function deleteAction() {
        if ($this->getRequest()->isPost()) {    //zjištění zda se má zobrazit potvrzovací form nebo provést mazání
            $del = $this->getRequest()->getPost('del'); //získá se hodnota z view jestli ano či ne ('del' je hodnota parametru name z view]
            if ($del == 'Ano') {
                $user = new Application_Model_DbTable_User();
                $selectedUser = $user->findPrimaryKey($this->getParam('id'));
                $selectedUser->delete();
                $this->_helper->redirector('list-of-users');
            }
            if ($del == 'Ne') {
                $this->_helper->redirector('list-of-users');
            }
        } else {
            $id = $this->_getParam('id', 0);    //pomocí getparam zjistím id
            $user = new Application_Model_DbTable_User();   //instance do modelu abych poté zjistil záznam s uživatelem
            $this->view->user = $user->findPrimaryKey($id); //předám view
        }
    }

    public function listOfUsersAction()
    {
        $usersTBL = new Application_Model_DbTable_User(); //propojeni s modelem pres autoloader v bootstrapu...je to podle adresarove slozky application/model/dbtable/user
        $this->view->user = $usersTBL->fetchAll(); //fetchall metoda, která vypíše všechny údaje z tabulky
    }

}




