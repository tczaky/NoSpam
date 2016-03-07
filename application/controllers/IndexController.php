<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() { //will take care of showing the login form and processing the login process.
        if (Zend_Auth::getInstance()->hasIdentity()) {  //pokud bude v session tak ho preskočí uvodní login
            $this->_redirect('user/list-of-users');
        }

        $form = new Application_Form_Login();
        $form->submit->setLabel('Přihlásit');
        $this->view->LoginForm = $form;


        //kontrola zda je formular odeslany a platny
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            //autentizacni adapter
            $adapter = new Zend_Auth_Adapter_DbTable(
                    Zend_Db_Table_Abstract::getDefaultAdapter(), //musis nastavit v aplication ini defaultni adapter
                    'users', 'Email', 'Password', 'sha1(?)'    //predani tabulky, emailu a hesla
            );
            //naplneni adapteru udaji ktere uzivatel zadal
            $adapter->setIdentity($form->getValue('Email'));
            $adapter->setCredential($form->getValue('Password'));

            //prihlaseni pomoci Singletonu -> zend auth
            $result = Zend_Auth::getInstance()->authenticate($adapter);
            if (!$result->isValid()) {//pokud jsou data spatne
                //$this->_redirect('index/index');
                $errorMessage = "Špatné heslo nebo email";
            } else {
                $storage = Zend_Auth::getInstance()->getStorage();
                $storage->write(
                        $adapter->getResultRowObject(null, array('Password')) //vraci vsechno krome hesla
                );
                $this->_redirect('user/list-of-users');
                // $this->_helper->FlashMessenger('Successful Login'); //proč nefunguje?????
            }$this->view->errorMessage = $errorMessage;
        }
    }

    public function logoutAction() {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('index/index');
    }

}
