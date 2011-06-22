<?php

class Application_Form_Addcenter extends Zend_Form
{

    public function init()
    {
        $atcCode = new Zend_Form_Element_Text('atcCode');
        $atcCode->setLabel('ATC code :');
        $this->addElement($atcCode);

        $atcName = new Zend_Form_Element_Text('atcName');
        $atcName->setLabel('ATC name :');
        $this->addElement($atcName);

        $atcDistrict = new Zend_Form_Element_Text('atcDistrict');
        $atcDistrict->setLabel('District :');
        $this->addElement($atcDistrict);

        $atcState = new Zend_Form_Element_Text('atcState');
        $atcState->setLabel('State');
        $this->addElement($atcState);

        $atcPincode = new Zend_Form_Element_Text('atcPincode');
        $atcPincode->setLabel('PIN code');
        $this->addElement($atcPincode);

        $atcCategoryCode = new Zend_Form_Element_Text('atcCategoryCode');
        $atcCategoryCode->setLabel('Category code');
        $this->addElement($atcCategoryCode);

        $atcRegDate = new Zend_Form_Element_Text('atcRegDate');
        $atcRegDate->setLabel('RegDate');
        $this->addElement($atcRegDate);

        $atcExpDate = new Zend_Form_Element_Text('atcExpDate');
        $atcExpDate->setLabel('ExpDate');
        $this->addElement($atcExpDate);


        
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
          array('ViewScript', array('script' => 'center/addcenter.phtml'))));

    }


}

