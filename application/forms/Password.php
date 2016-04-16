<?php

class Application_Form_Password extends Zend_Form
{

    public function init()
    {
        $password = new Zend_Form_Element_Password('Password');
        $password->setLabel('Heslo')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setDescription('Heslo musí obsahovat mininálně 8 znaků z toho minimálně jedno velké písmeno a číslo')
                ->setRequired(true)
                ->addValidator('MyValidPassword', true);


        $confirmPassword = new Zend_Form_Element_Password('ConfirmPassword');
        $confirmPassword->setLabel('Heslo znovu')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator('Identical');
    }
      //Validace shody hesel
    public function isValid($data) {
        $confirmPassword = $this->getElement('ConfirmPassword');
        $confirmPassword->getValidator('Identical')
                ->setToken($data['Password'])
                ->setMessage('Hesla se neshodují!');
        return parent::isValid($data);
    }


}

