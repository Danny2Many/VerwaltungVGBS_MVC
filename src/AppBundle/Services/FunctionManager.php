<?php



namespace AppBundle\Services;


class FunctionManager {
    
//    protected $manager;
//
//    public function __contruct($manager) {
//        $this->manager=$manager;        
//    }
    
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
    
    public function AddObjects($object, $objectquerry, $querryclone, $idprefix, $adminyear, $manager, $getmethod){
        foreach( call_user_func(array($object, $getmethod)) as $ob){
                    $clone=$querryclone->get(call_user_func(array($object, $getmethod))->indexOf($ob));

                    if (false == in_array($ob, $objectquerry)) {                    
                        call_user_func(array($ob, 'set'.$idprefix.'id' ), uniqid($idprefix))
                                ->setValidfrom($adminyear)
                                ->setValidto('2155');
                        $manager->persist($ob); 

                        }else if($clone!=$ob){
                            if($adminyear!=$ob->getValidfrom()){                       

                                try{  
                                    $clone ->setValidto($adminyear); 
                                    $ob ->setValidfrom($adminyear); 
                                    $manager->persist($ob);
                                    $manager->flush();
                                    $manager->persist($clone);      
                                    $manager->flush();                                
                                }catch(Exception $em){ $em->getConnection()->rollback(); }

                            }else{ $manager->persist($ob); }  
                        }
                    }
    }
    
}
