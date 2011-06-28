<?php

class CenterController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        if(!Zend_Auth::getInstance()->hasIdentity())
        {
            $this->_helper->redirector('Index','index');
        }
        else{
            
            $centers = new Application_Model_DbTable_Centers();
            $centerDetails = $centers->getCenterDetails();//Getting Center details
            $centerDetails = $centerDetails->toArray();
            $this->view->centerDetails = $centerDetails;
            
            $centerCategory = new Application_Model_DbTable_Centercategory();
            $categoryDetails = $centerCategory->getCategory();//Getting Category List
            $this->view->categoryDetails = $categoryDetails;
            
            $addCategoryForm = new Application_Form_Addcategory();
            $this->view->addCategoryForm = $addCategoryForm;

            $Searchcenter = new Application_Form_Searchcenter();
            $this->view->Searchcenter = $Searchcenter;
            
        }//End else
        
    }

    public function addcenterAction()
    {
        $form = new Application_Form_Addcenter();
        $centerCategory = new Application_Model_DbTable_Centercategory();
        $options = $centerCategory->getCategory();
        foreach ($options AS $option)
        {
            $form->atcCategoryCode->addMultioption($option['code'],$option['name']);
        }
        $this->view->form = $form;
        $request = $this->getRequest();
        if($request->isPost())
        {
            if($form->isValid($request->getPost()))
            {
                //Getting values from form
                $atcCode = $request->getPost('atcCode');
                $atcName= $request->getPost('atcName');
                $atcAddress= $request->getPost('atcAddress');
                $atcDistrict= $request->getPost('atcDistrict');
                $atcState= $request->getPost('atcState');
                $atcPincode= $request->getPost('atcPincode');
                $atcCategoryCode= $request->getPost('atcCategoryCode');
                $reg_day= $request->getPost('reg_day');
                $reg_month= $request->getPost('reg_month');
                $reg_year= $request->getPost('reg_year');
                $datearray = array('year' => $reg_year,
                   'month' => $reg_month,
                   'day' => $reg_day,
                   );
                $date = new Zend_Date($datearray);
                $regDate = $date->get('yyyy-MM-dd');
                $center = new Application_Model_DbTable_Centers();
                $status = $center->addCenter($atcCode, $atcName, $atcAddress, $atcDistrict, $atcState, $atcPincode, $atcCategoryCode, $regDate);
                if($status)
                 {
                    if($status=='INVALID_PRIMARYKEY')
                    {
                        $this->view->status = 'Error.. Entered ATC code is already on your record..';
                    }
                    else
                    {
                        $form->reset();
                        $this->view->success = 'Successfully added a center....!! ';
                    }
                }
                else{
                    $this->view->status = 'Something Went wrong';
                }
            }
        
        }
    }

    public function ajaxaddcategoryAction()
    {
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender();
        $form = new Application_Form_Addcategory();
        $request = $this->getRequest();
        if($request->isPost())
        {
            
            if($form->isValid($request->getPost()))
            {     
                $centerCategory = new Application_Model_DbTable_Centercategory();
                $categoryName = $request->getPost('categoryName');
                $status = $centerCategory->addCategory($categoryName);
                if($status=='DUPLICATE_NAME')
                {
                    $msg = 'Entered category name is already on your record';
                    echo $msg;
                }
                else if($status){
                    
                    $msg ='Data saved!!!         ID : ' . $status . '      Name : ' . $categoryName;
                    echo $msg;
                }
                else
                {
                    $msg = 'Something went wrong.. please try again';
                    echo $msg;
                }
            }
            else{
                  $errorMessages = $form->getMessages();
                  $msg = '';
                  foreach ($errorMessages AS $errorMessage)
                  {
                      foreach ($errorMessage AS $eacherror)
                              $msg .= $eacherror;
                  }
                   
                  echo $msg;
            }
            
        }
        else //Request is not POST
        {
            echo "Something Went wrong.. please try again";
        }
        
    }

    public function searchAction()
    {
        $Searchcenter = new Application_Form_Searchcenter();
        $this->view->Searchcenter = $Searchcenter;

        $request = $this->getRequest();
        if($request->isPost()){
            $query = $request->getPost('searchCenterQueryBox');
            $option = $request->getPost('searchCenterOption');

            $center = new Application_Model_DbTable_Centers();
            $searchResults = $center->searchCenter($query, $option);
            $this->view->searchResults = $searchResults;
            $this->view->searchQuery = $query;
        }
    }


}







