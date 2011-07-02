<?php

class Application_Model_DbTable_Students extends Zend_Db_Table_Abstract
{

    protected $_name = 'students';

    /*Allow administrator to add student details
     * @param type
     * $regno :- student reg no.
     * $name :-  student name.
     * $atc_code :- center code in which student joined.
     * $district :- student district.
     * $course_code :- Student course code.
     * $date_of_join :- Date student joined.
     */
    public function addStudent($regno,$name,$sex,$atc_code,$district,$course_code,$date_of_join)
    {
        $stud_details = array(
            'register_no' => $regno,
            'name' => $name,
            'sex' => $sex,
            'atc_code' => $atc_code,
            'district' => $district,
            'course_code' => $course_code,
            'date_of_join' => $date_of_join
            );
       $this->insert($stud_details);
    }

    /*Allow administrator to list student details
     *  @param none
     *  @return type stud_list
     */
   public function listStudents()
    {
        $select = $this->select()
                ->from('students')
                ->order('register_no asc');
        $list = $this->fetchAll($select);
        if($list)
        {
            return $list;
        }
        else {
                return NULL;
             }

    }

    /*Allow administrator to sort student by parameter
     *  @param type
     *  $sort_by: sort by column
     *  $order: ASC or DESC
     *  @return type stud_list
     */
    public function sortStudents($sort_by,$order)
    {
        $order_by=$sort_by.' '.$order;
        
        $select = $this->select()
                ->from('students')
                ->order($order_by);
        echo $select;
        //exit;
        $list = $this->fetchAll($select);
        if($list)
        {
           
            return $list;
        }
        else {
                return NULL;
             }
    }
    
    /*Allow administrator to retrieve student details via reg no
     * @param type
     * $regno :- student reg no.
     * $formdata: updated data.
     *
     */
    
    public function editStudent($regno,$formdata)
    {
        $this->update($formdata, 'register_no= '. (int)$regno);
    }

    /*Allow administrator to retrieve student details via reg no
     * @param type
     * $regno :- student reg no.
     * return value $row
     */
    public function retrieveStudentByRegNo($regno)
    {
        $regno=(int)$regno;
        $row=$this->fetchRow('register_no = '. $regno);
        if($row)
        return $row->toArray();
        else
            return NULL;
    }

}

