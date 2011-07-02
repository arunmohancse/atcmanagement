<?php

class StudentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
       $list_details=new Application_Model_DbTable_Students();
       $list_details->listStudents();
    }

    public function sortstudAction()
    {
        $sortstud=new Application_Model_DbTable_Students();
        $order='ASC';
        $sort_by='name';
        $sorted_list=$sortstud->sortStudents($sort_by,$order);
    }

    public function addstudAction()
    {
        if(!Zend_Auth::getInstance()->hasIdentity())
        {
            $this->_helper->redirector('Index','index');
        }
        else{
        $stud_form = new Application_Form_StudentAdd();
        $this->view->stud_form = $stud_form;

        if ($this->getRequest()->isPost())
                {
                    $formData = $this->getRequest()->getPost();

                    if ($stud_form->isValid($formData))
                        {
                            $regno = $stud_form->getValue('register_no');
                            $name = $stud_form->getValue('name');
                            $sex = $stud_form->getValue('sex');
                            $atc_code = $stud_form->getValue('atc_code');
                            $district = $stud_form->getValue('district');
                            $course_code = $stud_form->getValue('course_code');
                            $date_of_join = $stud_form->getValue('date_of_join');
                            $stud_details=new Application_Model_DbTable_Students();
                            $stud_details->addStudent($regno, $name,$sex,$atc_code, $district, $course_code, $date_of_join);
                            echo "<script>alert('Student successfully added')</script>";
                        }
                        else
                        {
                        
                           echo "<script>alert('Invalid Data')</script>";
                        }
        
    }

    }


    }

    public function editstudAction()
    {
        $update_stud= new Application_Model_DbTable_Students();
        $row=$update_stud->retrieveStudentByRegNo(6435);
        if($row)
        {
            $stud_form = new Application_Form_StudentAdd();
            $stud_form->populate($row);
            $this->view->stud_form=$stud_form;
        }
        if ($this->getRequest()->isPost())
                {
                    $formdata = $this->getRequest()->getPost();

                    if ($stud_form->isValid($formdata))
                        {
                            $regno = $stud_form->getValue('register_no');
                            $name = $stud_form->getValue('name');
                            $sex = $stud_form->getValue('sex');
                            $atc_code = $stud_form->getValue('atc_code');
                            $district = $stud_form->getValue('district');
                            $course_code = $stud_form->getValue('course_code');
                            $date_of_join = $stud_form->getValue('date_of_join');

                            $updateddata = array(
                    'register_no' => $regno,
                    'name' => $name,
                    'sex' => $sex,
                    'atc_code' => $atc_code,
                    'district' => $district,
                    'course_code' => $course_code,
                    'date_of_join' => $date_of_join
                    );

                            $stud_details=new Application_Model_DbTable_Students();
                            //echo '<pre>'; print_r($formdata);
                            //exit;
                            $stud_details->editStudent($regno, $updateddata);
                        }

                }

    }


}















