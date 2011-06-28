<?php

class HomeController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }
    public function indexAction()
    {
        // action body
        if(!Zend_Auth::getInstance()->hasIdentity())
        {
            $this->_helper->redirector('Index','index');
        }
        else{
            $date = new Zend_Date();
            $date->add('1', Zend_Date::MONTH);
            $date->add('1', Zend_Date::DAY);
            $date->sub('1', Zend_Date::YEAR);
            //echo $date->getIso('yyyy-mm-dd'); exit;
            $remainderDate =  $date->toString('yyyy-MM-dd');
            $centers = new Application_Model_DbTable_Centers();
            $remainderDetails = $centers->remainderForRegistration($remainderDate);
            $this->view->remainderDetails = $remainderDetails;
        }
    }
}

