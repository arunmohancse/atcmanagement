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

}

