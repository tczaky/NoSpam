<?php

class Application_Form_Register extends Zend_Form {

    public function init() {


        $this->setName('user') //název formuláře
             ->setMethod('post');

        $id = new Zend_Form_Element_Hidden('id'); //použij pokud bude id a nechceš ho zobrazovat
        $id->addFilter('Int'); //Chceme aby to bylo pouze číslo


        $accessLevel = new Zend_Form_Element_Select('AccessLevel');
        $accessLevel->setLabel('Úroveň přístupu')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');

        $accessLevel->setMultiOptions(array(
            'Admin' => 'Admin',
            'Reseler' => 'Reseler',
            'Client' => 'Client',
            'End user' => 'End user'
        ));

        $email = new Zend_Form_Element_Text('Email');
        $email->setLabel('Email')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator('EmailAddress', true)
                ->setAttrib('placeholder', 'user@hostname.xx')
                ->addValidator('Db_NoRecordExists', true, array('table' => 'users', 'field' => 'email'))
                ->getValidator('Db_NoRecordExists')->setMessage('Tento email už je registrován');



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

        $firstName = new Zend_Form_Element_Text('FirstName');
        $firstName->setLabel('Jméno')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator('regex', false, array('/^[a-zA-Z]+/'));


        $lastName = new Zend_Form_Element_Text('LastName');
        $lastName->setLabel('Příjmení')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator('regex', false, array('/^[a-zA-Z]+/'));


        $telNumber = new Zend_Form_Element_Text('TelNumber');
        $telNumber->setLabel('Telefonní číslo')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('Int')
                ->addValidator('NotEmpty')
                ->addValidator('Digits')
                ->setDescription('Telefonní číslo musí být zadáno ve formátu 123456789')
                ->setAttrib('placeholder', '420XXXXXXXXX');

        $comment = new Zend_Form_Element_Textarea('Comment');
        $comment->setLabel('Komentář')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbtn');   //nastavení html tagů pro css k danému prvku


        $this->addElements(array($id, $accessLevel, $email, $password, $confirmPassword, $firstName, $lastName, $telNumber, $comment, $submit));
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
