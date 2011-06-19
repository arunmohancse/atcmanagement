<?php
/**
 * @author ArunMohan
 * @copyright company name
 * @description Model class for table centers..
 * 
 */
class Application_Model_DbTable_Centers extends Zend_Db_Table_Abstract
{

    protected $_name = 'centers';
    
    /**
     * 
     * @param type $limit specify how many rows should be get, default is all rows 
     * @return rows as an array
     */
    public function getCenterDetails($limit=20)
    {
        $select = $this->select()
                       ->from('centers')
                       ->setIntegrityCheck(false)
                       ->join('center_category AS category','centers.category_code=category.code',array('category.name AS categoryname'))
                       ->limit($limit);
        //echo $select;exit;
        $value = $this->fetchAll($select);
        if($value)
        {
            return($value);
        }
        else {
               return NULL;  
        }
    }


}

