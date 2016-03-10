<?php

class RulesBlackController extends Zend_Controller_Action
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
        $form = new Application_Form_Rules(); //instance (odkaz na form registr.php)
        $form->submit->setLabel('Přidat'); //popisek odesílacího tlačítka
        $this->view->RulesForm = $form; //předání view
        
        if ($this->getRequest()->isPost()) {  //Pokud metoda isPost() na objektu requestu vrací true, tak byl formulář odeslán
            $formData = $this->getRequest()->getPost(); //pomocí getPost() získáme data
            if ($form->isValid($formData)) {    //pomocí isValid() ověříme, že jsou data správná
                $name = $form->getValue('Name');
                $description = $form->getValue('Description');  
                $items = new Application_Model_DbTable_Black();
                $items->addRule($name, $description);             

                $this->_helper->redirector('list-of-rules'); //přesměrování na list-of-users
            } else {
                $form->populate($formData); //Pokud zadaná data nejsou validní, pak jimi naplníme formulář a znovu ho zobrazíme.
            }
        }
    }

    public function editAction()
    {
        $form = new Application_Form_Rules(); //instance (odkaz na form registr.php)
        $form->submit->setLabel('Uložit'); //popisek odesílacího tlačítka
        $this->view->RulesForm = $form; //předání view         

        if ($this->getRequest()->isPost()) { //jestli to není post ale get tak to vykreslí data z databáze
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = $form->getValue('id');
                $name = $form->getValue('Name');
                $description = $form->getValue('Description'); 
                
                $item = new Application_Model_DbTable_Black();
                $item->updateRule($id, $name, $description);
                $this->_helper->redirector('list-of-rules');
            }
        } else {
            $item = new Application_Model_DbTable_Black();
            $selectitem = $this->_getParam('id', 0); // zjištění id
            $data = $item->findPrimaryKey($selectitem);
            $form->populate($data->toArray());
        }
    }

    public function deleteAction() {
        if ($this->getRequest()->isPost()) {    //zjištění zda se má zobrazit potvrzovací form nebo provést mazání
            $del = $this->getRequest()->getPost('del'); //získá se hodnota z view jestli ano či ne ('del' je hodnota parametru name z view]
            if ($del == 'Ano') {
                $item = new Application_Model_DbTable_Black();
                $selectedItem = $item->findPrimaryKey($this->getParam('id'));
                $selectedItem->delete();
                $this->_helper->redirector('list-of-rules');
            }
            if ($del == 'Ne') {
                $this->_helper->redirector('list-of-rules');
            }
        } else {
            $id = $this->_getParam('id', 0);    //pomocí getparam zjistím id
            $item = new Application_Model_DbTable_Black();   //instance do modelu abych poté zjistil záznam s uživatelem
            $this->view->rule = $item->findPrimaryKey($id); //předám view
        }
    }

    public function listOfRulesAction()
    {
        $rulesTBL = new Application_Model_DbTable_Black(); //propojeni s modelem pres autoloader v bootstrapu...je to podle adresarove slozky application/model/dbtable/user
        $this->view->rule = $rulesTBL->fetchAll(); //fetchall metoda, která vypíše všechny údaje z tabulky
    }


}











