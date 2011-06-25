<?php

class Application_Model_DbTable_Centercategory extends Zend_Db_Table_Abstract
{

    protected $_name = 'center_category';
    /**
     *
     * @return type array
     */
    public function getCategory()
    {
        $select = $this->select();
        $value = $this->fetchAll($select);
        //echo "<pre>";print_r($value); exit;
        return($value->toArray());
    }

}

