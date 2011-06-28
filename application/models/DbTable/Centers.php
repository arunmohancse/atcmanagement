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
     * @param string $code to select row but it is optional, select all rows as default
     * @return array rows 
     */
    public function getCenterDetails($code=NULL)
    {
        if($code==NULL)
        {
            $where = 1;
        }
        else{
            $where = $this->getAdapter()->quoteInto('centers.code = ?',$code);
        }

        $select = $this->select()
                       ->from('centers')
                       ->setIntegrityCheck(false)
                       ->join('center_category AS category','centers.category_code=category.code',array('category.name AS categoryname'))
                       ->order('centers.code asc')
                       ->where($where);
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
        if($code==''){
            $status = 'INVALID_PRIMARYKEY'; 
            return($status);
        }
        else{
                 
            $data = array(
                    'code'=>$code,'name'=>$name,'address'=>$address,'district'=>$district,
                    'state'=>$state,'pincode'=>$pin,'category_code'=>$category,
                    'registration_date'=>$regDate
            );
            try{
                $status = $this->insert($data);
            }
            catch (Exception $e)
            {
                $status = 'INVALID_PRIMARYKEY';
            }
            return($status);
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
    public function updateCenter($code,$name,$address,$district,$state,$pin,$category,$regDate)
    {
        $data = array(
                    'name'=>$name,'address'=>$address,'district'=>$district,
                    'state'=>$state,'pincode'=>$pin,'category_code'=>$category,
                    'registration_date'=>$regDate
            );
        $where = $this->getAdapter()->quoteInto('centers.code = ?',$code);
        $status = $this->update($data,$where);
        return($status);
    }

    /**
     *
     * @param string $query
     * @param integer $option
     * @return Object
     */
    public function searchCenter($query,$option)
    {
        if($option==1)
        {
            if($query==NULL)
                  $searchCriteria = 1;
            else
                  $searchCriteria = $this->getAdapter()->quoteInto('centers.code = ?',$query);
        }
        else
        {
            $searchCriteria = $this->getAdapter()->quoteInto('centers.name LIKE ?',$query.'%');
        }
        $select = $this->select()
                       ->from('centers')
                       ->setIntegrityCheck(false)
                       ->join('center_category AS category','centers.category_code=category.code',array('category.name AS categoryname'))
                       ->order('centers.code asc')
                       ->where($searchCriteria);
                       
        //echo $select;exit;
        $value = $this->fetchAll($select);
        if($value->toArray())
        {
            return($value);
        }
        else {
               return NULL;
        }
    }

    /**
     *
     * @param DATE $remainderDate
     * @return Object
     */
    public function remainderForRegistration($remainderDate)
    {
        //echo "entry"; exit;
        $select  = $this->select('name')->where('registration_date<?',$remainderDate);
        $rows = $this->fetchAll($select);
        //echo "<pre>"; print_r($rows);exit;
        return $rows;
    }
}

