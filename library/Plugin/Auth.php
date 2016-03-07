<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Plugin_Auth extends Zend_Controller_Plugin_Abstract{
   public function preDispatch(Zend_Controller_Request_Abstract $request) {
       
       //die('preDispatch()'); zkouška zda plugin funguje
       if(!$this->isRestrictedRequest($request)){
           return;
       }
       if(!Zend_Auth::getInstance()->hasIdentity()){
           $redirect = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
           $redirect->gotoUrlAndExit('index/index');
       }
      
   }   
   //metoda, která kontroluje zda požadavek na stránku má být chráněna heslem tedy přihlášením
   private function isRestrictedRequest($request) {
       //vytazeni controleru a action
       $controller = $request->getControllerName();
       $action = $request->getActionName();
       
       //pokud bude
       if($controller == 'index' && in_array($action, array('index'))){
           return false;
       }else{
           return true;
       }
       
   }
}












