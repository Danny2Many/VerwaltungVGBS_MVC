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
    
    public function RemoveObjects($object,$adminyear,$doctrine,$dependencies=null) {
    $explode=explode('/', $object);
    $namespace=$explode[2];
    $idprefix=$explode[1]; 
    $id1=$explode[0];
    $manager=$doctrine->getManager();
  

    if($dependencies!=null){
        
        foreach($dependencies as $depend){
            foreach($depend as $dep){

            
            $explode=explode('/', $dep);
            $namespace=$explode[2];
            $idprefix=$explode[1]; 
            $id=$explode[0];
            
            $dep->setValidto($adminyear);
            
            $qb=$doctrine->getRepository('AppBundle:'.$namespace)->createQueryBuilder('ditto');                
                $qb->where('ditto.validfrom>='.$adminyear)
                    ->andWhere('ditto.trainerid=:id')
                    ->setParameter('id', $id1);
                $deletedep[''.$dep.'']=$qb->getQuery()->getResult();
            }
        }
        
        foreach($deletedep as $dep){
            foreach($dep as $objecttobedeleted){
                $manager->remove($objecttobedeleted);
//              $this->RemoveObjects($dep, $adminyear, $doctrine);
            }
        }
    }    
        
        if($object->getValidto()== '2155'){
            
            if($object->getValidfrom()== $adminyear){
                $manager->remove($object);
            }else{    
                $object->setValidto($adminyear);
                $manager->persist($object);
            }
            
        }else{                

            $object->setValidto($adminyear);
            $manager->persist($object);                                

            $qb=$doctrine->getRepository('AppBundle:'.$namespace)->createQueryBuilder('ditto');                
            $qb->where('ditto.validfrom>='.$adminyear)
                ->andWhere('ditto.'.$idprefix.'id=:id')
                ->setParameter('id', $id1);
            $delete=$qb->getQuery()->getResult();

            foreach ($delete as $del){
                $manager->remove($del);
            }
        }
    }
    
}
