<?php

use AppBundle\Services\IndexManager;
namespace AppBundle\Services;


class FunctionManager {
    
  
    
    protected $doctrine;
    protected $adminyear;
    
    public function __construct($doctrine, $adminyear) {
        $this->doctrine=$doctrine;
        $this->adminyear=$adminyear;
    } 
    
    //analizes the __toString return value of an object
    public function ObjectMetaDataParser($object) {
        $metadata=explode('/', $object);
        return array('id'=>$metadata[0], 'idprefix'=>$metadata[1], 'namespace'=>$metadata[2]);
    }
    
    
    //handles the comparison of the dependencies after saving
    public function HandleDependencyDiff($saveddependencies, $originaldependencies, $many2manyentity=null){
        $manager=$this->doctrine->getManager();
        
        foreach($saveddependencies  as $ob){
                     
                     
                     //get the original object version
                     $clone=$originaldependencies->get($saveddependencies->indexOf($ob));
                     
                     //if an new referencing object was created
                    if ($clone == NULL) { 
                        
                        $this->AddObject($ob, 'secondary',$many2manyentity);

                        }else {
                            $originaldependencies->removeElement($clone);
                            $this->HandleObjectDiff($ob, $clone);  
                        }
                    }
                    
                    
          foreach ($originaldependencies as $oridep) {
            $clone=$saveddependencies->get($originaldependencies->indexOf($oridep));
            
            if ($clone == NULL) {
                $depmetadata=  $this->ObjectMetaDataParser($oridep);
                
                $validfrom=$oridep->getValidfrom();
                
                //you cannot call 'remove' on cloned objects
                //thats why we query for them again
                if ($many2manyentity != null){
                    $objecttobedeleted=$manager->find($many2manyentity['entitypath'], array($depmetadata['idprefix'].'id'=>$depmetadata['id'], $many2manyentity['idprefixone'].'id' => $many2manyentity['idone'], 'validfrom'=>$validfrom));
                }else{
                    $objecttobedeleted=$manager->find('AppBundle:'.$depmetadata['namespace'], array($depmetadata['idprefix'].'id'=>$depmetadata['id'], 'validfrom'=>$validfrom));
                }
                
                $this->RemoveObject($objecttobedeleted);
            }
        }
    }
    
    
    //handles the comparison of an object after saving
    public function HandleObjectDiff($savedobject, $originalobject, $many2many=null) {
        $manager=  $this->doctrine->getManager();
        
                if($many2many==null){
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
                }else{

                    if($originalobject!=$savedobject){

//                            if($this->adminyear != $savedobject->getValidfrom()){ 

                                $metadata= $this->ObjectMetaDataParser($originalobject);
                                
                                $M2MObject=$manager->find($many2many['entitypath'], array($metadata['idprefix'].'id'=>$metadata['id'], $many2many['idprefixone'].'id' => $many2many['idone'], 'validfrom'=>$originalobject->getValidfrom()));

                                $M2MObject->setSgid($savedobject->getSgid());
                                call_user_func(array($M2MObject, 'set'.$metadata['idprefix'].'id' ), call_user_func(array($savedobject, 'get'.$metadata['idprefix'].'id')));
                                $manager->persist($M2MObject); 
                                $manager->flush();
                                
                                
//                            }else{ 
//                                $manager->persist($savedobject);                                 
//                            }  
                        } 
                    
                }
    }
    
    //sets Validfrom and Validto dates and persists an object
    //primarytype=objects with database-indices
    //secondarytype=objects with timestamp-indices
    public function AddObject($object, $type='primary', $many2many=null) {
        $manager=  $this->doctrine->getManager();
        $metadata= $this->ObjectMetaDataParser($object);
     
        //$many2manyentity==null --> one2many relationship
        if($many2many==null){   
            if($type=='primary'){

                $explode=explode('\\', get_class($object));
                $entityname=  end($explode);

                $im= new IndexManager($manager, $entityname);
                $id=$im->getCurrentIndex();

            }elseif($type=='secondary'){

              $id=uniqid($metadata['idprefix']);  
            }

                call_user_func(array($object, 'set'.$metadata['idprefix'].'id' ), $id);
                call_user_func(array($object, 'setValidfrom' ), $this->adminyear);
                call_user_func(array($object, 'setValidto' ), '2155');

                $manager->persist($object);
        }else{
            $middle= new $many2many['entitypath']();
            call_user_func(array($middle, 'set'.$many2many['idprefixone'].'id' ), $many2many['idone']);
            call_user_func(array($middle, 'set'.$metadata['idprefix'].'id' ), $metadata['id']);
            call_user_func(array($middle, 'setValidfrom' ), $this->adminyear);
            call_user_func(array($middle, 'setValidto' ), '2155');
            
            $manager->persist($middle);

        }
    }
    
    
    
    //'removes' an object
    public function RemoveObject($object,$dependencies=null) {
    $metadata=  $this->ObjectMetaDataParser($object); 
       
    $manager=$this->doctrine->getManager();
  
    //if the object has dependencies
    if($dependencies!=null){        
            foreach($dependencies as $dependi){           

            $qb=$this->doctrine->getRepository('AppBundle:'.$dependi)->createQueryBuilder('ditto');                
            $qb->where('ditto.validto>='.$this->adminyear)
                ->andWhere('ditto.'.$metadata['idprefix'].'id=:id')
                ->setParameter('id', $metadata['id']);
            $dependencies_[]=$qb->getQuery()->getResult();
        
            }
        foreach($dependencies_ as $depend){           

            foreach($depend as $dep){

                $this->RemoveObject($dep);

            }
        }        
    }    
        // if its still valid
        if($object->getValidto()== '2155'){

            if($object->getValidfrom()>= $this->adminyear){
                $manager->remove($object);
            }else{    

                $object->setValidto($this->adminyear);
                $manager->persist($object);
            }
        }else{                

            $object->setValidto($this->adminyear);
            $manager->persist($object);                                

            $qb=$this->doctrine->getRepository('AppBundle:'.$metadata['namespace'])->createQueryBuilder('ditto');                
            $qb->where('ditto.validfrom>='.$this->adminyear)
                ->andWhere('ditto.'.$metadata['idprefix'].'id=:id')
                ->setParameter('id', $metadata['id']);
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
