<?php

class Application_Form_Searchcenter extends Zend_Form
{

    public function init()
    {
        $searchCenterQueryBox = new Zend_Form_Element_Text('searchCenterQueryBox');
        $this->addElement($searchCenterQueryBox);

        $searchCenterOption = new Zend_Form_Element_Select('searchCenterOption');
        $searchCenterOption->addMultiOptions(array('1'=>'ATC code','2'=>'Name'));
        $this->addElement($searchCenterOption);

        $submit = new Zend_Form_Element_Submit('centerSearchsubmit');
        $submit->setLabel('Search');
        $this->addElement($submit);

        /**
          * Starting Decorators
          */
        $this->setElementDecorators(array(
            'ViewHelper'
            ));
    }


}

