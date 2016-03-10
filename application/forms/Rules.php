<?php

class Application_Form_Rules extends Zend_Form
{

    public function init()
    {
        $this->setName('rules')
             ->setMethod('post');
        
        $id = new Zend_Form_Element_Hidden('id'); //použij pokud bude id a nechceš ho zobrazovat
        $id->addFilter('Int'); //Chceme aby to bylo pouze číslo
        

        $name = new Zend_Form_Element_Text('Name');
        $name->setLabel('Pravidlo')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('placeholder', 'Pravidlo');
        
        $description = new Zend_Form_Element_Textarea('Description');
        $description->setLabel('Popis')
                ->setAttrib('placeholder', 'Komentář')                
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty');
        
        

       
        $submit = new Zend_Form_Element_Submit('submit');
        
       $this->addElements(array($id, $name, $description, $submit));
    }


}

