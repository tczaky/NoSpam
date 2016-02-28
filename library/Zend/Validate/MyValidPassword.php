<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MyValid_Password
 *
 * @author T.Czaky
 */

require_once 'Zend/Validate/Abstract.php';

/**
 * @see Zend_Validate_Hostname
 */
require_once 'Zend/Validate/Hostname.php';


class Zend_Validate_MyValidPassword extends Zend_Validate_Abstract{
    const LENGTH = 'length';
    const UPPER  = 'upper';
    const LOWER  = 'lower';
    const DIGIT  = 'digit';
 
    protected $_messageTemplates = array(
        self::LENGTH => "Musí být minimálně 8 znaků dlouhé",
        self::UPPER  => "Musí obsahovat minimálně 1 velké písmeno",
        self::LOWER  => "Musí obsahovat minimálně malé písmeno",
        self::DIGIT  => "Musí obsahovat minimálně 1 číslo"
    );
 
    public function isValid($value)
    {
        $this->_setValue($value);
 
        $isValid = true;
 
        if (strlen($value) < 8) {
            $this->_error(self::LENGTH);
            $isValid = false;
        }
 
        if (!preg_match('/[A-Z]/', $value)) {
            $this->_error(self::UPPER);
            $isValid = false;
        }
 
        if (!preg_match('/[a-z]/', $value)) {
            $this->_error(self::LOWER);
            $isValid = false;
        }
 
        if (!preg_match('/\d/', $value)) {
            $this->_error(self::DIGIT);
            $isValid = false;
        }
 
        return $isValid;
    }
}
