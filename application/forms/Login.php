<?php
/**
*@copyright 
*@author ArunMohan
*@Created on : 11 Jun, 2011, 9:29:58 AM
*@Description: login form, 
*/
class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        $username = $this->addElement('text', 'username', array(
                    'filters'    => array('StringTrim', 'StringToLower'),
                    'validators' => array(
                    'Alpha',
                    array('StringLength', false, array(3, 20)),
                  ),
            'required'   => true,
            'label'      => 'username:',
        ));

        $password = $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                'Alnum',
                array('StringLength', false, array(4, 20)),
            ),
            'required'   => true,
            'label'      => 'password:',
        ));

        $login = $this->addElement('submit', 'login', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Login',
        ));

        // We want to display a 'failed authentication' message if necessary;
        // we'll do that with the form 'description', so we need to add that
        // in decorator.
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }


}

