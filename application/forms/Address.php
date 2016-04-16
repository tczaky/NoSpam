<?php

class Application_Form_Address extends Zend_Form
{

    public function init()
    {
        $this->setName('Address') //název formuláře
             ->setMethod('post');

        $id = new Zend_Form_Element_Hidden('id'); //použij pokud bude id a nechceš ho zobrazovat
        $id->addFilter('Int'); //Chceme aby to bylo pouze čísla
       

        $city = new Zend_Form_Element_Text('City');
        $city->setLabel('Město')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator('regex', false, array('/^[a-zA-Z]+/'))
                 ->setAttrib('class', 'form-control');


        $street = new Zend_Form_Element_Text('Street');
        $street->setLabel('Ulice')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator('regex', false, array('/^[a-zA-Z]+/'))
                 ->setAttrib('class', 'form-control');


        $zipCode = new Zend_Form_Element_Text('ZipCode');
        $zipCode->setLabel('PSČ')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('Int')
                ->addValidator('NotEmpty')
                ->addValidator('Digits')
                ->setDescription('Poštovní směrovací číslo musí být zadáno ve formátu 73514')
                ->setAttrib('placeholder', '73514')
                 ->setAttrib('class', 'form-control');
        

        $state = new Zend_Form_Element_Text('State');
        $state->setLabel('Stát')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                 ->setAttrib('class', 'form-control');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class', 'btn btn-success');   //nastavení html tagů pro css k danému prvku


        $this->addElements(array($id, $city, $street, $zipCode, $state, $submit));
    }


}

