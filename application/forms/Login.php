<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        $this->setName('login')
             ->setMethod('post');
        

        $email = new Zend_Form_Element_Text('Email');
        $email->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator('EmailAddress', true)
                ->setAttrib('placeholder', 'Email')
                ->setAttrib('class', 'form-control');
        
        $password = new Zend_Form_Element_Password('Password');
        $password->setAttrib('placeholder', 'Heslo')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setRequired(true)
                ->setAttrib('class', 'form-control');

       
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class', 'btn btn-success pull-right green-btn');
        
       $this->addElements(array($email, $password, $submit));
       
        $this->addDecorator('FormElements'); //This add the form elements first
        $this->addDecorator('Form'); //This removes <dt> and adds the form around the <ul>
        
        //Time to remove the <dt> and add the <li>
        $this->setElementDecorators(array(
            array('ViewHelper'), //This is important otherwise you won't see your <input> elements
            array('Label'),  //We want the label
            array('Errors') , //We want the errors too
        ));

        /* Submit elements don't need a label since we added a label on setElementDecorators()
           on <input> elements (including the submit) */
        $submit->setDecorators(array('ViewHelper'));
    }

    
}

