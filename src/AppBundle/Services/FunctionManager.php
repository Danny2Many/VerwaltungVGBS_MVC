<?php



namespace AppBundle\Services;


class FunctionManager {
    
  
    
    protected $doctrine;
    protected $adminyear;
    public function __construct($doctrine, $adminyear) {
        $this->doctrine=$doctrine;
        $this->adminyear=$adminyear;
    } 
    
    
    
    
    public function HandleDependencyDiff($saveddependencies, $originaldependencies){
        $manager=$this->doctrine->getManager();
        
        
       
        
        
        foreach($saveddependencies  as $ob){
                     $explode=explode('/', $ob);
                     $idprefix=$explode[1]; 
                     $clone=$originaldependencies->get($saveddependencies->indexOf($ob));

                    if ($clone == NULL) {                    
                        call_user_func(array($ob, 'set'.$idprefix.'id' ), uniqid($idprefix));
                        call_user_func(array($ob, 'setValidfrom' ), $this->adminyear);
                        call_user_func(array($ob, 'setValidto' ), '2155');
                       
                        $manager->persist($ob); 

                        }else {
                            $this->HandleObjectDiff($ob, $clone);  
                        }
                    }
                    
                    
          foreach ($originaldependencies as $oridep) {
            $clone=$saveddependencies->get($originaldependencies->indexOf($oridep));
            
            if ($clone == NULL) {
         
                $explode=explode('/', $oridep);
                $id=$explode[0];
                $idprefix=$explode[1];
                $namespace=$explode[2];
                $validfrom=$oridep->getValidfrom();
                
                //you cannot call 'remove' on cloned objects
                //thats why we query for them again
                $objecttobedeleted=$manager->find('AppBundle:'.$namespace, array($idprefix.'id'=>$id, 'validfrom'=>$validfrom));
               
                $this->RemoveObjects($objecttobedeleted);
            }
        }
    }
    
    
    //compares 2 objects
    public function HandleObjectDiff($savedobject, $originalobject) {
        $manager=  $this->doctrine->getManager();
        
        
                    if($originalobject!=$savedobject){
                            if($this->adminyear != $savedobject->getValidfrom()){                       

                                try{  
                                    $originalobject ->setValidto($this->adminyear); 
                                    $savedobject ->setValidfrom($this->adminyear); 
                                    $manager->persist($savedobject);
                                    $manager->flush();
                                    $manager->persist($originalobject);      
                                    $manager->flush();                                
                                }catch(Exception $em){ 
                                    $em->getConnection()->rollback(); 
                                    
                                }

                            }else{ 
                                $manager->persist($savedobject); 
                                
                            }  
                        } 
    }
    
    
    
    
    
    
    public function RemoveObjects($object,$dependencies=null) {
        
        $explode=explode('/', $object);
    $namespace=$explode[2];
    $idprefix=$explode[1]; 
    $id=$explode[0];
    $manager=$this->doctrine->getManager();
  
 
    if($dependencies!=null){
        
        foreach($dependencies as $depend){
            foreach($depend as $dep){


                $this->RemoveObjects($dep);
            }
        }
        
    }    
        
        if($object->getValidto()== '2155'){
            
            if($object->getValidfrom()== $this->adminyear){
                $manager->remove($object);
            }else{    
                $object->setValidto($this->adminyear);
                $manager->persist($object);
            }
            
        }else{                

            $object->setValidto($this->adminyear);
            $manager->persist($object);                                

            $qb=$this->doctrine->getRepository('AppBundle:'.$namespace)->createQueryBuilder('ditto');                
            $qb->where('ditto.validfrom>='.$this->adminyear)
                ->andWhere('ditto.'.$idprefix.'id=:id')
                ->setParameter('id', $id);
            $delete=$qb->getQuery()->getResult();

            foreach ($delete as $del){
                $manager->remove($del);
            }
        }
    }
    
    
    
   
    
    function getAdminyear() {
        return $this->adminyear;
    }

    function setAdminyear($adminyear) {
        $this->adminyear = $adminyear;
    }

 
}
