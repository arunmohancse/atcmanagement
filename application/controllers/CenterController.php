<?php

class CenterController extends Zend_Controller_Action
{
    /**
     * @name Constants declaration
     */
        //Initializing values for pagination(Listing center details)
        const ITEM_COUNT_PER_PAGE = 2; //How many items will be displayed in one page
        const SET_PAGE_RANGE = 2; //Maximum number of navigations per page eg: <previous 1 2 3 Next>
        const PAGINATION_STYLE = 'Sliding'; //@values 'Elastic' and 'Sliding' . In order to decide which page numbers need to be displayed on screen

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
            $centerDetails = $centers->getCenterDetailsSelectQuery();//Getting Center details
            
            //Pagination part
            $paginator = Zend_Paginator::factory($centerDetails);
            $paginator->setCurrentPageNumber($this->_getParam("page"));
            $paginator->setItemCountPerPage($this::ITEM_COUNT_PER_PAGE);
            $paginator->setPageRange($this::SET_PAGE_RANGE);
            $this->view->centerDetails = $paginator;
            $this->view->paginationStyle = $this::PAGINATION_STYLE;
            
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
                $atcName = $request->getPost('atcName');
                $atcAddress = $request->getPost('atcAddress');
                $atcDistrict = $request->getPost('atcDistrict');
                $atcState = $request->getPost('atcState');
                $atcPincode = $request->getPost('atcPincode');
                $atcCategoryCode = $request->getPost('atcCategoryCode');
                $atcContactNumber1 = $request->getPost('atcContactNumber1');
                $atcContactNumber2 = $request->getPost('atcContactNumber2');
                $atcContactNumber3 = $request->getPost('atcContactNumber3');
                $atcContactNumber4 = $request->getPost('atcContactNumber4');
                $reg_day = $request->getPost('reg_day');
                $reg_month = $request->getPost('reg_month');
                $reg_year = $request->getPost('reg_year');
                $datearray = array('year' => $reg_year,
                   'month' => $reg_month,
                   'day' => $reg_day,
                   );
                $date = new Zend_Date($datearray);
                $regDate = $date->get('yyyy-MM-dd');
                $center = new Application_Model_DbTable_Centers();
                $status = $center->addCenter($atcCode, $atcName, $atcAddress, $atcDistrict, $atcState, $atcPincode, $atcCategoryCode, $regDate,$atcContactNumber1,$atcContactNumber2,$atcContactNumber3,$atcContactNumber4);
                if($status)
                 {
                    if($status=='INVALID_PRIMARYKEY')
                    {
                        $this->view->status = 'Error.. Entered ATC code is already on your record..';
                    }
                    else
                    {
                        $form->reset();
                        $this->view->success = 'Successfully added....!! ';
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
    public function editcenterAction()
    {
        $request = $this->getRequest();
        $code = $request->getParam('id');
        if(!$code){ echo "there is no code"; exit;}
        $centers = new Application_Model_DbTable_Centers();
        $centerDetails = $centers->getCenterDetails($code);
        $form = new Application_Form_Addcenter();
        $this->view->form = $form;
        $form->submit->setLabel('Update');
        if(!$centerDetails->toArray()){
          
        }
        else{
            
            $centerCategory = new Application_Model_DbTable_Centercategory();
            $options = $centerCategory->getCategory();
            foreach ($options AS $option)
            {
                $form->atcCategoryCode->addMultioption($option['code'],$option['name']);
            }
            $centerDetails = $centerDetails->toArray();
            
            $form->atcCode->setValue($centerDetails[0]['code']);
            $form->atcName->setValue($centerDetails[0]['name']);
            $form->atcAddress->setValue($centerDetails[0]['address']);
            $form->atcDistrict->setValue($centerDetails[0]['district']);
            $form->atcState->setValue($centerDetails[0]['state']);
            $form->atcPincode->setValue($centerDetails[0]['pincode']);
            $form->atcContactNumber1->setValue($centerDetails[0]['contact_number1']);
            $form->atcContactNumber2->setValue($centerDetails[0]['contact_number2']);
            $form->atcContactNumber3->setValue($centerDetails[0]['contact_number3']);
            $form->atcContactNumber4->setValue($centerDetails[0]['contact_number4']);

            if($request->isPost())
            {
                if($form->isValid($request->getPost()))
                {
                    //Getting values from form
                    $atcCode = $request->getPost('atcCode');
                    $atcName = $request->getPost('atcName');
                    $atcAddress = $request->getPost('atcAddress');
                    $atcDistrict = $request->getPost('atcDistrict');
                    $atcState = $request->getPost('atcState');
                    $atcPincode = $request->getPost('atcPincode');
                    $atcCategoryCode = $request->getPost('atcCategoryCode');
                    $atcContactNumber1 = $request->getPost('atcContactNumber1');
                    $atcContactNumber2 = $request->getPost('atcContactNumber2');
                    $atcContactNumber3 = $request->getPost('atcContactNumber3');
                    $atcContactNumber4 = $request->getPost('atcContactNumber4');
                    $reg_day = $request->getPost('reg_day');
                    $reg_month = $request->getPost('reg_month');
                    $reg_year = $request->getPost('reg_year');
                    $datearray = array('year' => $reg_year,
                       'month' => $reg_month,
                       'day' => $reg_day,
                       );
                    $date = new Zend_Date($datearray);
                    $regDate = $date->get('yyyy-MM-dd');
                    $center = new Application_Model_DbTable_Centers();
                    $status = $center->updateCenter($atcCode, $atcName, $atcAddress, $atcDistrict, $atcState, $atcPincode, $atcCategoryCode, $regDate,$atcContactNumber1,$atcContactNumber2,$atcContactNumber3,$atcContactNumber4);
                    if($status)
                     {
                        if($status=='INVALID_PRIMARYKEY')
                        {
                            $this->view->status = 'Error.. Entered ATC code is already on your record..';
                        }
                        else
                        {
                            $form->reset();
                            $this->view->success = 'Successfully added....!! ';
                        }
                    }
                    else{
                        $this->view->status = 'Something Went wrong';
                    }
                }

            }
        }//End else for invalid code
    }


}









