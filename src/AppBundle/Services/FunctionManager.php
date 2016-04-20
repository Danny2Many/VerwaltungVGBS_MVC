<?php



namespace AppBundle\Services;


class FunctionManager {
    
    //compares 2 entities in my own way
    public function CompareEntities($entityone, $entitytwo) {
      $entityoneattr=  get_object_vars($entityone);
      $entitytwoattr=  get_object_vars($entitytwo);
      
      print_r($entityoneattr);
      
      $result=  array_diff($entityoneattr, $entitytwoattr);
      
      
      
      if($result==''){
      
      return true;
      }
      else{
          return false;
      }
    }
    
    
}
