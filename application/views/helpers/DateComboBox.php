<?php
class Application_View_Helper_DateComboBox extends Zend_View_Helper_Abstract
{
    /*public $view;

    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }*/

    /**
     *
     * @param <type> $name it will append in id and name of each field
     * @return string 
     * @description 
     */
    public function dateComboBox($name)
    {
        $curntDay=date('j');
        $curntMonth=date('n');
        $date = "<select name=\" ".$name ."_day\" id=\"".$name."-d\" style=\"width: 45px\">";
          for ($i = 1; $i <= 31; $i++) {
                                    if($i==$curntDay) { 
                            	
          $date.="<option value= $i selected> $i</option>";
                                 

                                    } else {
                                 
           $date.="<option value=$i>$i</option>";
                               }}
           $date.="</select><select name=\" ".$name ."_month\" id=\"".$name."-m\" style=\"width: 60px\">";
                            

                                for ($k = 1; $k <= 12; $k++) {
                                    $month_name = date( 'M', mktime(0, 0, 0, $k) );
                                         if($k==$curntMonth) {

                                
           $date.="<option value= $k selected>$month_name</option>";
                                   
                                         } else {
                                  
           $date.="<option value=$k>$month_name</option>";
                                    }}
           $date.="</select><select name=\" ".$name ."_year\" id=\"".$name."-y\" style=\"width: 60px\">";
                          
                            $dateYear = 1975;
                            //$lastYear = ($dateYear+50);
                            for ($j = $dateYear; $j <=2050; $j++) {

                            	 if($j==$dateYear) {
                            	  
           $date.="<option value=$j selected> $j</option>";
                            	
                            	 } else {
                            	
           $date.="<option value= $j>$j</option>";
                             }}

           $date.="</select>";
        
        return $date;
    }
}