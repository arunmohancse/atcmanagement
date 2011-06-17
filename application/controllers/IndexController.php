<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

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
             }
        }
    }
       public function logoutAction()
         {
           // clear everything - session is cleared also!
           Zend_Auth::getInstance()->clearIdentity();
           $this->_helper->redirector('Index','index');
         }
    
}



