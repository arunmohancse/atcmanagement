<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDb(){
         $config=$this->getOptions();

         $dbConfig=new Zend_Config($config['resources']['db']);
         $db = Zend_Db::factory($dbConfig);
         Zend_Db_Table::setDefaultAdapter($db);
         Zend_Registry::set('db',$db);
     }

     protected function _initPath(){
         $this->bootstrap('view');
         $view = $this->getResource('view');
         $view->addHelperPath(APPLICATION_PATH.'/views/helpers','Application_View_Helper');
     }

}

