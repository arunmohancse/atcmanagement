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
    /**
     *
     * @param String $categoryName
     * @return string 
     */
    public function addCategory($categoryName)
    {
        $select = $this->select('name')->where('name=?',$categoryName);
        $nameStatus = $this->fetchRow($select);
        if($nameStatus OR $categoryName==''){
            
            $status = 'DUPLICATE_NAME'; 
            return($status);
        }
        else{
            $data = array(
                     'name'=>$categoryName
            );
            $status = $this->insert($data);
            return($status);
        }
    }

}

