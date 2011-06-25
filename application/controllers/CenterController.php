<?php

class CenterController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        if(!Zend_Auth::getInstance()->hasIdentity())
        {
            $this->_helper->redirector('Index','index');
        }
        else{
            
            $centers = new Application_Model_DbTable_Centers();
            $centerDetails = $centers->getCenterDetails();
            $centerDetails = $centerDetails->toArray();
            $this->view->centerDetails = $centerDetails;
        }//End else
        
    }

    public function addcenterAction()
    {
        $form = new Application_Form_Addcenter();
        $centerCategory = new Application_Model_DbTable_Centercategory();
        $options = $centerCategory->getCategory();
        foreach ($options AS $option)
        {
            $form->atcCategoryCode->addMultioption($option['code'],$option['name']);
        }
        $this->view->form = $form;
    }


}



