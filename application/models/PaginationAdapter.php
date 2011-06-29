<?php
//require_once 'Zend/Paginator/Adapter/Interface.php';
class Application_Model_PaginationAdapter implements Zend_Paginator_Adapter_Interface
{
    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;

    /**
     * @param Zend_Db_Adapter_Abstract $db
     */
    public function __construct(Zend_Db_Adapter_Abstract $db)
    {
        $this->_db = $db;
    }

    /**
     * @implements Zend_Paginator_Adapter_Interface
     * @return integer
     */
    public function count()
    {
        $sql = $this->_db->select()
                 ->from('record','COUNT(*)');
        //echo $sql;exit;
        //$count = $this->_db->fetchOne($sql);
        //echo "<pre>";print_r($count); exit;
        return (int)$this->_db->fetchOne($sql);
    }

    /**
     * @implements Zend_Paginator_Adapter_Interface
     * @param  integer $offset
     * @param  integer $itemCountPerPage
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        //echo $offset . "&nbsp;" . $itemCountPerPage; exit;
        $sql = $this->_db->select()
                 ->from('record')
                 ->limit($itemCountPerPage,$offset);
//            (int)$offset . ', ' . (int)$itemCountPerPage;
        //echo $sql;
        $value = $this->_db->fetchAll($sql);
        //echo "<pre>";print_r($value); exit;
        return $this->_db->fetchAll($sql);
    }
}



