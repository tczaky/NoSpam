<?php

class AddressController extends Zend_Controller_Action
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
        $form = new Application_Form_Address();
        //instance (odkaz na form registr.php)
        $form->submit->setLabel('Uložit'); //popisek odesílacího tlačítka
        $this->view->Address = $form; //předání view

        if ($this->getRequest()->isPost()) {  //Pokud metoda isPost() na objektu requestu vrací true, tak byl formulář odeslán
            $formData = $this->getRequest()->getPost(); //pomocí getPost() získáme data
            if ($form->isValid($formData)) {    //pomocí isValid() ověříme, že jsou data správná
                $person = Zend_Auth::getInstance()->getIdentity(); //získání údajů aktuálního příhlášeného uživatele
                $userId = $person->id;
                $city = $form->getValue('City');
                $street = $form->getValue('Street');
                $zipCode = $form->getValue('ZipCode');
                $state = $form->getValue('State');

                $userAdress = new Application_Model_DbTable_Address();
                $userAdress->addUserAddress($city, $street, $zipCode, $state, $userId);
                $this->_helper->redirector('show', 'user', 'default', array('id' => $userId));
            } else {
                $form->populate($formData); //Pokud zadaná data nejsou validní, pak jimi naplníme formulář a znovu ho zobrazíme.
            }
        }
    }

    public function editAction()
    {
        $form = new Application_Form_Address(); //instance (odkaz na form registr.php)
        $form->submit->setLabel('Uložit'); //popisek odesílacího tlačítka
        $this->view->Address = $form; //předání view         

        if ($this->getRequest()->isPost()) { //jestli to není post ale get tak to vykreslí data z databáze
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $person = Zend_Auth::getInstance()->getIdentity(); //získání údajů aktuálního příhlášeného uživatele
                $userId = $person->id;
                $id = $form->getValue('id');
                $city = $form->getValue('City');            
                $street = $form->getValue('Street');
                $zipCode = $form->getValue('ZipCode');
                $state = $form->getValue('State'); 
                
                $user = new Application_Model_DbTable_Address();
                $user->updateUserAddress($id, $city, $street, $zipCode, $state);
                $this->_helper->redirector('show', 'user', 'default', array('id' => $userId));
            }
        } else {
            $user = new Application_Model_DbTable_Address();
            $selecteduser = $this->_getParam('id', 0); // zjištění id
            $data = $user->findPrimaryKey($selecteduser);
            $form->populate($data->toArray());
        }
    }


}





