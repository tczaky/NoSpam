<?php

class Application_Form_Register extends Zend_Form {

    public function init() {


        $this->setName('Register') //název formuláře
                ->setMethod('post');

        $id = new Zend_Form_Element_Hidden('id'); //použij pokud bude id a nechceš ho zobrazovat
        $id->addFilter('Int'); //Chceme aby to bylo pouze číslo


        $accessLevel = new Zend_Form_Element_Select('AccessLevel');
        $accessLevel->setLabel('Úroveň přístupu')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'form-control');

        $accessLevel->setMultiOptions(array(
            'Admin' => 'Admin',
            'Reseler' => 'Reseler',
            'Client' => 'Client',
            'End user' => 'End user'
        ));

        $email = new Zend_Form_Element_Text('Email');
        $email->setLabel('Email')
                ->setRequired(true)
                ->setAttrib('class', 'form-control')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator('EmailAddress', true)
                ->setAttrib('placeholder', 'user@hostname.xx')
                ->addValidator('Db_NoRecordExists', true, array('table' => 'users', 'field' => 'email'))
                ->getValidator('Db_NoRecordExists')->setMessage('Tento email už je registrován');
               

        $password = new Zend_Form_Element_Hidden('Password');
        $password
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->removeDecorator('label')
                ->removeDecorator('HtmlTag')
                ->setAttrib('class', 'form-control');


        $confirmPassword = new Zend_Form_Element_Hidden('ConfirmPassword');
        $confirmPassword
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->removeDecorator('label')
                ->removeDecorator('HtmlTag')
                ->setAttrib('class', 'form-control');
        
        $creator = new Zend_Form_Element_Hidden('Creator');
        $creator
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->removeDecorator('label')
                ->removeDecorator('HtmlTag');


        $contractNumber = new Zend_Form_Element_Text('ContractNumber');
        $contractNumber->setLabel('Číslo smlouvy')
                ->setRequired(true)
                ->addFilter('StripTags')                
                ->addValidator('NotEmpty')
                ->addValidator('Digits')
                ->setAttrib('placeholder', '123456789')
                ->setAttrib('class', 'form-control');

        $comment = new Zend_Form_Element_Textarea('Comment');
        $comment->setLabel('Komentář')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'form-control')
                ->setOptions(array('cols' => '4', 'rows' => '4'));

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class', 'btn btn-success');   //nastavení html tagů pro css k danému prvku


        $this->addElements(array($id, $accessLevel, $email, $password, $confirmPassword, $creator, $contractNumber, $comment, $submit));
    }
}
