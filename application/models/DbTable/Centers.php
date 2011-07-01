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
     * @return string select query
     */
    public function getCenterDetailsSelectQuery($code=NULL)
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
     * @param String $code
     * @param String $name
     * @param String $address
     * @param String $district
     * @param String $state
     * @param String $pin
     * @param Integer $category
     * @param Date $regDate
     * @param String $contactNumber1
     * @param String $contactNumber2
     * @param String $contactNumber3
     * @param String $contactNumber4
     * @return String
     */
    public function addCenter($code,$name,$address,$district,$state,$pin,$category,$regDate,$contactNumber1,$contactNumber2,$contactNumber3,$contactNumber4)
    {
        if($code==''){
            $status = 'INVALID_PRIMARYKEY'; 
            return($status);
        }
        else{
                 
            $data = array(
                    'code'=>$code,'name'=>$name,'address'=>$address,'district'=>$district,
                    'state'=>$state,'pincode'=>$pin,'category_code'=>$category,
                    'registration_date'=>$regDate,
                    'contact_number1'=>$contactNumber1,'contact_number2'=>$contactNumber2,'contact_number3'=>$contactNumber3,
                    'contact_number4'=>$contactNumber4
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
    public function updateCenter($code,$name,$address,$district,$state,$pin,$category,$regDate,$contactNumber1,$contactNumber2,$contactNumber3,$contactNumber4)
    {
        $data = array(
                    'name'=>$name,'address'=>$address,'district'=>$district,
                    'state'=>$state,'pincode'=>$pin,'category_code'=>$category,
                    'registration_date'=>$regDate,
                    'contact_number1'=>$contactNumber1,'contact_number2'=>$contactNumber2,'contact_number3'=>$contactNumber3,
                    'contact_number4'=>$contactNumber4
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
}

