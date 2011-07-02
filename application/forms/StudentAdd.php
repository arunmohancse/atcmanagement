<?php

class Application_Form_StudentAdd extends Zend_Form
{

    public function init()
    {
        $register_no = new Zend_Form_Element_Text('register_no');
        $register_no->setLabel('Register No : ')
                    ->setRequired(true)->addValidator('NotEmpty', true);
        $this->addElement($register_no);

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name : ')
                ->setRequired(true)->addValidator('NotEmpty', true);
        $this->addElement($name);

        $sex = new Zend_Form_Element_Select('sex');
        $sex->setLabel('Sex: ')
              ->setMultiOptions(array('male'=>'Male', 'female'=>'Female'))
              ->setRequired(true)->addValidator('NotEmpty', true);
        $this->addElement($sex);
        $atc_code = new Zend_Form_Element_Text('atc_code');
        $atc_code->setLabel('Atc Code : ')
                ->setRequired(true)->addValidator('NotEmpty', true);
        $this->addElement($atc_code);

        $district = new Zend_Form_Element_Text('district');
        $district->setLabel('District : ')
                ->setRequired(true)->addValidator('NotEmpty', true);
        $this->addElement($district);

        $course_code = new Zend_Form_Element_Text('course_code');
        $course_code->setLabel('Course Code : ')
                ->setRequired(true)->addValidator('NotEmpty', true);
        $this->addElement($course_code);

        $date_of_join = new Zend_Form_Element_Text('date_of_join');
        $date_of_join->setLabel('Date Of Join : ')
                ->setRequired(true)->addValidator('NotEmpty', true);
        $this->addElement($date_of_join);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Submit');
        $this->addElement($submit);

    }


}

