<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * @Description Login authentication
     */
    public function indexAction()
    {
        $form = new Application_Form_Login();
        $this->view->form = $form;

        $db = Zend_Registry::get('db');
        $auth = Zend_Auth::getInstance();
        $request = $this->getRequest();
        if($request->isPost())
        {
            if($form->isValid($request->getPost()))
            {
                $adapter = new Zend_Auth_Adapter_DbTable(
                        $db,
                        'user',
                        'username',
                        'password'
                        );
                $adapter->setIdentity($form->getValue('username'));
                $adapter->setCredential($form->getValue('password'));
                $result=$auth->authenticate($adapter);

                if($result->isValid())
                {
                    //$this->_forward('Index','home');
                    $this->_helper->redirector('Index','home');
                }
                else {
                 $this->view->error = "Invalid username or password" ;
                }
             } //End If isvalid(POST)
        
    
         }//End If POST
    }
    public function logoutAction()
    {
           // clear everything - session is cleared also!
           Zend_Auth::getInstance()->clearIdentity();
           $this->_helper->redirector('Index','index');
    }

    public function testAction()
    {
        $date = new Zend_Date('2011-02-10','yyyy-MM-dd');
        echo $date->toString('yyyy-MM-dd');exit;
        $date->add('1', Zend_Date::MONTH);
        $date->add('1', Zend_Date::DAY);
        //echo $date->getIso('yyyy-mm-dd'); exit;
        $remainderDate =  $date->toString('yyyy-MM-dd');
        $centers = new Application_Model_DbTable_Centers();
        $remainderDetails = $centers->remainderForRegistration($remainderDate);
        if($remainderDetails->toArray())
        {
            echo "<pre>"; print_r($remainderDetails);exit;
        }
        else{
            echo "There is no notification.";exit;
        }
    }


}







