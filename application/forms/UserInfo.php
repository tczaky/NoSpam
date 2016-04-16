<?php

class Application_Form_UserInfo extends Zend_Form
{

    public function init()
    {
         $this->setName('UserInfo') //název formuláře
             ->setMethod('post');

        $id = new Zend_Form_Element_Hidden('id'); //použij pokud bude id a nechceš ho zobrazovat
        $id->addFilter('Int'); //Chceme aby to bylo pouze čísla
       

        $firstName = new Zend_Form_Element_Text('FirstName');
        $firstName->setLabel('Jméno')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator('regex', false, array('/^[a-zA-Z]+/'))
                ->setAttrib('class', 'form-control')                ;


        $lastName = new Zend_Form_Element_Text('LastName');
        $lastName->setLabel('Příjmení')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator('regex', false, array('/^[a-zA-Z]+/'))
                ->setAttrib('class', 'form-control');


        $telNumber = new Zend_Form_Element_Text('TelNumber');
        $telNumber->setLabel('Telefonní číslo')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('Int')
                ->addValidator('NotEmpty')
                ->addValidator('Digits')
                ->setDescription('Telefonní číslo musí být zadáno ve formátu 123456789')
                ->setAttrib('placeholder', '420XXXXXXXXX')
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


        $this->addElements(array($id, $firstName, $lastName, $telNumber, $comment, $submit));
    }
}

