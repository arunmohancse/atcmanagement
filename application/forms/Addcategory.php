<?php

class Application_Form_Addcategory extends Zend_Form
{

    public function init()
    {
        
        $categoryName = new Zend_Form_Element_Text('categoryName');
        $categoryName->addFilter('StringTrim')
                     ->setRequired(TRUE);
                     
        $this->addElement($categoryName);
        
        $categoryAddButton = new Zend_Form_Element_Button('categoryAddButton');
        $categoryAddButton->setLabel('Add');
        $this->addElement($categoryAddButton);
                
         /**
          * Starting Decorators
          */
        $this->setElementDecorators(array(
            'ViewHelper'
            ));
        
        /**
         *
         * the above form was in the view script "home/index.phtml",
         * you could then attach it to your form as follows:
         *
         */
          $this->setDecorators(array(
          array('ViewScript', array('script' => 'center/index.phtml'))));
    }


}

