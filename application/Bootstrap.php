<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initDefaultEmailTransport() {
        $emailConfig = $this->getOption('email');
        $smtpHost = $emailConfig['transportOptionsSmtp']['host'];
        unset($smtpHost);

        $mailTransport = new Zend_Mail_Transport_Smtp('smtp.seznam.cz', $emailConfig['transportOptionsSmtp']);
        Zend_Mail::setDefaultTransport($mailTransport);
    }

}
