<?php

namespace AppBundle\Services;


class IndexManager{
  
    protected $entityname;
    
    protected $em;
    
    public function __construct($entityManager, $entityname) {

      $this->em=$entityManager;
      $this->entityname=$entityname;
    }
    
    public function add($number=1){
        $indexentity=$this->getIndexEntity();      
        $index=$indexentity->setIndex($indexentity->getCurrentindex()+$number);
        
        $this->em->persist($index);
        $this->em->flush($index);
        
        return $this;
    }
    
    
    public function remove($number=1){        
        
        $index=$this->getIndexEntity()->setIndex($this->getCurrentIndex()-$number);
        
        $this->em->persist($index);
        $this->em->flush($index);
        
        return $this;
    }
    
    
    public function getCurrentIndex(){
        

        return $this->getIndexEntity()->getCurrentindex();
    }
    
    
    
    
    function setEntityName($entityname) {
        $this->entityname = $entityname;
        
        return $this;
    }

        

    public function getEntityName(){
        
        return $this->entityname;
    }
    
   
    
     
    
    
    public function getIndexEntity(){
        $qb=  $this->em->createQueryBuilder();
        $qb ->select('ditto')
            ->from('AppBundle:Indices', 'ditto')
            ->where('ditto.tablename=:tablename')
            ->setParameter('tablename', $this->getEntityName());
        
        
        $index=$qb->getQuery()->getSingleResult();
        
        if($index){
        return $index;
        }
        else{
            throw new Exception('Existiert nüscht!!<(^^<)!!');
        }
    }
}
