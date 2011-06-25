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
     * @param integer $limit specify how many rows should be get, default is all rows 
     * @return array rows 
     */
    public function getCenterDetails($limit=20)
    {
        $select = $this->select()
                       ->from('centers')
                       ->setIntegrityCheck(false)
                       ->join('center_category AS category','centers.category_code=category.code',array('category.name AS categoryname'))
                       ->order('centers.code asc')
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
    
    /**
     *
     * @param string $code
     * @param string $name
     * @param string $address
     * @param string $district
     * @param string $state
     * @param integer $pin
     * @param integer $category
     * @param Date $regDate
     * @return string $status
     */
    public function addCenter($code,$name,$address,$district,$state,$pin,$category,$regDate)
    {
        $select = $this->select('code')->where('code=?',$code);
        $codeStatus = $this->fetchRow($select);
        if($codeStatus OR $code==''){
            
            $status = 'INVALID_PRIMARYKEY'; 
            return($status);
        }
        else{
                 
            $data = array(
                    'code'=>$code,'name'=>$name,'address'=>$address,'district'=>$district,
                    'state'=>$state,'pincode'=>$pin,'category_code'=>$category,
                    'registration_date'=>$regDate
            );
            $status = $this->insert($data);
            return($status);
        }
    }
}

